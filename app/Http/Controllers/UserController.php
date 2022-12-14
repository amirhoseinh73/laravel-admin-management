<?php

namespace App\Http\Controllers;

use App\Helpers\Alert;
use App\Helpers\Helper;
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
        $username = $request->post( "username" );
        $password = $request->post( "password" );
        $rememberMe = $request->post( "remember_me" );

        $cookieTime = DAY;
        if ( exists( $rememberMe ) && $rememberMe === "true" ) $cookieTime = MONTH;

        if ( ! exists( $username ) ) return Alert::Error( "wrong_nationalCode" );
        if ( ! exists( $password ) ) return Alert::Error( "wrong_password_limit" );

        $userModel = $this->userModel();
        $selectCurrentUser = $userModel->selectUserWithUsername( $username );
        if ( ! exists( $selectCurrentUser ) ) return Alert::Error( "wrong_nationalCode" );

        $checkPassword = password_verify( md5( $password ), $selectCurrentUser->password );
        if ( $checkPassword !== true ) return Alert::Error( "wrong_password" );

        if ( $selectCurrentUser->expired_at < getCurrentDateTime() ) return Alert::Error( "exire_using_system" );

        $userData = CookieController::setCookieAndLogin( $username, $cookieTime );
        if ( ! exists( $userData ) || $userData->status !== "success" ) return Alert::Error( $userData->message_key );

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

    public function management( Request $request, $is_user_registered_by_admin = false ) {
        $data = [
            'head_title'  => PersianText::WORD[ "dashboard" ] . " | " . PersianText::WORD[ "welcome" ],
            'title'       => PersianText::WORD[ "user" ],
            'description' => PersianText::WORD[ "user_management" ],
            'user_data'   => $this->userInfo( $request ),
            "is_user_registered_by_admin" => $is_user_registered_by_admin
        ];
        
        return view( "dashboard.user-list", $data );
    }

    public function list( $is_user_registered_by_admin = false ) {
        $userModel = $this->userModel();
        $userBookModel = $this->userBookModel();
        $selectAllUsers = $userModel->selectAllUsersInPlatformAndBook( json_decode( $userBookModel->all()->toJson() ), $is_user_registered_by_admin );

        foreach( $selectAllUsers as $user ) {
            $user->created_at = convertGregorianDateTimeToJalaali( $user->created_at );
            $user->updated_at = convertGregorianDateTimeToJalaali( $user->updated_at );
            $user->last_login_at = convertGregorianDateTimeToJalaali( $user->last_login_at );
            $user->recovered_password_at = convertGregorianDateTimeToJalaali( $user->recovered_password_at );
            $user->expired_at = convertGregorianDateTimeToJalaali( $user->expired_at );
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
        $key = $request->post( "key" );
        $value = $request->post( "data" );

        if ( ! exists( $ID ) || ! exists( $value ) || ! exists( $key ) ) return Alert::Error( "wrong_inputs" );

        $userModel = $this->userModel();
        $userBookModel = $this->userBookModel();
        $selectUser = $userModel->selectItemByID( $ID );

        if ( ! exists( $selectUser ) ) return Alert::Error( -1 );

        if ( $key === "expired_at" ) {
            $value = convertJalaaliDateTimeToGregorian( $value );
        }

        try {
            $data = array(
                "$key" => $value,
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

    public function resetPassword( Request $request ) {
        $id    = $request->post( "id" );
        if ( ! exists( $id ) ) return Alert::Error( "wrong_inputs" );

        $userModel = $this->userModel();
        try {
            $dataToUpdate = array(
                "password" => password_hash( md5( "123456" ), PASSWORD_BCRYPT )
            );
            $userModel->updateUserDataWithUserID( $id, $dataToUpdate );

            return Alert::Success( 200 );
        } catch( Exception $e ) {
            return Alert::Error( -1 );
        }
    }

    public function registerPage( Request $request ) {
        $data = [
            'head_title'  => PersianText::WORD[ "dashboard" ] . " | " . PersianText::WORD[ "welcome" ],
            'title'       => PersianText::WORD[ "user" ],
            'description' => PersianText::WORD[ "register" ],
            'user_data'   => $this->userInfo( $request ),
        ];
        
        return view( "dashboard.user-register", $data );
    }

    public function register( Request $request ) {
        $firstname = $request->post( "firstname" );
        $lastname  = $request->post( "lastname" );
        $username  = $request->post( "username" );
        $mobile    = $request->post( "mobile" );
        $password  = $request->post( "password" );
        $gender    = $request->post( "gender" );
        $grade     = $request->post( "grade" );
        $expired_at = $request->post( "expired_at" );

        $is_send_sms = $request->post( "is_send_sms" );

        if ( ! exists( $firstname ) ) return Alert::Error( "wrong_firstname" );
        if ( ! exists( $lastname ) ) return Alert::Error( "wrong_lastname" );
        if ( ! isValidNationalCodeIran( $username ) ) return Alert::Error( "wrong_nationalCode" );
        if ( ! isValidMobile( $mobile ) ) return Alert::Error( "wrong_mobile" );
        if ( ! isValidPassword( $password ) ) return Alert::Error( "wrong_password_limit" );
        if ( ! exists( $gender ) ) return Alert::Error( "wrong_user_type" );
        if ( ! exists( $grade ) ) return Alert::Error( "wrong_inputs" );
        if ( ! exists( $expired_at ) ) $expired_at = "1402/07/01 00:00:00";

        $expired_at = convertJalaaliDateTimeToGregorian( $expired_at );

        $userModel = $this->userModel();
        $userBookModel = $this->userBookModel();

        $selectExistUser = $userModel->selectUserWithUsername( $username );
        if ( exists( $selectExistUser ) ) return Alert::Error( "used_nat_code" );

        $dataToInsert = array(
            "activation_code_id" => -1,
            "username" => $username,
            "firstname" => $firstname,
            "lastname" => $lastname,
            "mobile" => $mobile,
            "gender" => $gender,
            "status" => 1,
            "password" => password_hash( md5( $password ), PASSWORD_BCRYPT ),
            "expired_at" => $expired_at,
        );

        try {
            $result = $userModel->create( $dataToInsert );
            if ( ! exists( $result ) || ! exists( $result->id ) ) return Alert::Error( "failed" );

            $dataToInsertBookUser = array(
                "platform_id" => $result->id,
                "grade" => $grade,
                "complete_signup" => true,
            );
            $result = $userBookModel->create( $dataToInsertBookUser );
            if ( ! exists( $result ) || ! exists( $result->id ) ) return Alert::Error( "failed" );

            if ( $is_send_sms === "true" ) Helper::sendSmsIRRegister( $mobile, $username, $password );
            return Alert::Success( 200 );
        } catch( Exception $e ) {
            logFile( $e );
            return Alert::Error( -1 );
        }
    }

    public function managementRegisteredUsersByAdmin( Request $request ) {
        return $this->management( $request, true );
    }

    public function listUsersRegisteredByAdmin() {
        return $this->list( true );
    }

}
