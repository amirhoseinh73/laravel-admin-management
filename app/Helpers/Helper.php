<?php

namespace App\Helpers;

use App\Libraries\SmsIrUltraFastSendClass;
use Exception;

class Helper {
    const PRODUCT_DESCRIPTION_REVERSE = array(
        "physical - post" => true,
        "download - link" => false
    );
    
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

    public static function sendSmsIRRegister( $mobile, $username, $password ) {
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
                        "Parameter" => "Username",
                        "ParameterValue" => $username
                    ),
                    array(
                        "Parameter" => "Password",
                        "ParameterValue" => $password
                    ),
                ),
                "Mobile" => $mobile,
                "TemplateId" => 71213,
            );
    
            $SmsIR_UltraFastSend = new SmsIrUltraFastSendClass($APIKey, $SecretKey, $APIURL);
            $UltraFastSend = $SmsIR_UltraFastSend->ultraFastSend($data);
    
            return $UltraFastSend;
        } catch ( \Exception $e ) {
            echo 'Error UltraFastSend : ' . $e->getMessage();
        }
    }

    public static function sendSmsIRSimple( array $MobileNumbers, array $Messages ) {
        try {
            date_default_timezone_set("Asia/Tehran");
    
            // your sms.ir panel configuration
            $APIKey = "73ee8e0c4a266f2fa3b7b8a7";
            $SecretKey = "Vira@5668";

            $LineNumber = "30004554551733";
            $APIURL = "https://ws.sms.ir/";

            // sending date
            @$SendDateTime = date("Y-m-d")."T".date("H:i:s");

            $SmsIR_SendMessage = new SmsIrUltraFastSendClass($APIKey, $SecretKey, $APIURL, $LineNumber);
            $SendMessage = $SmsIR_SendMessage->sendMessage($MobileNumbers, $Messages, $SendDateTime);
    
            return $SendMessage;
        } catch ( Exception $e ) {
            echo 'Error SendMessage : '.$e->getMessage();
        }
    }

    public static function sendSmsIRDiscountCode( $mobile, $discountCode, $date, $percent ) {
        $Messages = array(
            "کد تخفیف $percent درصدی خرید کتاب تعاملی ویرا برای شما فعال شد.
کد تخفیف: $discountCode
مهلت استفاده: $date
https://virabook.ir"
        );

        return self::sendSmsIRSimple( [ $mobile ], $Messages );
    }

    
}