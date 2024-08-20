<?php

use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\{
    Notification,
    User,
    Device
};
use Kreait\Laravel\Firebase\Facades\Firebase;

function distanceCalculation($latitude1, $longitude1, $latitude2, $longitude2)
{

    $p1 = deg2rad($latitude1);
    $p2 = deg2rad($latitude2);
    $dp = deg2rad($latitude2 - $latitude1);
    $dl = deg2rad($longitude2 - $longitude1);
    $a = (sin($dp / 2) * sin($dp / 2)) + (cos($p1) * cos($p2) * sin($dl / 2) * sin($dl / 2));
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $r = 6371008; // Earth's average radius, in meters
    $d = $r * $c;
    return ($d / 1000);
}

function calculateAge($birthdate)
{
    $endDate = date('Y-m-d');
    // Create a DateTime object from the birthdate
    $birthDateObj = new DateTime($birthdate);

    // If an end date is not provided, use the current date
    $endDateObj = ($endDate != null) ? new DateTime($endDate) : new DateTime();

    // Calculate the difference between the birthdate and end date
    $ageInterval = $birthDateObj->diff($endDateObj);

    // Return the years part of the interval
    return $ageInterval->y;
}

function setpostTime($dateTime)
{

    $commentDateTime = $dateTime; // Replace this with your actual timestamp

    // Convert the timestamp to a Carbon instance
    $commentTime = Carbon::parse($commentDateTime);

    // Calculate the time difference
    $timeAgo = $commentTime->diffForHumans(); // This will give the time ago format


    // Display the time ago
    return $timeAgo;
}

function isNotNullOrBlank($value)
{
    return !is_null($value) && !empty(trim($value));
}

function isNullOrBlank($value)
{
    return is_null($value) && empty(trim($value));
}

function addNotificationCount($userId)
{
    $database = Firebase::database();
    $data = $database->getReference('/users/' . $userId . '/notificationCount/')->getValue();
    if ($data == null) {
        $fieldsToUpdate = ['notificationCount' => 1];
        $data = $database->getReference('/users/' . $userId)->update($fieldsToUpdate);
        // $update = $data->update($fieldsToUpdate);
    } else {

        $fieldsToUpdate = ['notificationCount' => $data + 1];
        $data = $database->getReference('/users/' . $userId)->update($fieldsToUpdate);
    }
}

