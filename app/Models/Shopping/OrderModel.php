<?php

namespace App\Models\Shopping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrderModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = "shopping";
    protected $table = 'order';

    protected $primaryKey = 'ID';

    public $timestamps = true;

    protected $fillable = [
        "user_id",
        "cart_items_ids",
        "address_id",
        "is_purchased",
    ];
}
