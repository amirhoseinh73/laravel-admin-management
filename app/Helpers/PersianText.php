<?php

namespace App\Helpers;

class PersianText {

    /**
     * @param string $key `failed`|`wrong_inputs`|`failed_remove_content`
     */
    const MESSAGE = array(
        "no_response"      => "متاسفانه سرور مشغول است! لطفا چند دقیقه دیگر امتحان کنید.",
        "failed"           => "متاسفانه عملیات انجام نشد!",
        "wrong_inputs"     => "ورودی ها اشتباه است!",
        "not_valid_user"   => "شما مجاز به انجام این کار نیستید",
        "no_access"        => "درخواست صحیح نیست!",
        "wrong_mobile"     => "شماره همراه وارد شده اشتباه است!",
        "wrong_firstname"  => "نام خود را وارد کنید!",
        "wrong_lastname"   => "نام خانوادگی خود را وارد کنید!",
        "wrong_otp"        => "کد وارد شده اشتباه است!",
        "account_disabled" => "حساب شما موقتا غیر فعال شده است، با پشتیبانی تماس بگیرید!",
        "no_data"          => "اطلاعاتی یافت نشد!",
        "duplicate_mobile" => "شماره وارد شده قبلا در سیستم ثبت شده است!",
        "already_registered" => "ثبت نام شما قبلا انجام شده است!",
        "already_logged_in"  => "شما قبلا وارد سیستم شده اید!",
        "not_logged_in"      => "ابتدا وارد سیستم شوید!",
        "wrong_user_type"    => "نوع کاربری به درستی انتخاب نشده است!",
        "wrong_telephone"    => "شماره تلفن ثابت به درستی وارد نشده است!",
        "wrong_nationalCode" => "کد ملی به درستی وارد نشده است!",
        "wrong_password"     => "رمز عبور اشتباه است!",
        "wrong_code"         => "کد وارد شده اشتباه است!",
        "expired_code"       => "مهلت استفاده از کد وارد شده به پایان رسیده است!",
        "used_code"          => "کد وارد شده قبلا استفاده شده است!",
        "wrong_system_code"  => "کد وارد شده در این سامانه قابل استفاده نیست!",

        "done" => "عملیات با موفقیت انجام شد!",
        "success_sms" => "کد فعالسازی برای شما پیامک شد.",

        "login_description" => "جهت دسترسی به پنل مدیریت وارد شوید",
    );
    
    /**
     * @param string $key `welcome`|`dear_user`|`logout`|`login`|`remember_me`|`recovery_pass`|`username`
     * |`password`|`success`|`failed`|``|``|``
     */
    const WORD = array(
            "welcome"       => "خوش آمدید!",
            "dear_user"     => "کاربر عزیز",
            "logout"        => "خروج",
            "login"         => "ورود",
            "remember_me"   => "مرا به خاطر بسپار",
            "recovery_pass" => "بازیابی رمز عبور",
            "username"      => "نام کاربری",
            "password"      => "رمز عبور",
            "dashboard"     => "داشبورد",
            "discount_code" => "کد تخفیف",
            "discount_code_management" => "مدیریت کدهای تخفیف",

            "success"       => "موفقیت!",
            "failed"        => "خطا!",

            "copyright"        => "تمامی حقوق مربوط به شرکت مهندسی ایده بنیان ویرا می باشد.",
    );

    /**
     * @param string $code
     */
    public static function sms_message( $code ) {
        return "به فروشگاه ویرا خوش آمدید!
    کد تایید: $code";
    }
}