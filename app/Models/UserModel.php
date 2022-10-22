<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
// use Illuminate\Support\Facades\DB;

class UserModel extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'user';

    protected $primaryKey = 'id';

    public $timestamps = true;

    protected $fillable = [
        "username",
        "firstname",
        "lastname",
        "profile_image",
        "mobile",
        "gender",
        "is_admin",
        "status",
        "is_logged_in",
        "last_login_at",
        "recovered_password_at",
        "cookie",
        "password",
    ];

    public function getCreatedAtAttribute( $value ) {
        $date = new Carbon( $value );
        return $date->format( "Y-m-d H:i:s" );
    }

    public function getUpdatedAtAttribute( $value ) {
        $date = new Carbon( $value );
        return $date->format( "Y-m-d H:i:s" );
    }

    public function selectUserWithUsername( string $username ) {
        // return DB::table( $this->table )
        //         ->where( "username", "=", $username )
        //         ->first();
        return self::where( "username", "=", $username )->first();
    }

    public function updateCookieOfUserWithUserID( int $userID, string $cookie ) {
        return self::where( "id", "=", $userID )->update( [ "cookie" => $cookie ] );
    }

    public function updateCookieOfUserWithCookieToNull( string $cookie ) {
        return self::where( "cookie", "=", $cookie )->update( [ "cookie" => null ] );
    }

    public function selectUserWithCookie( string $cookie ) {
        return self::where( "cookie", "=", $cookie )->first();
    }

    public function updateUserDataWithUserID( int $userID, array $data ) {
        return self::where( "id", "=", $userID )->update( $data );
    }
}