function updateProfileOnFirebase($userId, $profileUrl)
{
    $database = Firebase::database();
    $data = $database->getReference('/users/' . $userId . '/userProfile/')->getValue();

    if ($data != null) {
        $profileUpdate = ['userProfile' => $profileUrl];
        $data = $database->getReference('/users/' . $userId)->update($profileUpdate);
    }
}
function notification($notificationData)
{

    if ($notificationData['notify_for'] == 'approach_request') {

        $notification = new Notification();
        $notification->user_id  = $notificationData['receiver_id'];
        $notification->sender_id = $notificationData['sender_id'];
        $notification->notification_type = $notificationData['type'];
        $notification->message = 'Hey! you got connection approach from  $NAME';
        $notification->status = $notificationData['status'];
        if ($notification->save()) {

            // firebase count add //
            addNotificationCount($notificationData['receiver_id']);
            // firebase count add //
            $deviceToken = Device::where('user_id', $notificationData['receiver_id'])->first();
            if ($deviceToken != null) {
                $user = User::where('id', $notificationData['sender_id'])->first();
                $notificationData['notification_message'] = 'Hey! you got connection approach from ' . $user->full_name;
                if ($deviceToken->model == 'ios') {
                    send_notification_FCM($deviceToken->device_token, $notificationData);
                } else {
                    send_notification_FCM_and($deviceToken->device_token, $notificationData);
                }
            }
        }
    }

    if ($notificationData['notify_for'] == 'friend_request') {

        $notification = new Notification();
        $notification->user_id  = $notificationData['receiver_id'];
        $notification->sender_id = $notificationData['sender_id'];
        $notification->notification_type = $notificationData['type'];
        $notification->message = '$NAME wants to talk with you';
        $notification->status = $notificationData['status'];
        if ($notification->save()) {
            // firebase count add //
            addNotificationCount($notificationData['receiver_id']);
            // firebase count add //
            $deviceToken = Device::where('user_id', $notificationData['receiver_id'])->first();
            if ($deviceToken != null) {
                $user = User::where('id', $notificationData['sender_id'])->first();
                $notificationData['notification_message'] = $user->full_name . ' wants to talk with you';

                if ($deviceToken->model == 'ios') {
                    send_notification_FCM($deviceToken->device_token, $notificationData);
                } else {
                    send_notification_FCM_and($deviceToken->device_token, $notificationData);
                }
            }
        }
    }

    if ($notificationData['notify_for'] == 'cancel_request') {

        Notification::where(['user_id' => $notificationData['receiver_id'], 'sender_id' => $notificationData['sender_id'], 'notification_type' => 'approach', 'status' => 'pending'])->delete();
        Notification::where(['user_id' => $notificationData['receiver_id'], 'sender_id' => $notificationData['sender_id'], 'notification_type' => 'friend', 'status' => 'pending'])->delete();
        $notification = new Notification();
        $notification->user_id  = $notificationData['receiver_id'];
        $notification->sender_id = $notificationData['sender_id'];
        $notification->notification_type = $notificationData['type'];
        if ($notificationData['type'] == 'approach') {

            $notification->message = 'After initiating an approach request, $NAME has cancelled the request.';
        } else if ($notificationData['type'] == 'friend') {

            $notification->message = 'After initiating an friend request, $NAME has cancelled the request.';
        }
        $notification->status = $notificationData['status'];
        if ($notification->save()) {
            // firebase count add //
            addNotificationCount($notificationData['receiver_id']);
            // firebase count add //
            $deviceToken = Device::where('user_id', $notificationData['receiver_id'])->first();
            $user = User::where('id', $notificationData['sender_id'])->first();
            if ($notificationData['type'] == 'approach') {

                $notificationData['notification_message'] = 'After initiating an approach request, ' . $user->full_name . ' has cancelled the request.';
            } else if ($notificationData['type'] == 'friend') {

                $notificationData['notification_message'] = 'After initiating an friend request, ' . $user->full_name . ' has cancelled the request.';
            }


            if ($deviceToken != null) {
                if ($deviceToken->model == 'ios') {
                    send_notification_FCM($deviceToken->device_token, $notificationData);
                } else {
                    send_notification_FCM_and($deviceToken->device_token, $notificationData);
                }
            }
        }
    }
    if ($notificationData['notify_for'] == 'accept_or_reject') {

        Notification::where(['user_id' => $notificationData['sender_id'], 'sender_id' => $notificationData['receiver_id'], 'notification_type' => 'approach', 'status' => 'pending'])->delete();
        Notification::where(['user_id' => $notificationData['sender_id'], 'sender_id' => $notificationData['receiver_id'], 'notification_type' => 'friend', 'status' => 'pending'])->delete();
        $notification = new Notification();
        $notification->user_id  = $notificationData['receiver_id'];
        $notification->sender_id = $notificationData['sender_id'];
        $notification->notification_type = $notificationData['type'];
        $user = User::where('id', $notificationData['sender_id'])->first();
        if ($notificationData['status'] == 'rejected') {
            addNotificationCount($notificationData['receiver_id']);
            if ($notificationData['type'] == 'friend') {
                $notification->message = "\$NAME rejected your friend request";
                $notificationData['notification_message'] = $user->full_name . " rejected your friend request";
            } elseif ($notificationData['type'] == 'approach') {
                $notification->message = "\$NAME rejected your approach 🚫💔 - '" . $notificationData['message'] . "'";
                $notificationData['notification_message'] = $user->full_name . " rejected your approach 🚫💔 - '" . $notificationData['message'] . "'";
            }
        }
        if ($notificationData['status'] == 'accepted') {
            // firebase count add //
            addNotificationCount($notificationData['receiver_id']);
            // firebase count add //
            $reciverUser = User::where('id', $notificationData['receiver_id'])->first();
            $notification->message = 'Hey $MYNAME! $NAME has accepted your request. now you can message to her';
            $notificationData['notification_message'] =  'Hey ' . $reciverUser->full_name . ' ! ' . $user->full_name . ' has accepted your request. now you can message to her';
        }

        $notification->status = $notificationData['status'];
        if ($notification->save()) {
            $deviceToken = Device::where('user_id', $notificationData['receiver_id'])->first();
            if ($deviceToken != null) {
                if ($deviceToken->model == 'ios') {
                    send_notification_FCM($deviceToken->device_token, $notificationData);
                } else {
                    send_notification_FCM_and($deviceToken->device_token, $notificationData);
                }
            }
        }
    }
}


