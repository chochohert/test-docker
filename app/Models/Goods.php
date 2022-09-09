<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    use HasFactory;

    protected $perPage = 15;
    protected $table = "goods";

    public function scopeSearch($query,$q)
    {
        if($q){
            $query->where('name', 'like', "%$q%")
                ->orWhere('color', 'like', "%$q%");
        }

        return $query;
    }

    public function scopeInStock($query){
        return $query->where("qty" ,">", 0);
    }
}
