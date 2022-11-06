<?php

namespace App\Models\Shopping;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class AddressModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = "shopping";
    protected $table = 'address';

    protected $primaryKey = 'ID';

    public $timestamps = true;

    protected $fillable = [
        "user_id",
        "telephone",
        "postcode",
        "province_id",
        "city_id",
        "address",
    ];
}
