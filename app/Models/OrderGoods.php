<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderGoods extends Model
{
    use HasFactory;

    protected $table = "order_goods";

    protected $fillable = [
        'order_id',
        'goods_id',
        'goods_amount'
    ];

    public function goods()
    {
        return $this->belongsTo(Goods::class,"goods_id","id");
    }
}