function send_notification_FCM($deviceToken, $notifyData)
{
    // $SERVER_API_KEY = 'key=AAAAP6m84T0:APA91bHeuAm2ME_EmPEsOjMe2FatmHn2QU98ADg4Y5UxNMmXGg4MDD4OJQQhvsixNfhV1g2BWbgOCQGEf9_c3ngB8qH_N3MEMsgD7uuAQAq0_IO2GGPqCxjJPuwAME9MVX9ZvWgYbcPh';
    $SERVER_API_KEY = 'key=AAAAvDIpzpQ:APA91bF3RZ_PxZdlMcEVsPEKMYNZS6njxggdyBd5SBlCCX8UStE-gE3Ed3kHv4SF_LSBZndTyvp_wCOeLDczQkAYl41OwKzAGYHnfent6jLAEBl0B-KaCMO6_Uu_cq083Q2Qz_HDiPkS';
    $URL = 'https://fcm.googleapis.com/fcm/send';

    if (isset($notifyData['message'])) {
        $messageNotify = $notifyData['message'];
    } else {

        $messageNotify = $notifyData['notification_message'];
    }
    // $notificationLoad =  [
    //     'title' => "Yesvite",
    //     "body" => $messageNotify,
    //     'sound' => "default",
    //     'message' => $messageNotify,
    //     'color' => "#79bc64",
    //     "data" => $notifyData
    // ];

    // $dataPayload = [
    //     "to" => $deviceToken,
    //     "data" => $notifyData,
    //     "notification" => $notificationLoad,
    //     "priority" => "high",
    // ];

    $notification = array(
        'title' => 'Traditional',
        'body' => $messageNotify,
        'sound' => 'default',
        'message' => $messageNotify,
        'color' => "#79bc64",
        'image' => $notifyData['notification_image'],
        'category' => 'content_added_notification',
    );
    $message = array(
        'to' => $deviceToken,
        'notification' => $notification,
        'data' => $notifyData,
        'aps' => array(
            'alert' => array(
                'title' => "Traditional",
                'body' => $messageNotify
            ),
            'category' => 'content_added_notification',
            'mutable-content' => true,
            'content-available' => true,
        ),
    );

    $post_data = json_encode($message);

    $crl = curl_init();

    $headr = array();
    $headr[] = 'Content-type: application/json';
    $headr[] = 'Authorization: ' . $SERVER_API_KEY;
    curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($crl, CURLOPT_URL, $URL);
    curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);

    curl_setopt($crl, CURLOPT_POST, true);
    curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);

    $rest = curl_exec($crl);

    if ($rest === false) {
        $result_noti = 0;
    } else {
        $result_noti = 1;
    }

    return $result_noti;
}

function send_notification_FCM_and($deviceToken, $notifyData)
{

    // Live //

    //$SERVER_API_KEY = 'key=AAAAW0MrN-E:APA91bEMAssl6Kl4HzSTLuiYSsXJzRXJRYuCZMz4XyJTsXxJTQLPcgkx42MmwpNTtWPqean_SeIw5PspZ6fAy1cqqfA2JsOVWH-IzF82EqmX6JAcC0LWTwE6o1kl-QMM1KmhiOvp4q2o';

    // Dev //

    $SERVER_API_KEY = 'key=AAAAvDIpzpQ:APA91bF3RZ_PxZdlMcEVsPEKMYNZS6njxggdyBd5SBlCCX8UStE-gE3Ed3kHv4SF_LSBZndTyvp_wCOeLDczQkAYl41OwKzAGYHnfent6jLAEBl0B-KaCMO6_Uu_cq083Q2Qz_HDiPkS';
    $URL = 'https://fcm.googleapis.com/fcm/send';


    $dataPayload = [
        "to" => $deviceToken,
        "data" => $notifyData,
    ];

    $post_data = json_encode($dataPayload);

    $crl = curl_init();

    $headr = array();
    $headr[] = 'Content-type: application/json';
    $headr[] = 'Authorization: ' . $SERVER_API_KEY;
    curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);

    curl_setopt($crl, CURLOPT_URL, $URL);
    curl_setopt($crl, CURLOPT_HTTPHEADER, $headr);

    curl_setopt($crl, CURLOPT_POST, true);
    curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);

    $rest = curl_exec($crl);

    if ($rest === false) {
        $result_noti = 0;
    } else {
        $result_noti = 1;
    }

    return $result_noti;
}


function generateConversationId($userIds)
{
    // Sort user IDs to ensure consistency
    sort($userIds);

    // Concatenate sorted user IDs
    $concatenatedIds = implode("", $userIds);

    // Generate hash value using SHA-256
    $hashValue = hash("sha256", $concatenatedIds);

    // Take the first 10 characters of the hash value
    return substr($hashValue, 0, 20);
}
