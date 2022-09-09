<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    use HasFactory;

    protected $table = "orders";

    protected $fillable = [
        "user_id",
        "price",
        "status",
        "total_price",
        "cancel_at",
        "confirm_at",
    ];

    public function scopeSearchGoods($query,$q)
    {
        if($q){
            $query->whereHas("goods",function ($query) use($q){
                $query->where('name', 'like', "%$q%")
                    ->orWhere('color', 'like', "%$q%");
            });

        }

        return $query;
    }

    public function scopeSearchDate($query,$from,$to){
        if($from){
            $query->whereRaw("created_at >= '$from 00:00:00'");
        }

        if($to){
            $query->whereRaw("created_at <= '$to 23:59:59'");
        }

        return $query;
    }

    public function orderGoods()
    {
        return $this->hasMany(OrderGoods::class,"order_id","id");
    }

    public function goods() {
        return $this->belongsToMany(Goods::class,'order_goods','order_id','goods_id');
    }
}
