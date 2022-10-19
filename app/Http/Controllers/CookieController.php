<?php

namespace App\Http\Controllers;

use App\Models\CookieModel;
use App\Models\UserModel;
use Exception;

class CookieController extends Controller
{
    public static function Create( int $time = DAY ) {
        $token = randomVerificationCode( 24 );
        $token = md5( sha1($token) . time() . 'amirhh73' );

        $data = array(
            "token"      => $token,
            "ip_address" => $_SERVER[ 'REMOTE_ADDR' ],
            "user_agent" => $_SERVER[ 'HTTP_USER_AGENT' ],
            "time"       => getCurrentDateTime(),
            "expired_at" => getCurrentDateTime( "gregorian", strtotime( "+$time seconds", time() ) ),
            "status"     => 'success',
        );
        
        return (object)$data;
    }

    public static function setCookieAndLogin( string $username, int $time = DAY ) {
        $data = [
            'status' => 'failed',
            "message_key" => "account_disabled"
        ];
        $token = self::Create( $time );
        if ( $token->status === 'success' ) {
            $cookiesModel = new CookieModel();
            $usersModel = new UserModel();
            $selectUser = $usersModel->selectUserWithUsername( $username );
            if ( ! exists( $selectUser ) ) return (object)$data;

            try {
                $usersModel->updateCookieOfUserWithUserID( $selectUser->id, $token->token );

                $dataForCookie = [
                    'cookie'     => $token->token,
                    'ip_address' => $token->ip_address,
                    'user_agent' => $token->user_agent,
                    'expired_at' => $token->expired_at,
                ];
                $cookiesModel->saveNewCookie( $dataForCookie );

                setcookie( env( "COOKIE_NAME" ), $token->token, time() + $time, '/' );
                $data['status'] = 'success';

                $selectUser->cookie = $token->token;
                $data[ "userdata" ] = $selectUser;
            } catch ( Exception $exception ) {
                $data['message_key'] = -1;
            }
        }

        return (object)$data;
    }

    /**
     * @return string Token User
     */
    public static function Get( $token = null ) {
        if ( ! exists( $token ) && isset( $_COOKIE[ env( "COOKIE_NAME" ) ] ) ) $token = $_COOKIE[ env( "COOKIE_NAME" ) ];
        if ( ! exists( $token ) ) return false;

        $cookiesModel = new CookieModel();
        $selectCookieDB = $cookiesModel->selectNotExpiredCookie( $token );

        //has cookie and expired session date
        if ( ! exists( $selectCookieDB ) ) {
            self::Unset( $token );
            return false;
        }

        //return token
        return $selectCookieDB->cookie;
    }

    /**
     * @param string $token get token for api, if no token exists get it from cookie
     */
    public static function UserData( $token = null ) {
        $token = self::Get( $token );
        if ( ! exists( $token ) ) return false;

        $usersModel = new UserModel();
        $selectUser = $usersModel->selectUserWithCookie( $token );
        if ( ! exists( $selectUser ) ) return false;

        return $selectUser;
    }

    public static function Unset( $token = null ) {
        $cookiesModel = new CookieModel();
        $usersModel = new UserModel();
        if ( ! exists( $token ) && isset( $_COOKIE[ env( "COOKIE_NAME" ) ] ) ) $token = $_COOKIE[ env( "COOKIE_NAME" ) ];
        if ( ! isset( $token ) ) return false;

        $cookiesModel->deleteCookie( $token );
        $usersModel->updateCookieOfUserWithCookieToNull( $token );

        setcookie( env( "COOKIE_NAME" ), '', '', '/');

        return true;
    }
}