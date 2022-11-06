<?php

namespace App\Models\Shopping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentRequestModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = "shopping";
    protected $table = 'payment_request';

    protected $primaryKey = 'ID';

    public $timestamps = true;

    protected $fillable = [
        "user_id",
        "order_id",
        "discount_code",
        "amount",
        "amount_discounted",
        "res_num",
        "description",
    ];
}
