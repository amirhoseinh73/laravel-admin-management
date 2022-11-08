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
            /**
             * @author amirhosein hasani
             * @see
             * if anyone after me reach this code
             * please don't insult me.
             * following function is the result of CEO's idea of this project (manager of this company) and I just F**ing done it.
             */
            $code[ "mobile" ] = $this->removeArrayInArray( $olderCodes );
            $code[ "mobile" ] = $this->removeArrayInArray2( $code[ "mobile" ] );
        }

        return $code;
    }

    private function removeArrayInArray( $code ) {
        if ( is_array( $code ) ) {
            switch ( count( $code ) ) {
                case 1:
                    if ( is_array( $code ) ) {
                        return $this->removeArrayInArray( $code[ 0 ] );
                    }
                    return $this->mobileArrayHandler( $code );
                case 2:
                    $code2 = [];
                    foreach( $code as $c ) {
                        $code2[] = $this->removeArrayInArray( $c );
                    }
                    return $code2;
                case 5:
                    return $this->mobileArrayHandler( $code );
            }
        }

        return $this->mobileArrayHandler( $code );
    }

    private function removeArrayInArray2( $code ) {
        $returnData = [];
        if ( is_array( $code ) ) {
            foreach( $code as $fc ) {
                if ( is_array( $fc ) ) {
                    if ( count( $fc ) === 5 ) {
                        $returnData[] = $fc;
                    } else {
                        foreach( $fc as $fck ) {
                            if ( is_array( $fck ) ) {
                                if ( count( $fck ) === 5 ) {
                                    $returnData[] = $fck;
                                } else {
                                    foreach( $fck as $fckun ) {
                                        if ( is_array( $fckun ) ) {
                                            if ( count( $fckun ) === 5 ) {
                                                $returnData[] = $fckun;
                                            }
                                        } else {
                                            $returnData[] = $fckun;
                                        }
                                    }
                                }
                            } else {
                                $returnData[] = $fck;
                            }
                        }
                    }
                } else {
                    $returnData[] = $fc;
                }
            }
        } else {
            $returnData[] = $code;
        }

        return $returnData;
    }

    private function mobileArrayHandler( $code ) {
        $smsText = "از طریق پیامک";
        $pageText = "از طریق لینک";
        if ( ! is_array( $code ) ) return array(
            "موبایل" => $code,
        );
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