<?php

namespace App\Http\Controllers;

use App\Helpers\Alert;
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
        $userShoppingModel = $this->userShoppingModel();
        $paymentTrackModel = $this->paymentTrackModel();
        $paymentRequestModel = $this->paymentRequestModel();
        $addressModel = $this->addressModel();
        $cartItemModel = $this->cartItemModel();
        $productModel = $this->productModel();
        $provinceCityModel = $this->provinceCityModel();
        $orderModel = $this->orderModel();

        $selectAllPaymentTracks = $paymentTrackModel->all()->toArray();
        $selectAllShoppingUsers = $userShoppingModel->all()->toArray();
        $selectAllPaymentRequests = $paymentRequestModel->all()->toArray();
        $selectAllAddresses = $addressModel->all()->toArray();
        $selectAllCartItems = $cartItemModel->all()->toArray();
        $selectAllProducts = $productModel->all()->toArray();
        $selectAllProvinceCities = $provinceCityModel->all()->toArray();
        $selectAllOrders = $orderModel->all()->toArray();

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

            $address = "";
            $postCode = "";
            if ( exists( $selectOrder[ "address_id" ] ) ) {
                $selectAddress = filterArrayUsingParam( $selectAllAddresses, $selectOrder, "ID", "address_id" );
                if ( ! exists( $selectAddress ) || ! exists( $selectAddress[ 0 ] ) ) continue;
                $selectAddress = $selectAddress[ 0 ];

                $selectProvince = filterArrayUsingParam( $selectAllProvinceCities, $selectAddress, "ID", "province_id" );
                if ( ! exists( $selectProvince ) || ! exists( $selectProvince[ 0 ] ) ) continue;
                $selectProvince = $selectProvince[ 0 ];

                $selectCity = filterArrayUsingParam( $selectAllProvinceCities, $selectAddress, "ID", "city_id" );
                if ( ! exists( $selectCity ) || ! exists( $selectCity[ 0 ] ) ) continue;
                $selectCity = $selectCity[ 0 ];

                $address = $selectProvince[ "title" ] . " - " . $selectAddress[ "address" ] . " - " . $selectCity[ "title" ];
                $postCode = $selectAddress[ "postcode" ];
            }

            $selectCartItems = array_values( array_filter( $selectAllCartItems, function( $key ) use( $selectOrder ) {
                $cartItemIDs = explode( ",", $selectOrder[ "cart_items_ids" ] );
                return in_array( $key[ "ID" ], $cartItemIDs );
            } ) );
            if ( ! exists( $selectCartItems ) ) continue;

            $productList = array();
            foreach( $selectCartItems as $cartItem ) {
                $selectProduct = filterArrayUsingParam( $selectAllProducts, $cartItem, "ID", "product_id" );
                if ( ! exists( $selectProduct ) || ! exists( $selectProduct[ 0 ] ) ) continue;
                $selectProduct = $selectProduct[ 0 ];

                $productList[] = $selectProduct[ "title" ] . " * " . $cartItem[ "count" ];
            }

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
            );
        }

        return Alert::Success( 200, $dataToReturn );
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
