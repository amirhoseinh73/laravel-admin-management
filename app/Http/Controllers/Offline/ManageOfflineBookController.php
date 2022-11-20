<?php

namespace App\Http\Controllers\Offline;

use App\Helpers\Alert;
use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ManageOfflineBookController extends Controller
{
    public function page() {
        $data_page = [
            "titlePage" => "دریافت کد فعالسازی آفلاین",
            // "captchaText" => createMathCaptchaText( $request ),
        ];

        return view('offline-activation-code', $data_page );
    }

    public function generateActivationCodePage( Request $request ) {
        $userCode = $request->post( "code" );
        $mobile = $request->post( "mobile" );
        $captchaAnswer = $request->post( "captchaAnswer" );

        if ( ! exists( $userCode ) || strlen( trim( $userCode ) ) !== 21 ) return Alert::Error( "wrong_code" );
        if ( ! exists( $mobile ) || ! isValidMobile( $mobile ) ) return Alert::Error( "wrong_mobile" );
        if ( ! isset( $captchaAnswer ) || ! validateMathCaptchaAnswer( $request, $captchaAnswer ) ) return Alert::Error( "wrong_inputs" );

        $calcCode = $this->calcCode( $userCode );
        $generatedCode = $calcCode->generatedCode;
        $indexCode = $calcCode->indexCode;

        $offlineActivationCodeModel = $this->offlineActivationCodeModel();
        $selectCode = $offlineActivationCodeModel->selectCodeByIndex( $indexCode );

        if ( ! exists( $selectCode ) ) return Alert::Error( "wrong_code" );

        //no update
        $checkRepeatedCode = $this->checkRepeatedCode( $selectCode, $userCode, $generatedCode, $mobile );
        if ( exists( $checkRepeatedCode ) ) return Alert::Success( "success_sms" );

        if ( +$selectCode->limit_usage === 0 ) return Alert::Error( "limit_code" );

        try {
            $result = $this->updateOfflineCodeDB( $selectCode, $mobile, $userCode, $generatedCode, "page" );
            if ( ! $result ) throw new Exception( "failed DB" );

            Helper::sendSmsIR( $mobile, $generatedCode, "success" );
            return Alert::Success( "success_sms" );
        } catch ( Exception $e ) {
            logFile($e);
            return Alert::Error( "wrong_code" );
        }
    }
    
    public function generateActivationCode( Request $request ) {
        $from = $request->get( "from" );
        $to = $request->get( "to" );
        $message = $request->get( "message" );

        logFile( [$from, $to, $message], "logSMS" );
        if ( ! exists( $from ) || ! exists( $to ) || ! exists( $message ) ) return false;

        $userCode = $message;
        $mobile = $from;
        if ( ! exists( $userCode ) || strlen( trim( $userCode ) ) !== 21 ) return Helper::sendSmsIR( $mobile, $userCode, "wrong_code" );

        $calcCode = $this->calcCode( $userCode );
        $generatedCode = $calcCode->generatedCode;
        $indexCode = $calcCode->indexCode;

        $offlineActivationCodeModel = $this->offlineActivationCodeModel();
        $selectCode = $offlineActivationCodeModel->selectCodeByIndex( $indexCode );

        if ( ! exists( $selectCode ) ) return Helper::sendSmsIR( $mobile, $userCode, "wrong_code" );

        //no update
        $checkRepeatedCode = $this->checkRepeatedCode( $selectCode, $userCode, $generatedCode, $mobile );
        if ( exists( $checkRepeatedCode ) ) return $checkRepeatedCode;
        if ( +$selectCode->limit_usage === 0 ) return Helper::sendSmsIR( $mobile, $userCode, "limit_code" );

        try {
            $result = $this->updateOfflineCodeDB( $selectCode, $mobile, $userCode, $generatedCode, "sms" );
            if ( ! $result ) throw new Exception( "failed DB" );

            return Helper::sendSmsIR( $mobile, $generatedCode, "success" );
        } catch ( Exception $e ) {
            logFile($e);
            return Helper::sendSmsIR( $mobile, $userCode, "wrong_code" );
        }
    }

    private function calcCode( $userCode ) {
        $strOfCode = substr( $userCode, 0, 5 ) . "Vira" . substr( $userCode, 5, 10 ) . "#2365" . substr( $userCode, 10, 11 );
        $generatedCode = crc32( $strOfCode ); //last 6 number
        $generatedCode = substr( $generatedCode, -6 );
        $indexCode = intval( substr( $userCode, 0, 6 ) );

        return (object)array(
            "generatedCode" => $generatedCode,
            "indexCode" => $indexCode
        );
    }

    private function checkRepeatedCode( $selectCode, $userCode, $generatedCode, $mobile ) {
        if ( $selectCode->user_code === $userCode ) {
            return Helper::sendSmsIR( $mobile, $generatedCode, "success" );
        }
        $olderCodes = json_decode( $selectCode->mobile, true );
        
        if( ! is_array( $olderCodes ) ) return null;

        foreach( $olderCodes as $olderCode ) {
            if ( is_array( $olderCode ) && in_array( "$generatedCode", $olderCode ) )
                return Helper::sendSmsIR( $mobile, $generatedCode, "success" );
        }

        return null;
    }

    private function updateOfflineCodeDB( $selectCode, $mobile, $userCode, $generatedCode, $type ) {
        $offlineActivationCodeModel = $this->offlineActivationCodeModel();

        $mobileArray = array();

        $oldMobile = json_decode( $selectCode->mobile, true );
        if ( exists( $oldMobile ) ) {
            if ( is_array( $oldMobile ) ) $mobileArray = $oldMobile;
            elseif ( ! is_array( $oldMobile ) ) $mobileArray = [ $oldMobile ];
        }

        array_push(
            $mobileArray,
            [
                $mobile,
                date( "Y-m-d H:i:s" ),
                $type,
                $generatedCode,
                $userCode
            ]
        );

        $dataToUpdate = array(
            "limit_usage"    => ( +$selectCode->limit_usage - 1 ),
            "user_code"      => $userCode,
            "mobile"         => jsonEncodeUnicode( $mobileArray ),
            "generated_code" => $generatedCode
        );

        $result = $offlineActivationCodeModel->updateDataByID( $selectCode->id, $dataToUpdate );
        return $result;
    }

    public function addCodesFromExcelToDB() {
        $path = array(
            public_path( "/excel/codes1.xlsx" ),
            public_path( "/excel/codes2.xlsx" ),
            public_path( "/excel/codes3.xlsx" ),
            public_path( "/excel/codes4.xlsx" ),
            public_path( "/excel/codes5.xlsx" ),
            public_path( "/excel/codes6.xlsx" )
        );

        # open the file
        $reader = ReaderEntityFactory::createXLSXReader();

        $dataToInsert = array();
        foreach( $path as $pt ) {
            $reader->open( $pt );
            # read each cell of each row of each sheet
            foreach ($reader->getSheetIterator() as $sheet) {
                foreach ($sheet->getRowIterator() as $index => $row) {
                    if ( $index === 1 ) continue;
                    foreach ( $row->getCells() as $idx => $cell ) {
                        if ( $idx !== 0 ) continue;
                        $dataToInsert[] = array(
                            "grade" => $row->getCells()[ $idx + 1 ]->getValue(),
                            "index_code" => $row->getCells()[ $idx + 2 ]->getValue(),
                            "windows_code" => $row->getCells()[ $idx + 3 ]->getValue()
                        );
                    }
                }
            }
            $reader->close();
        }
        

        $offlineActivationCodeModel = $this->offlineActivationCodeModel();
        try {
            $offlineActivationCodeModel->insert( $dataToInsert );
            _dump( "done" );
        } catch( Exception $e ) {
            _dump( $e );
        }
    }

    public function updateSiteCodesFromExcelToDB() {
        $path = public_path( "/excel/offlineCodesWindows.xlsx" );
        # open the file
        $reader = ReaderEntityFactory::createXLSXReader();
        $reader->open($path);
        # read each cell of each row of each sheet
        $dataToUpdate = array();
        foreach ($reader->getSheetIterator() as $sheet) {
            foreach ($sheet->getRowIterator() as $index => $row) {
                if ( $index === 1 ) continue;
                foreach ( $row->getCells() as $idx => $cell ) {
                    if ( $idx !== 0 ) continue;
                    $dataToUpdate[] = array(
                        "windows_code" => $row->getCells()[ $idx + 3 ]->getValue(),
                        "is_for_shopping_site" => true,
                        "is_sold" => false,
                    );
                }
            }
        }
        $reader->close();

        $offlineActivationCodeModel = $this->offlineActivationCodeModel();
        try {
            DB::table( $offlineActivationCodeModel->getTable() )->upsert( $dataToUpdate, [ "windows_code" ], [ "is_for_shopping_site", "is_sold" ] );
            _dump( "done" );
        } catch( Exception $e ) {
            logFile( $e );
            _dump("error");
        }
    }

    public function refreshCaptcha( Request $request ) {
        return Alert::Success( 200, createMathCaptchaText( $request ) );
    }
}
