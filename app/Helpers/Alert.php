<?php

namespace App\Helpers;

class Alert {

    /**
     * @param string|int $key `no_access` -1 |`failed` 100 |`wrong_mobile` 101 
     * |`wrong_otp` 102 | `account_disabled` 103 | `no_data` 104 | `wrong_inputs` 105
     * | `duplicate_mobile` 106 | `wrong_firstname` 107 | `wrong_lastname` 108 | `wrong_code` 109
     * | `already_registered` 110 | `already_logged_in` 111 | `not_logged_in` 112 | `wrong_user_type` 113
     * | `wrong_telephone` 114 | `wrong_nationalCode` 115 | `wrong_password` 116 | `expired_code` 117
     * | `used_code` 118 | `wrong_system_code` 119
     */
    public static function Error( $key, $data = [], $show_code = false ) {
        
        switch ( $key ) {
            case "no_response":
            case -2:
                $message = PersianText::MESSAGE[ "no_response" ];
                $code = -2;
                break;
            default:
            case "no_access":
            case -1:
                $message = PersianText::MESSAGE[ "no_access" ];
                $code = -1;
                break;
            case "failed":
            case 100:
                $message = PersianText::MESSAGE[ "failed" ];
                $code = 100;
                break;
            case "wrong_mobile":
            case 101:
                $message = PersianText::MESSAGE[ "wrong_mobile" ];
                $code = 101;
                break;
            case "wrong_otp":
            case 102:
                $message = PersianText::MESSAGE[ "wrong_otp" ];
                $code = 102;
                break;
            case "account_disabled":
            case 103:
                $message = PersianText::MESSAGE[ "account_disabled" ];
                $code = 103;
                break;
            case "no_data":
            case 104:
                $message = PersianText::MESSAGE[ "no_data" ];
                $code = 104;
                break;
            case "wrong_inputs":
            case 105:
                $message = PersianText::MESSAGE[ "wrong_inputs" ];
                $code = 105;
                break;
            case "duplicate_mobile":
            case 106:
                $message = PersianText::MESSAGE[ "duplicate_mobile" ];
                $code = 106;
                break;
            case "wrong_firstname":
            case 107:
                $message = PersianText::MESSAGE[ "wrong_firstname" ];
                $code = 107;
                break;
            case "wrong_lastname":
            case 108:
                $message = PersianText::MESSAGE[ "wrong_lastname" ];
                $code = 108;
                break;
            case "wrong_code":
            case 109:
                $message = PersianText::MESSAGE[ "wrong_code" ];
                $code = 109;
                break;
            case "already_registered":
            case 110:
                $message = PersianText::MESSAGE[ "already_registered" ];
                $code = 110;
                break;
            case "already_logged_in":
            case 111:
                $message = PersianText::MESSAGE[ "already_logged_in" ];
                $code = 111;
                break;
            case "not_logged_in":
            case 112:
                $message = PersianText::MESSAGE[ "not_logged_in" ];
                $code = 112;
                break;
            case "wrong_user_type":
            case 113:
                $message = PersianText::MESSAGE[ "wrong_user_type" ];
                $code = 113;
                break;
            case "wrong_telephone":
            case 114:
                $message = PersianText::MESSAGE[ "wrong_telephone" ];
                $code = 114;
                break;
            case "wrong_nationalCode":
            case 115:
                $message = PersianText::MESSAGE[ "wrong_nationalCode" ];
                $code = 115;
                break;
            case "wrong_password":
            case 116:
                $message = PersianText::MESSAGE[ "wrong_password" ];
                $code = 116;
                break;
            case "expired_code":
            case 117:
                $message = PersianText::MESSAGE[ "expired_code" ];
                $code = 117;
                break;
            case "used_code":
            case 118:
                $message = PersianText::MESSAGE[ "used_code" ];
                $code = 118;
                break;
            case "wrong_system_code":
            case 119:
                $message = PersianText::MESSAGE[ "wrong_system_code" ];
                $code = 119;
                break;
        }

        if ( $show_code ) $message .= "Error " . $code;

        header( "Content-Type: application/json" );
        echo jsonEncodeUnicode( [
            "status"  => "failed",
            "data"    => $data,
            "message" => $message,
        ] );
        exit;
    }

    /**
     * @param string|int $key `done` 200 | ``
     */
    public static function Success( $key, $data = [], $show_code = FALSE ) {
        
        switch ( $key ) {
            case "done":
            case 200:
                $message = PersianText::MESSAGE[ "done" ];
                $code = 200;
                break;
            case "success_sms":
            case 200:
                $message = PersianText::MESSAGE[ "success_sms" ];
                $code = 200;
                break;
        }

        if ( $show_code ) $message .= "Success " . $code;

        header( "Content-Type: application/json" );
        echo jsonEncodeUnicode( [
            "status"  => "success",
            "data"    => $data,
            "message" => $message,
        ] );
        exit;
    }
    
}