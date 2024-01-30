<?php
namespace App\Helper;

trait ApiValidationTrait
{
    public function validateApiParameters($request, $requiredParameters)
    {
        foreach ($requiredParameters as $param) {
            // Check if each required parameter exists in the request
            if (!$request->has($param)) {
                return response()->json(['error' => "Missing required parameter: $param"], 400);
            }
        }

        return null;
    }
}
?>