<?php

namespace App\Http\Controllers;

use App\Helpers\Alert;
use App\Helpers\PersianText;
use Exception;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index() {
        $data = [
            'head_title'  => env( "SITE_NAME" ) . " | " . PersianText::WORD[ "welcome" ] ,
            'title'       => PersianText::WORD[ "login" ],
            'description' => PersianText::WORD[ "welcome" ],
        ];
        
        return view( "login", $data );
    }

    public function login( Request $request ) {
        $username = $request->get( "username" );
        $password = $request->get( "password" );
        $rememberMe = $request->get( "remember_me" );

        $cookieTime = DAY;
        if ( exists( $rememberMe ) && $rememberMe === "true" ) $cookieTime = MONTH;

        if ( ! exists( $username ) ) return Alert::Error( "wrong_nationalCode" );
        if ( ! exists( $password ) ) return Alert::Error( "wrong_password" );

        $userModel = $this->userModel();
        $selectCurrentUser = $userModel->selectUserWithUsername( $username );
        if ( ! exists( $selectCurrentUser ) ) return Alert::Error( "wrong_nationalCode" );

        $checkPassword = password_verify( md5( $password ), $selectCurrentUser->password );
        if ( $checkPassword !== true ) return Alert::Error( "wrong_password" );

        $userData = CookieController::setCookieAndLogin( $username, $cookieTime );
        if ( ! exists( $userData ) || $userData->status !== "success" ) Alert::Error( $userData->message_key );

        $dataToUpdate = [
            'is_logged_in' => true,
            'last_login_at' => date('Y-m-d H:i:s'),
        ];
        $userModel->updateUserDataWithUserID( +$selectCurrentUser->id, $dataToUpdate );

        return Alert::Success( 200, $userData );
    }

    public function logout( Request $request ) {
        $methodCondition = ( $request->method() === "post" );

        $userInfo = $this->userInfo( $request );
        if ( ! exists( $userInfo ) ) {
            if ( $methodCondition ) return Alert::Error( -1 );
            return redirect( "/" );
        }

        CookieController::Unset( $userInfo->cookie );
        $userModel = $this->userModel();
        $dataToUpdate = [
            "is_logged_in" => false
        ];
        $userModel->updateUserDataWithUserID( $userInfo->id, $dataToUpdate );

        if ( $methodCondition ) return Alert::Success( 200 );
        return $this->index();
    }

    public function dashboard( Request $request ) {
        $data = [
            'head_title'  => PersianText::WORD[ "dashboard" ] . " | " . PersianText::WORD[ "welcome" ],
            'title'       => PersianText::WORD[ "welcome" ],
            'description' => PersianText::WORD[ "dear_user" ] . " " .PersianText::WORD[ "welcome" ],
            'user_data'   => $this->userInfo( $request ),
        ];

        return view( 'dashboard.index', $data );
    }

    public function management( Request $request ) {
        $data = [
            'head_title'  => PersianText::WORD[ "dashboard" ] . " | " . PersianText::WORD[ "welcome" ],
            'title'       => PersianText::WORD[ "user" ],
            'description' => PersianText::WORD[ "user_management" ],
            'user_data'   => $this->userInfo( $request ),
        ];
        
        return view( "dashboard.user-list", $data );
    }

    public function list() {
        $userModel = $this->userModel();
        $userBookModel = $this->userBookModel();
        $selectAllUsers = $userModel->selectAllUsersInPlatformAndBook( json_decode( $userBookModel->all()->toJson() ) );

        foreach( $selectAllUsers as $user ) {
            $user->created_at = convertGregorianDateTimeToJalaali( $user->created_at );
            $user->updated_at = convertGregorianDateTimeToJalaali( $user->updated_at );
            $user->last_login_at = convertGregorianDateTimeToJalaali( $user->last_login_at );
            $user->recovered_password_at = convertGregorianDateTimeToJalaali( $user->recovered_password_at );
        }
        
        return Alert::Success( 200, $selectAllUsers );
    }

    public function remove( Request $request ) {
        $id    = $request->post( "id" );
        if ( ! exists( $id ) ) return Alert::Error( "wrong_inputs" );

        $userModel = $this->userModel();
        $userBookModel = $this->userBookModel();
        try {
            $userModel->removeItemByID( $id );
            $userBookModel->removeItemByPlatformID( $id );

            return Alert::Success( 200 );
        } catch( Exception $e ) {
            return Alert::Error( -1 );
        }
    }

    public function Update( Request $request ) {
        $ID = $request->post( "id" );
        $data = $request->post( "data" );
        $key = $request->post( "key" );

        if ( ! exists( $ID ) || ! exists( $data ) || ! exists( $key ) ) return Alert::Error( "wrong_inputs" );

        $userModel = $this->userModel();
        $userBookModel = $this->userBookModel();
        $selectUser = $userModel->selectItemByID( $ID );

        if ( ! exists( $selectUser ) ) return Alert::Error( -1 );

        try {
            $data = array(
                "$key" => $data,
            );

            if ( $key === "grade" ) {
                $userBookModel->updateItemByPlatformID( $ID, $data );
            } else {
                $userModel->updateRowByID( $ID, $data );
            }

            return Alert::Success( 200 );
        } catch( Exception $e ) {
            return Alert::Error( -1 );
        }
    }
}
