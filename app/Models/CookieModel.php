<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class CookieModel extends ParentModel
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'cookie';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        "cookie",
        "ip_address",
        "user_agent",
        "expired_at",
    ];

    public function selectNotExpiredCookie( string $cookie ) {
        return self::where( 'cookie', "=", $cookie )
                ->where( 'expired_at', ">", date( 'Y-m-d H:i:s', time() ) )->first();
    }

    public function deleteCookie( string $cookie ) {
        return self::where( 'cookie', "=", $cookie )->delete();
    }
}
