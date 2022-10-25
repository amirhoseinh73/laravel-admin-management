<?php

namespace App\Helpers;

use App\Libraries\SmsIrUltraFastSendClass;

class Helper {
    public static function sendSmsIR( $mobile, $code, $templateName = "wrong_code" ) {
        switch( $templateName ) {
            case "wrong_code":
                $templateID = 70163;
                break;
            case "limit_code":
                $templateID = 70838;
                break;
            case "success":
                $templateID = 70159;
                break;
        }
        try {
            date_default_timezone_set("Asia/Tehran");
    
            // your sms.ir panel configuration
            $APIKey = "73ee8e0c4a266f2fa3b7b8a7";
            $SecretKey = "Vira@5668";
    
            $APIURL = "https://ws.sms.ir/";
            // message data
            $data = array(
                "ParameterArray" => array(
                    array(
                        "Parameter" => "VerificationCode",
                        "ParameterValue" => $code
                    ),
                ),
                "Mobile" => $mobile,
                "TemplateId" => $templateID,
            );
    
            $SmsIR_UltraFastSend = new SmsIrUltraFastSendClass($APIKey, $SecretKey, $APIURL);
            $UltraFastSend = $SmsIR_UltraFastSend->ultraFastSend($data);
    
            return $UltraFastSend;
        } catch ( \Exception $e ) {
            echo 'Error UltraFastSend : ' . $e->getMessage();
        }
    }
}