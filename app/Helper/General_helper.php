<?php

use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\{
    Notification,
    User,
    Device
};

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

function calculateAge($birthdate, $endDate = null)
{
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
            $deviceToken = Device::select('device_token')->where('user_id', $notificationData['receiver_id'])->first();
            if ($deviceToken != null) {
                $user = User::where('id', $notificationData['sender_id'])->first();
                $notificationData['notification_message'] = 'Hey! you got connection approach from ' . $user->full_name;
                send_notification_FCM_and($deviceToken->device_token, $notificationData);
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
            $deviceToken = Device::select('device_token')->where('user_id', $notificationData['receiver_id'])->first();
            if ($deviceToken != null) {
                $user = User::where('id', $notificationData['sender_id'])->first();
                $notificationData['notification_message'] = $user->full_name . ' wants to talk with you';
                send_notification_FCM_and($deviceToken->device_token, $notificationData);
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
            $deviceToken = Device::select('device_token')->where('user_id', $notificationData['receiver_id'])->first();
            $user = User::where('id', $notificationData['sender_id'])->first();
            if ($notificationData['type'] == 'approach') {

                $notificationData['notification_message'] = 'After initiating an approach request, ' . $user->full_name . ' has cancelled the request.';
            } else if ($notificationData['type'] == 'friend') {

                $notificationData['notification_message'] = 'After initiating an friend request, ' . $user->full_name . ' has cancelled the request.';
            }


            if ($deviceToken != null) {

                send_notification_FCM_and($deviceToken->device_token, $notificationData);
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
            if ($notificationData['type'] == 'friend') {
                $notification->message = "\$NAME rejected your friend request";
                $notificationData['notification_message'] = $user->full_name . " rejected your friend request";
            } elseif ($notificationData['type'] == 'approach') {
                $notification->message = "\$NAME rejected your approach 🚫💔 - '" . $notificationData['message'] . "'";
                $notificationData['notification_message'] = $user->full_name . " rejected your approach 🚫💔 - '" . $notificationData['message'] . "'";
            }
        }
        if ($notificationData['status'] == 'accepted') {
            $reciverUser = User::where('id', $notificationData['receiver_id'])->first();
            $notification->message = 'Hey $MYNAME ! $NAME has accepted your request. now you can message to her';
            $notificationData['notification_message'] =  'Hey ' . $reciverUser->full_name . ' ! ' . $user->full_name . ' has accepted your request. now you can message to her';
        }

        $notification->status = $notificationData['status'];
        if ($notification->save()) {
            $deviceToken = Device::select('device_token')->where('user_id', $notificationData['receiver_id'])->first();
            if ($deviceToken != null) {

                send_notification_FCM_and($deviceToken->device_token, $notificationData);
            }
        }
    }
}




function send_notification_FCM_and($deviceToken, $notifyData)
{

    //$SERVER_API_KEY = 'key=AAAAW0MrN-E:APA91bEMAssl6Kl4HzSTLuiYSsXJzRXJRYuCZMz4XyJTsXxJTQLPcgkx42MmwpNTtWPqean_SeIw5PspZ6fAy1cqqfA2JsOVWH-IzF82EqmX6JAcC0LWTwE6o1kl-QMM1KmhiOvp4q2o';
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
