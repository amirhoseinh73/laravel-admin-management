<?php

namespace App\Http\Controllers;

use App\Helpers\Alert;
use App\Helpers\Helper;
use App\Helpers\PersianText;
use App\Models\Shopping\AddressModel;
use App\Models\Shopping\CartItemModel;
use App\Models\Shopping\PaymentRequestModel;
use App\Models\Shopping\PaymentTrackModel;
use App\Models\Shopping\ProvinceCityModel;
use Illuminate\Http\Request;

class ShoppingController extends Controller
{
    public function index( Request $request ) {
        $data = [
            'head_title'  => PersianText::WORD[ "dashboard" ] . " | " . PersianText::WORD[ "welcome" ],
            'title'       => PersianText::WORD[ "shopping" ],
            'description' => PersianText::WORD[ "order_list" ],
            'user_data'   => $this->userInfo( $request ),
        ];
        
        return view( "dashboard.order-list", $data );
    }

    public function list() {
        $selectAllData = $this->getDataForPaymentRecord();
        $selectAllPaymentTracks = $selectAllData[ "allPaymentTracks" ];
        $selectAllShoppingUsers = $selectAllData[ "allShoppingUsers" ];
        $selectAllPaymentRequests = $selectAllData[ "allPaymentRequests" ];
        $selectAllAddresses = $selectAllData[ "allAddresses" ];
        $selectAllCartItems = $selectAllData[ "allCartItems" ];
        $selectAllProducts = $selectAllData[ "allProducts" ];
        $selectAllProvinceCities = $selectAllData[ "allProvinceCities" ];
        $selectAllOrders = $selectAllData[ "allOrders" ];

        $dataToReturn = array();
        foreach( $selectAllPaymentTracks as $selectPaymentTrack ) {

            $selectUser = filterArrayUsingParam( $selectAllShoppingUsers, $selectPaymentTrack, "ID", "user_id" );
            if ( ! exists( $selectUser ) || ! exists( $selectUser[ 0 ] ) ) continue;
            $selectUser = $selectUser[ 0 ];

            $selectPaymentRequest = filterArrayUsingParam( $selectAllPaymentRequests, $selectPaymentTrack, "ID", "payment_request_id" );
            if ( ! exists( $selectPaymentRequest ) || ! exists( $selectPaymentRequest[ 0 ] ) ) continue;
            $selectPaymentRequest = $selectPaymentRequest[ 0 ];

            $selectOrder = filterArrayUsingParam( $selectAllOrders, $selectPaymentRequest, "ID", "order_id" );
            if ( ! exists( $selectOrder ) || ! exists( $selectOrder[ 0 ] ) ) continue;
            $selectOrder = $selectOrder[ 0 ];

            $addressInfo = $this->getAddressInfo( $selectOrder, $selectAllAddresses, $selectAllProvinceCities );
            $address = $addressInfo[ "address" ];
            $postCode = $addressInfo[ "postCode" ];

            $selectCartItems = array_values( array_filter( $selectAllCartItems, function( $key ) use( $selectOrder ) {
                $cartItemIDs = explode( ",", $selectOrder[ "cart_items_ids" ] );
                return in_array( $key[ "ID" ], $cartItemIDs );
            } ) );
            if ( ! exists( $selectCartItems ) ) continue;

            $productList = $this->getListProduct( $selectOrder, $selectAllCartItems, $selectAllProducts );

            $jalaaliDateTime = convertGregorianDateTimeToJalaali( $selectPaymentTrack[ "created_at" ] );

            $dataToReturn[] = array(
                "firstname" => $selectUser[ "firstname" ],
                "lastname" => $selectUser[ "lastname" ],
                "username" => $selectUser[ "national_code" ],
                "mobile" => $selectUser[ "mobile" ],
                "amount" => $selectPaymentTrack[ "amount" ],
                "amount_discounted" => $selectPaymentTrack[ "amount_discounted" ],
                "order_id" => $selectPaymentRequest[ "order_id" ],
                "productList" => $productList,
                "address" => $address,
                "post_code" => $postCode,
                "res_num" => $selectPaymentTrack[ "res_num" ],
                "created_at" => $jalaaliDateTime
            );
        }

        return Alert::Success( 200, $dataToReturn );
    }

