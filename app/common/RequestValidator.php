<?php

namespace App\common;

use Illuminate\Http\Exceptions\HttpResponseException;
use App\common\ResultRequest;
use Illuminate\Support\Facades\Validator;

class RequestValidator
{
    public static function validate($request, $rules,$massages = [])
    {
        $validator = Validator::make($request->all(), $rules,$massages);

        if ($validator->fails()) {
            throw new HttpResponseException(response()->json(ResultRequest::RESULT_ERROR(
                    $validator->errors()->first()), 400)
            );
        }
    }
}
