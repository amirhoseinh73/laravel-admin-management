<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserModel extends ParentModel
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

    public function selectUserWithUsername( string $username ) {
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
