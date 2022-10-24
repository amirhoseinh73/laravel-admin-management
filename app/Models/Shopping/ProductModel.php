<?php

namespace App\Models\Shopping;

use App\Models\ParentModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductModel extends ParentModel
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = "shopping";
    protected $table = 'product';

    protected $primaryKey = 'ID';

    public $timestamps = true;

    protected $fillable = [
        "title",
        "grade",
        "type",
        "user_type",
        "price",
        "discount",
        "discount_text",
        "count_sale",
        "image",
        "excerpt",
        "content",
        "is_commingsoon",
    ];

}
