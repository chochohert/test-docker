<?php

namespace App\Http\Controllers;

use App\common\RequestValidator;
use App\common\ResultRequest;
use App\Http\Resources\GoodsResource;
use App\Http\Resources\OrderResource;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /** 상품 검색
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public static function search(Request $request)
    {
        RequestValidator::validate($request,[
            "sort" => [Rule::in("qty","name","color","price","")],
            "order" => [Rule::in("desc","asc","")],
            "inStock" => "nullable|numeric",
        ]);

        $filter = [
            'keyword' => $request->input('keyword',""),
            'inStock' => $request->input("inStock",0),
            'sort' => $request->input('sort'),
            'order' => $request->input('order','desc'),
            'perPage' => $request->input("perPage",15),
        ];

        $goods = OrderService::search($filter);

        return GoodsResource::collection($goods);
    }

    /**상품 주문
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public static function orderGoods(Request $request)
    {
        RequestValidator::validate($request,[
            "externalId" => "required",
            "price" => "required|numeric",
        ]);

        //주문 상품 체크
        RequestValidator::validate($request,[
            "orderGoods.*.id" => "required|numeric",
            "orderGoods.*.qty" => "required|numeric",
        ]);

        $order = OrderService::orderGoods($request->get("externalId"),$request->get("price"),$request->get("orderGoods"));

        return response()->json(ResultRequest::RESULT_SUCCESS(new OrderResource($order)),200);
    }
}
