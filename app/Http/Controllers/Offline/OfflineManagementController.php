<?php

namespace App\Http\Controllers\Offline;

use App\Helpers\Alert;
use App\Helpers\PersianText;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;

class OfflineManagementController extends Controller
{
    public function management( Request $request ) {
        $data = [
            'head_title'  => PersianText::WORD[ "dashboard" ] . " | " . PersianText::WORD[ "welcome" ],
            'title'       => PersianText::WORD[ "offline" ],
            'description' => PersianText::WORD[ "offline_management" ],
            'user_data'   => $this->userInfo( $request ),
        ];
        
        return view( "dashboard.offline-code-list", $data );
    }

    public function list() {
        $offlineActivationCodeModel = $this->offlineActivationCodeModel();
        $selectAllCodes = $offlineActivationCodeModel->withTrashed()->get()->toArray();

        $orderModel = $this->orderModel();
        $selectAllOrders = $orderModel->all()->toArray();
        
        $userShoppingModel = $this->userShoppingModel();
        $selectAllShoppingUsers = $userShoppingModel->all()->toArray();

        $selectAllCodes = array_map( array( $this, "mapHandleMobileArraySavedIntoDB" ), $selectAllCodes );

        $callbackMap = function ( $selectAllCodes ) use ( $selectAllOrders, $selectAllShoppingUsers ){
            return $this->mapHandleOrderID( $selectAllCodes, $selectAllOrders, $selectAllShoppingUsers );
        };
        $selectAllCodes = array_map( $callbackMap, $selectAllCodes );
        
        return Alert::Success( 200, $selectAllCodes );
    }

    private function mapHandleMobileArraySavedIntoDB( $code ) {
        $olderCodes = json_decode( $code[ "mobile" ], true );

        
        if( is_array( $olderCodes ) ) {
            $code[ "mobile" ] = array();

            foreach( $olderCodes as $olderCode ) {
                if( is_array( $olderCode ) ) {
                    if ( count( $olderCode ) === 5 ) {
                        $code[ "mobile" ][] = $this->mobileArrayHandler( $olderCode );
                    } else {
                        foreach( $olderCode as $olderCode1 ) {
                            if ( is_array( $olderCode1 ) && count( $olderCode1 ) === 5 ) {
                                $code[ "mobile" ][] = $this->mobileArrayHandler( $olderCode1 );
                            } else {
                                $code[ "mobile" ][] = $olderCode1;
                            }
                        }
                    }
                } else {
                    $code[ "mobile" ][] = $olderCode;
                }
            }
        }

        return $code;
    }

    private function mobileArrayHandler( $code ) {
        $smsText = "از طریق پیامک";
        $pageText = "از طریق لینک";
        return array(
            "موبایل" => $code[ 0 ],
            "تاریخ" => gregorianDatetimeToJalali( $code[ 1 ] )->date,
            "فعالسازی" => ( ( $code[ 2 ] === "page" ) ? $pageText : $smsText ),
            "کد فعالسازی" => $code[ 3 ],
            "کد کاربر" => $code[ 4 ]
        );
    }

    /**
     * $code = $selectAllCodes
     */
    private function mapHandleOrderID( $code, $selectAllOrders, $selectAllShoppingUsers ) {
        if ( ! exists( $code[ "order_id" ] ) ) {
            $code[ "order_id" ] = "";
            return $code;
        }

        $selectOrder = filterArrayUsingParam( $selectAllOrders, $code, "ID", "order_id" );
        if( ! exists( $selectOrder ) || ! exists( $selectOrder[ 0 ] ) ) return $code;

        $selectShoppingUser = filterArrayUsingParam( $selectAllShoppingUsers, $selectOrder[ 0 ], "ID", "user_id" );
        if( ! exists( $selectShoppingUser ) || ! exists( $selectShoppingUser[ 0 ] ) ) return $code;

        $code[ "order_id" ] = $selectShoppingUser[ 0 ][ "firstname" ] . " " . $selectShoppingUser[ 0 ][ "lastname" ] . "<br/>" . $selectShoppingUser[ 0 ][ "mobile" ];

        return $code;
    }

