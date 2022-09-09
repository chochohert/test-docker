<?php

namespace App\Http\Controllers;

use App\common\ResultRequest;
use App\Http\Resources\OrderResource;
use App\Services\AuthUserService;
use App\Services\OrderService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Request;
use App\common\RequestValidator;
use Illuminate\Routing\Controller;

class AuthUserController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    /** 가입 처리
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public static function signUp(Request $request)
    {
        RequestValidator::validate($request,[
            "name" => "required",
            "email" => "required|email",
            "password" => "required"
        ]);

        $name = $request->get("name");
        $email = $request->get("email");
        $password = $request->get("password");

        if(AuthUserService::checkExistEmail($email)) throw new HttpResponseException(response()->json(ResultRequest::RESULT_ERROR(
              "이미 등록된 이메일입니다."), 400));

        $user = AuthUserService::createUser($email,$name,$password);
        $token = AuthUserService::createAuthToken($user);

        return response()->json(ResultRequest::RESULT_SUCCESS([
            "externalId" => $user->external_id,
            "token" => $token
        ]),200);
    }

    /** 로그아웃 처리
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function logout(Request $request)
    {
        RequestValidator::validate($request,[
            "externalId" => "required"
        ]);
        $result = AuthUserService::deleteAuthToken($request->get("externalId"));
        return response()->json(ResultRequest::RESULT_SUCCESS([]),200);
    }

    /** 로그인 처리
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Http\Client\RequestException
     */
    public static function login(Request $request)
    {
        RequestValidator::validate($request,[
            "email" => "required|email",
            "password" => "required"
        ]);

        $user = AuthUserService::loginedUser($request->get("email"),$request->get("password"));
        $token = AuthUserService::createAuthToken($user);

        return response()->json(ResultRequest::RESULT_SUCCESS([
            "externalId" => $user->external_id,
            "token" => $token
        ]),200);
    }

    /** 회원 주문 내역 조회
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function orders(Request $request)
    {
        RequestValidator::validate($request,[
            "externalId" => "required",
            "from" => "nullable|date_format:Y-m-d",
            "to" => "nullable|date_format:Y-m-d"
        ]);

        $filter = [
            "keyword" => $request->input('keyword',""),
            "from" => $request->input('from',""),
            "to" => $request->input('to',""),
        ];

        $orders = OrderService::getOrders($request->get("externalId"),$filter);
        return OrderResource::collection($orders);
    }

    /** 회원 주문 내역 상세
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public static function ordersDetail(Request $request,$id){
        RequestValidator::validate($request,[
            "externalId" => "required"
        ]);

        $order = OrderService::getOder($id,$request->get("externalId"));
        return response()->json(ResultRequest::RESULT_SUCCESS(new OrderResource($order)),200);
    }
}
