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
        $page = 'admin.announcement.add';
        $title = 'General Setting';
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

        $adminId = 1;
        foreach ($users as $token) {

            send_notification_FCM_and($token->device_token, $notificationData);

            $database = Firebase::database();
            $data = $database->getReference('/users/' . $token->user_id)->getValue();
            $generateConversationId =   generateConversationId([$token->user_id, $adminId]);
            if ($data == null) {


                $dataToOverview[$generateConversationId] = [
                    'contactId' => $adminId,
                    'contactName' =>  'Team Traditional Chat',
                    'conversationId' => $generateConversationId,
                    'lastMessage' => $request->input('message'),
                    'lastSenderId' => $adminId,
                    'receiverProfile' => asset('public/admin/assets/logo/logo.png'),
                    "timeStamp" => Carbon::now(),
                    "unRead" => true,
                    "unReadCount" => 0
                ];
                $data = $database->getReference('/users/' . $token->user_id)->update($dataToOverview);
                // $update = $data->update($fieldsToUpdate);
            } else {

                $checkConversationId = $database->getReference('/users/' . $token->user_id)->getValue();
                dd($token->user_id, $checkConversationId);
                if ($generateConversationId)
                    $dataToOverview[$generateConversationId] = [
                        'contactId' => $adminId,
                        'contactName' =>  'Team Traditional Chat',
                        'conversationId' => $generateConversationId,
                        'lastMessage' => $request->input('message'),
                        'lastSenderId' => $adminId,
                        'receiverProfile' => asset('public/admin/assets/logo/logo.png'),
                        "timeStamp" => Carbon::now(),
                        "unRead" => true,
                        "unReadCount" => 0
                    ];
                $data = $database->getReference('/users/' . $token->user_id)->update($dataToOverview);
            }
        }
        toastr()->success('Notify successfully !');
        return redirect()->route('announcement.index');
    }

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
