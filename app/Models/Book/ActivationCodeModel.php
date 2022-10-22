<?php

namespace App\Models\Book;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivationCodeModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = "book";
    protected $table = 'activation_code';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        "code",
        "order_id",
        "product_id",
        "resource",
        "status",
        "limit",
        "used",
        "users",
    ];
}