    private function getDataForPaymentRecord() {
        $userShoppingModel = $this->userShoppingModel();
        $paymentTrackModel = $this->paymentTrackModel();
        $paymentRequestModel = $this->paymentRequestModel();
        $addressModel = $this->addressModel();
        $cartItemModel = $this->cartItemModel();
        $productModel = $this->productModel();
        $provinceCityModel = $this->provinceCityModel();
        $orderModel = $this->orderModel();

        return array(
            "allPaymentTracks" => $paymentTrackModel->all()->toArray(),
            "allShoppingUsers" => $userShoppingModel->all()->toArray(),
            "allPaymentRequests" => $paymentRequestModel->all()->toArray(),
            "allAddresses" => $addressModel->all()->toArray(),
            "allCartItems" => $cartItemModel->all()->toArray(),
            "allProducts" => $productModel->all()->toArray(),
            "allProvinceCities" => $provinceCityModel->all()->toArray(),
            "allOrders" => $orderModel->all()->toArray()
        );
    }

    private function getAddressInfo( $selectOrder, $selectAllAddresses, $selectAllProvinceCities ) {
        $dataToReturn = array(
            "address" => "",
            "postCode" => ""
        );
        if ( ! exists( $selectOrder[ "address_id" ] ) ) return $dataToReturn;

        $selectAddress = filterArrayUsingParam( $selectAllAddresses, $selectOrder, "ID", "address_id" );
        if ( ! exists( $selectAddress ) || ! exists( $selectAddress[ 0 ] ) ) return $dataToReturn;
        $selectAddress = $selectAddress[ 0 ];

        $selectProvince = filterArrayUsingParam( $selectAllProvinceCities, $selectAddress, "ID", "province_id" );
        if ( ! exists( $selectProvince ) || ! exists( $selectProvince[ 0 ] ) ) return $dataToReturn;
        $selectProvince = $selectProvince[ 0 ];

        $selectCity = filterArrayUsingParam( $selectAllProvinceCities, $selectAddress, "ID", "city_id" );
        if ( ! exists( $selectCity ) || ! exists( $selectCity[ 0 ] ) ) return $dataToReturn;
        $selectCity = $selectCity[ 0 ];

        $dataToReturn[ "address" ] = $selectProvince[ "title" ] . " - " . $selectCity[ "title" ] . " - " . $selectAddress[ "address" ];
        $dataToReturn[ "postCode" ] = $selectAddress[ "postcode" ];

        return $dataToReturn;
    }

    private function getListProduct( $selectOrder, $selectAllCartItems, $selectAllProducts ) {
        $productList = array();
        $selectCartItems = array_values( array_filter( $selectAllCartItems, function( $key ) use( $selectOrder ) {
            $cartItemIDs = explode( ",", $selectOrder[ "cart_items_ids" ] );
            return in_array( $key[ "ID" ], $cartItemIDs );
        } ) );
        if ( ! exists( $selectCartItems ) ) $productList;

        foreach( $selectCartItems as $cartItem ) {
            $selectProduct = filterArrayUsingParam( $selectAllProducts, $cartItem, "ID", "product_id" );
            if ( ! exists( $selectProduct ) || ! exists( $selectProduct[ 0 ] ) ) continue;
            $selectProduct = $selectProduct[ 0 ];

            $DownloadOrDVD = "آنلاین";
            if ( $selectProduct[ "type" ] === 1 ) {
                $isPhysical = Helper::PRODUCT_DESCRIPTION_REVERSE[ $cartItem[ "description" ] ];
                $DownloadOrDVD = "دانلودی";
                if ( $isPhysical ) $DownloadOrDVD = "DVD";
            }

            $title = $selectProduct[ "title" ];
            $count = $cartItem[ "count" ];

            $productList[] = "$title * $count ($DownloadOrDVD)";
        }

        return $productList;
    }

    private function paymentTrackModel() {
        return new PaymentTrackModel();
    }

    private function paymentRequestModel() {
        return new PaymentRequestModel();
    }

    private function addressModel() {
        return new AddressModel();
    }

    private function cartItemModel() {
        return new CartItemModel();
    }

    private function provinceCityModel() {
        return new ProvinceCityModel();
    }
}
