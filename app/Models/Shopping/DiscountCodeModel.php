<?php

namespace App\Models\Shopping;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class DiscountCodeModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $connection = "shopping";
    protected $table = 'discount_code';

    protected $primaryKey = 'ID';
    
    public $timestamps = true;

    protected $fillable = [
        "discount_code",
        "percent",
        "limit_usage",
        "used_number",
        "status",
        "mobile",
        "users",
        "expired_at",
    ];

    public function getCreatedAtAttribute( $value ) {
        $date = new Carbon( $value );
        return $date->format( "Y-m-d H:i:s" );
    }

    public function getUpdatedAtAttribute( $value ) {
        $date = new Carbon( $value );
        return $date->format( "Y-m-d H:i:s" );
    }

    public function selectCodeByCode( $discountCode ) {
        return self::where( 'discount_code', "=", $discountCode )->first();
    }

    public function selectCodeByID( $ID ) {
        return self::where( 'ID', "=", $ID )->first();
    }

    public function getAllDataArrayOfObject() {
        return json_decode( self::all()->toJson() );
    }

    public function deleteCodeByID( $ID ) {
        return self::where( "ID", "=", $ID )->delete();
    }


    /***
     * $data = $data->map(function ($user) {
            return collect($user->toArray())
                // ->only(['id', 'name', 'email'])
                ->all();
        })->toArray();
     */
}
