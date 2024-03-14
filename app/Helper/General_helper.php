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
            send_notification_FCM_and($deviceToken, $notificationData);
        }
    }

    if ($notificationData['notify_for'] == 'cancel_request') {

        Notification::where(['user_id' => $notificationData['receiver_id'], 'sender_id' => $notificationData['sender_id'], 'notification_type' => $notificationData['type'], 'status' => $notificationData['status']])->delete();
        $notification = new Notification();
        $notification->user_id  = $notificationData['receiver_id'];
        $notification->sender_id = $notificationData['sender_id'];
        $notification->notification_type = $notificationData['type'];
        $notification->message = 'After initiating an approach request, $NAME has cancelled the request.';
        $notification->status = $notificationData['status'];
        if ($notification->save()) {
            $deviceToken = Device::select('device_token')->where('user_id', $notificationData['receiver_id'])->first();
            send_notification_FCM_and($deviceToken, $notificationData);
        }
    }
}




function send_notification_FCM_and($deviceToken, $notifyData)
{
    $SERVER_API_KEY = 'key=AAAAP6m84T0:APA91bHeuAm2ME_EmPEsOjMe2FatmHn2QU98ADg4Y5UxNMmXGg4MDD4OJQQhvsixNfhV1g2BWbgOCQGEf9_c3ngB8qH_N3MEMsgD7uuAQAq0_IO2GGPqCxjJPuwAME9MVX9ZvWgYbcPh';
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
