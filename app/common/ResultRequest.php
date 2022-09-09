<?php

namespace App\common;

class ResultRequest
{
    public static function RESULT_SUCCESS( $arrData = [] ): array
    {
        return array(
            "data" => $arrData
        );
    }
    public static function RESULT_ERROR($message=null, $data=[]): array
    {
        return array(
            'message' => $message,
            "data" => $data
        );
    }
}
