<?php

/**
 * @author amirhosein hasani
 * check exists item -> isset() && !empty()
 * @param mixed $item
 * @return boolean true | false
 */
function exists( $data ) {
    if( is_object( $data ) ) $data = (array)$data;
    
    return ( isset( $data ) && ! empty( $data ) );
}

function jsonEncodeUnicode( array $data ) {
    header( "Content-Type: application/json" );
    echo json_encode( $data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    exit;
}

function _dump( ...$item ){
    echo '<pre>';
    var_dump( ...$item );
    echo '</pre>';
    die;
}

function _json_die( $item ) {
    header( "Content-Type: application/json" );
    echo json_encode( $item, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE );
    die;
}

function randomVerificationCode( $length = 8, $only_number = true ) {
    $permitted_chars = "123456789";
    if ( ! $only_number ) $permitted_chars .= "ABCDEFGHKMNPRSTWXYZ";

    for ( $i = 0; $i < 3; $i++ ) $permitted_chars .= $permitted_chars;

    return substr( str_shuffle( $permitted_chars ), 0, $length );
}

function arraySort( $array, $on, $order = SORT_ASC ) {
    $new_array = array();
    $sortable_array = array();

    if (count($array) > 0) {
        foreach ($array as $k => $v) {
            if (is_array($v)) {
                foreach ($v as $k2 => $v2) {
                    if ($k2 == $on) {
                        $sortable_array[$k] = $v2;
                    }
                }
            } else {
                $sortable_array[$k] = $v;
            }
        }
        switch ($order) {
            case SORT_ASC:
                asort($sortable_array);
                break;
            case SORT_DESC:
                arsort($sortable_array);
                break;
        }


        foreach ($sortable_array as $k => $v) {
            $new_array[$k] = $array[$k];
        }
    }

    return $new_array;
}

function detailOfFileByFormat( $format ) {
    switch ( $format ) {
        case 'jpg':
        case 'jpeg':
        case 'png':
        case 'gif':
            $type = 'image';
            $icon = 'fa-file-image';
            break;
        case 'mp3':
        case 'wave':
            $type = 'audio';
            $icon = 'fa-file-audio';
            break;
        case 'mp4':
        case 'avi':
            $type = 'video';
            $icon = 'fa-file-video';
            break;
        default:
            $type = 'file';
            $icon = 'fa-file-pdf';
            break;
    }

    return (object)[
        "format" => $format,
        "icon"   => $icon,
        "type"   => $type,
    ];
}

function isValidNationalCodeIran($input) {
    // return true;
    if (!preg_match("/^\d{10}$/", $input)
        || $input == '0000000000'
        || $input == '1111111111'
        || $input == '2222222222'
        || $input == '3333333333'
        || $input == '4444444444'
        || $input == '5555555555'
        || $input == '6666666666'
        || $input == '7777777777'
        || $input == '8888888888'
        || $input == '9999999999') {
        return false;
    }
    $check = (int)$input[9];
    $sum = array_sum(array_map(function ($x) use ($input) {
            return ((int)$input[$x]) * (10 - $x);
        }, range(0, 8))) % 11;
    return ($sum < 2 && $check == $sum) || ($sum >= 2 && $check + $sum == 11);
}

function isValidMobile( $mobile ) {
    if ( ! is_numeric( $mobile ) ) return false;
    if ( strlen( $mobile ) !== 11 ) return false;
    if ( $mobile[ 0 ] !== "0" ) return false;
    if ( $mobile[ 1 ] !== "9" ) return false;
    return true;
}

function isValidPassword($password){
    if (strlen($password) < 6) {
        return false;
    } else {
        return true;
    }
}

function isValidBase64( $str ) {
    if ( strpos( $str, 'base64' ) && base64_encode( base64_decode( explode( 'base64,', $str )[ 1 ], true ) ) === explode( 'base64,', $str )[ 1 ]) return TRUE;
    
    return FALSE;
}

//TODO:
function saveRequestFiles( object $file, string $address ) {
    $saved_file_name = FALSE;
    $valid_extensions = array(
        "jpg",
        "png",
        "gif",
        "mp3",
        "mp4",
        "pdf",
        "txt",
        "json"
    );
    if ($file->isValid() && !$file->hasMoved()) {
        // $file_size = $file->getSize();

        if ( ! in_array( $file->guessExtension(), $valid_extensions ) ) return FALSE;

        $random_name = $file->getRandomName();
        $file->move( public_path( $address, $random_name ) );
        $saved_file_name = $random_name;
    }

    return $saved_file_name;
}

function addJsonToFile( $fileData, $folderPath ) {
    //file name
    $fileName = md5( randomVerificationCode( 10, false ) ) . time() . ".json";

    //folder path
    $filePath = public_path( $folderPath . $fileName );

    $fileData = is_string( $fileData ) ? $fileData : jsonEncodeUnicode( $fileData );

    //save
    $isFileCreated = file_put_contents( $filePath, $fileData );

    if( !$isFileCreated ) return FALSE;

    return $fileName;
}

function deleteOldFiles( array $files, string $address ) {
    foreach ( $files as $file ) :
        if ( file_exists( public_path( $address . $file ) ) ) :
            @unlink( public_path( $address . $file ) );
        endif;
    endforeach;
}

/**
 * @return object `time` & `date`
 */
function gregorianDatetimeToJalali( $datetime ) {
    $datetime = explode( " ", $datetime );
    $time     = $datetime[ count( $datetime ) - 1 ];
    $date     = explode( "-", $datetime[ 0 ] );
    $date     = gregorian_to_jalali( $date[ 0 ], $date[ 1 ], $date[ 2 ], "/" );

    return ( object ) [
        "time" => $time,
        "date" => $date,
    ];
}

/**
 * @param string $type `gregorian`|`jalali`
 */
function getCurrentDateTime( string $type = "gregorian", int $time = null ) {

    if ( ! exists( $type ) ) $type = "gregorian";
    if ( ! exists( $time ) ) $time = time();

    if ( $type === "jalali" ) return jdate( "Y-m-d H:i:s", $time );
    return date( "Y-m-d H:i:s", $time );
}


function toFixed($number, $decimals = 1){
    $expo   = pow(10,$decimals);
    $number = intval( $number * $expo ) / $expo;

    return $number;
}

function logFile($data, $name = null){
    if ( ! $name ) $name = "log-" . time() . ".json";
    $log = fopen( public_path( $name ), "w+");
    fwrite($log, json_encode($data, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
    fclose($log);
}

function createMathCaptchaText() {
    $operators = array(
        "+",
        "-",
        "*"
    );
    $operatorIndex = rand( 0, ( count( $operators ) - 1 ) );
    $operator = $operators[ $operatorIndex ];

    $firstNumber = rand( 10, 20 );
    $secondNumber = rand( 0, 10 );

    if ( $operator === "*" ) $firstNumber = rand( 0, 10 );

    switch( $operator ) {
        case "+":
            $answer = $firstNumber + $secondNumber;
            break;
        case "-":
            $answer = $firstNumber - $secondNumber;
            break;
        case "*":
            $answer = $firstNumber * $secondNumber;
            break;
        default:
            $answer = 0;
            break;
    }

    $session = session();
    $session->set( "captchaMathAnswer", $answer );

    return "$firstNumber $operator $secondNumber = ";
}

function validateMathCaptchaAnswer( $userAnswer ) {
    $session = session();
    $systemAnswer = $session->get( "captchaMathAnswer" );

    if ( ! exists( $systemAnswer ) ) return false;

    if ( intval( $systemAnswer ) !== intval( $userAnswer ) ) return false;

    return true;
}