    public function statistics( Request $request ) {
        $data = [
            'head_title'  => PersianText::WORD[ "dashboard" ] . " | " . PersianText::WORD[ "welcome" ],
            'title'       => PersianText::WORD[ "offline" ],
            'description' => PersianText::WORD[ "offline_management" ],
            'user_data'   => $this->userInfo( $request ),
            "statistics"  => $this->getStatistics()
        ];
        
        return view( "dashboard.offline-code-statistics", $data );
    }

    private function getStatistics() {
        $offlineActivationCodeModel = $this->offlineActivationCodeModel();

        $selectAllCodes = $offlineActivationCodeModel->withTrashed()->get();
        $selectAllCodesWithoutDeleted = $offlineActivationCodeModel->get();
        $selectAllCodeDeactivated = $offlineActivationCodeModel->onlyTrashed()->get();

        $countAll = count( $selectAllCodes );
        $countAllActivated = 0;
        $countAllDeactivate = count( $selectAllCodeDeactivated );
        $countAllIsForShoppingSite = 0;
        $countAllIsForShoppingSiteSold = 0;

        $countAllActivatedGrade1 = 0;
        $countAllActivatedGrade2 = 0;
        $countAllActivatedGrade3 = 0;
        $countAllActivatedGrade4 = 0;
        $countAllActivatedGrade5 = 0;
        $countAllActivatedGrade6 = 0;

        foreach( $selectAllCodesWithoutDeleted as $code ) {
            if ( exists( $code->user_code ) ) $countAllActivated++;
            if ( !!$code->is_for_shopping_site ) $countAllIsForShoppingSite++;
            if ( !!$code->is_for_shopping_site && !!$code->is_sold ) $countAllIsForShoppingSiteSold++;

            if ( exists( $code->user_code ) && $code->grade === "1" ) $countAllActivatedGrade1++;
            if ( exists( $code->user_code ) && $code->grade === "2" ) $countAllActivatedGrade2++;
            if ( exists( $code->user_code ) && $code->grade === "3" ) $countAllActivatedGrade3++;
            if ( exists( $code->user_code ) && $code->grade === "4" ) $countAllActivatedGrade4++;
            if ( exists( $code->user_code ) && $code->grade === "5" ) $countAllActivatedGrade5++;
            if ( exists( $code->user_code ) && $code->grade === "6" ) $countAllActivatedGrade6++;
        }

        return array(
            "countAll"  => $countAll,
            "countAllActivated" => $countAllActivated,
            "countAllDeactivate"    => $countAllDeactivate,
            "countAllIsForShoppingSite" => $countAllIsForShoppingSite,
            "countAllIsForShoppingSiteSold" => $countAllIsForShoppingSiteSold,

            "countAllActivatedGrade1" => $countAllActivatedGrade1,
            "countAllActivatedGrade2" => $countAllActivatedGrade2,
            "countAllActivatedGrade3" => $countAllActivatedGrade3,
            "countAllActivatedGrade4" => $countAllActivatedGrade4,
            "countAllActivatedGrade5" => $countAllActivatedGrade5,
            "countAllActivatedGrade6" => $countAllActivatedGrade6,
        );
    }

    public function remove( Request $request ) {
        $id    = $request->post( "id" );
        if ( ! exists( $id ) ) return Alert::Error( "wrong_inputs" );

        $offlineActivationCodeModel = $this->offlineActivationCodeModel();
        try {
            $offlineActivationCodeModel->removeItemByID( $id );

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

        $offlineActivationCodeModel = $this->offlineActivationCodeModel();

        try {
            $data = array(
                "$key" => $data,
            );
            $offlineActivationCodeModel->updateRowByID( $ID, $data );

            return Alert::Success( 200 );
        } catch( Exception $e ) {
            return Alert::Error( -1 );
        }
    }
}