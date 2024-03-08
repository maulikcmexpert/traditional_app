<?php

use Illuminate\Support\Str;

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
