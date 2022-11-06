<?php

namespace App\Models\Shopping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentTrackModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = "shopping";
    protected $table = 'payment_track';

    protected $primaryKey = 'ID';

    public $timestamps = true;

    protected $fillable = [
        "user_id",
        "payment_request_id",
        "amount",
        "amount_discounted",
        "res_num",
        "metadata",
        "description",
    ];
}
