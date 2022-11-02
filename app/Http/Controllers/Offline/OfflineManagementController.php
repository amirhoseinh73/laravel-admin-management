<?php

namespace App\Http\Controllers\Offline;

use App\Helpers\Alert;
use App\Helpers\PersianText;
use App\Http\Controllers\Controller;
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
}