<?php

function showResponse($data = [], $message = null, $statusCode = null, $merges = [])
{
    return response()->json([
        "data" => $data,
        "success" => true,
        "message" => $message,
        "code" => $statusCode,
    ], $statusCode);
}