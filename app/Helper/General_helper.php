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



function processImageName($imageName)
{
    // Check if the image name contains _0, _1, or _2
    if (preg_match('/_(0|1|2),/', $imageName)) {
        // Extract the number after the underscore
        preg_match('/_(\d+)/', $imageName, $matches);
        $number = isset($matches[1]) ? $matches[1] : 0;
    } else {
        // If not, find the last underscore and add _0
        $lastUnderscore = strrpos($imageName, '_');
        $number = is_numeric(substr($imageName, $lastUnderscore + 1)) ? (int)substr($imageName, $lastUnderscore + 1) + 1 : 0;

        // Add _0 to the image name
        $imageName = Str::finish($imageName, '_') . $number;
    }

    // Do something with the extracted number or updated image name
    // For example, you can return the result
    return $imageName;
}

// Example usage
$imageName = "66.jpg";
$newImageName = processImageName($imageName);
echo $newImageName;
