<?php

namespace App\Models\Shopping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CartItemModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = "shopping";
    protected $table = 'cart_item';

    protected $primaryKey = 'ID';

    public $timestamps = true;

    protected $fillable = [
        "user_id",
        "product_id",
        "count",
        "description",
        "is_submitted",
    ];
}
