<?php

namespace App\Models\Book;

use App\Models\ParentModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class ActivationCodeModel extends ParentModel
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

    public function selectCodeByCode( $code ) {
        return $this->where( "code", "=", $code )->first();
    }

    public function selectWithResource( $resource ) {
        return $this->where( "resource", "=", $resource )->get();
    }
}
