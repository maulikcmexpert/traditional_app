<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Device;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Kreait\Laravel\Firebase\Facades\Firebase;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

class AnnouncementController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {


        send_notification_FCM('cHXV3gK_9kIqpG1D0h2aW7:APA91bHXLLwGkpNTe2X8XTFnkNaLiZJFtLbTpM_uUUrecZUMMUmj3zzkQ8ZmbnS_F_k8y_SK7qyzIYZ3x6V_0M8ftsXJcUkUBzn5lORktbw2cIu3eSXp17Vt1vYx_pPrkfqhlWbEUVXh', 'hii');
        exit;
        $page = 'admin.announcement.add';
        $title = 'General Announcement';
        $js = 'admin.announcement.scriptjs';
        return view('layouts.layout', compact('page', 'title', 'js'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $users = Device::all();

        $notificationData = [
            "type" => $request->input('type'),
            "message" => $request->input('message')
        ];

        $adminId = "1";

        foreach ($users as $key => $token) {
            if ($token->model == 'ios') {
                send_notification_FCM($token->device_token, $notificationData);
            } else {
                send_notification_FCM_and($token->device_token, $notificationData);
            }

            $database = Firebase::database();
            $data = $database->getReference('/Overview/' . $token->user_id)->getValue();

            $generateConversationId = generateConversationId([$token->user_id, $adminId]);
            $dataToOverview = [];

            if ($data == null) {
                // Create new overview entry if it doesn't exist
                $dataToOverview[$generateConversationId] = [
                    'contactId' => $adminId,
                    'contactName' =>  'Team Traditional Chat',
                    'conversationId' => $generateConversationId,
                    'lastMessage' => $request->input('message'),
                    'lastSenderId' => $adminId,
                    'receiverProfile' => asset('public/admin/assets/logo/logo.png'),
                    'timeStamp' => Carbon::now()->timestamp * 1000,
                    "unRead" => true,
                    "unReadCount" => 1
                ];
                $database->getReference('/Overview/' . $token->user_id)->update($dataToOverview);
            } else {
                // Update existing overview entry if it exists
                $getExistConversationId = array_keys($data);
                if (!in_array($generateConversationId, $getExistConversationId)) {
                    $dataToOverview[$generateConversationId] = [
                        'contactId' => $adminId,
                        'contactName' =>  'Team Traditional Chat',
                        'conversationId' => $generateConversationId,
                        'lastMessage' => $request->input('message'),
                        'lastSenderId' => $adminId,
                        'receiverProfile' => asset('public/admin/assets/logo/logo.png'),
                        'timeStamp' => Carbon::now()->timestamp * 1000,
                        "unRead" => true,
                        "unReadCount" => 1
                    ];
                    $database->getReference('/Overview/' . $token->user_id)->update($dataToOverview);
                } else {

                    $dataToOverview = $data;
                    $dataToOverview[$generateConversationId]['lastMessage'] = $request->input('message');
                    $dataToOverview[$generateConversationId]['timeStamp'] = Carbon::now()->timestamp * 1000;
                    $dataToOverview[$generateConversationId]["unRead"] = true;
                    $dataToOverview[$generateConversationId]["unReadCount"] += 1;
                    $database->getReference('/Overview/' . $token->user_id)->update($dataToOverview);
                }
            }




            // Append to existing messages
            $messageKey = $database
                ->getReference('Messages')
                ->getChild($generateConversationId)
                ->getChild('message')
                ->push()
                ->getKey();


            $messageData = [
                'data' => $request->input('message'),
                'isSeen' => false,
                'receiverId' => str($token->user_id),
                'senderId' => $adminId,
                'status' => [
                    $token->user_id => 'unread',
                    $adminId => 'read',
                ],
                'timeStamp' => Carbon::now()->timestamp * 1000
            ];
            $setUser = [

                str($token->user_id),
                $adminId

            ];


            $database
                ->getReference('Messages')
                ->getChild($generateConversationId)
                ->getChild('users')
                ->set($setUser);

            $database
                ->getReference('Messages')
                ->getChild($generateConversationId)
                ->getChild('message')
                ->getChild($messageKey)
                ->set($messageData);
        }

        toastr()->success('Notify successfully !');
        return redirect()->route('announcement.index');
    }

    // public function store(Request $request)
    // {
    //     $users = Device::all();

    //     $notificationData = [
    //         "type" => $request->input('type'),
    //         "message" => $request->input('message')
    //     ];

    //     $adminId = "1";

    //     foreach ($users as  $key => $token) {

    //         send_notification_FCM_and($token->device_token, $notificationData);

    //         $database = Firebase::database();
    //         $data = $database->getReference('/Overview/' . $token->user_id)->getValue();

    //         $generateConversationId = "";
    //         $generateConversationId =   generateConversationId([$token->user_id, $adminId]);
    //         $dataToOverview = [];
    //         if ($data == null) {
    //             $dataToOverview[$generateConversationId] = [
    //                 'contactId' => $adminId,
    //                 'contactName' =>  'Team Traditional Chat',
    //                 'conversationId' => $generateConversationId,
    //                 'lastMessage' => $request->input('message'),
    //                 'lastSenderId' => $adminId,
    //                 'receiverProfile' => asset('public/admin/assets/logo/logo.png'),
    //                 'timeStamp' => Carbon::now()->timestamp * 1000,
    //                 "unRead" => true,
    //                 "unReadCount" => 1
    //             ];
    //             $database->getReference('/Overview/' . $token->user_id)->update($dataToOverview);
    //             // $update = $data->update($fieldsToUpdate);

    //             $messageData = $database->getReference('/Messages/')->getValue();
    //             $getExistMessageConversationId = array_keys($messageData);
    //             if (!in_array($generateConversationId, $getExistMessageConversationId)) {
    //                 $messageKey  = $database
    //                     ->getReference('Messages')
    //                     ->getChild($generateConversationId)
    //                     ->getChild('message')
    //                     ->push()
    //                     ->getKey();

    //                 $messageData = [
    //                     'data' => $request->input('message'),
    //                     'isSeen' => false,
    //                     'receiverId' => $token->user_id,
    //                     'senderId' => $adminId,
    //                     'status' => [
    //                         $token->user_id => 'unread',
    //                         $adminId => 'read',
    //                     ],
    //                     'timeStamp' => Carbon::now()->timestamp * 1000
    //                 ];
    //                 $database
    //                     ->getReference('Messages')
    //                     ->getChild($generateConversationId)
    //                     ->getChild('message')
    //                     ->getChild($messageKey)
    //                     ->set($messageData);
    //             }
    //         } else {
    //             $getExistConversationId = array_keys($data);
    //             if (!in_array($generateConversationId, $getExistConversationId)) {

    //                 $dataToOverview[$generateConversationId] = [
    //                     'contactId' => $adminId,
    //                     'contactName' =>  'Team Traditional Chat',
    //                     'conversationId' => $generateConversationId,
    //                     'lastMessage' => $request->input('message'),
    //                     'lastSenderId' => $adminId,
    //                     'receiverProfile' => asset('public/admin/assets/logo/logo.png'),
    //                     'timeStamp' => Carbon::now()->timestamp * 1000,
    //                     "unRead" => true,
    //                     "unReadCount" => 1
    //                 ];
    //                 $database->getReference('/Overview/' . $token->user_id)->update($dataToOverview);

    //                 $messageData = $database->getReference('/Messages/')->getValue();
    //                 $getExistMessageConversationId = array_keys($messageData);
    //                 $setUser['users'] = [];
    //                 if (!in_array($generateConversationId, $getExistMessageConversationId)) {
    //                     $messageKey  = $database
    //                         ->getReference('Messages')
    //                         ->getChild($generateConversationId)
    //                         ->getChild('message')
    //                         ->push()
    //                         ->getKey();

    //                     $messageData = [
    //                         'data' => $request->input('message'),
    //                         'isSeen' => false,
    //                         'receiverId' => str($token->user_id),
    //                         'senderId' => $adminId,
    //                         'status' => [
    //                             $token->user_id => 'unread',
    //                             $adminId => 'read',
    //                         ],
    //                         'timeStamp' => Carbon::now()->timestamp * 1000,

    //                     ];
    //                     $setUser['users'] = [

    //                         str($token->user_id),
    //                         $adminId

    //                     ];
    //                     $database
    //                         ->getReference('Messages')
    //                         ->getChild($generateConversationId)
    //                         ->set($setUser)
    //                         ->getChild('message')
    //                         ->getChild($messageKey)
    //                         ->set($messageData);
    //                 }
    //             }
    //         }
    //     }

    //     toastr()->success('Notify successfully !');
    //     return redirect()->route('announcement.index');
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
