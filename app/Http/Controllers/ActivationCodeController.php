<?php

namespace App\Http\Controllers;

use App\Helpers\Alert;
use Exception;
use Illuminate\Http\Request;

class ActivationCodeController extends Controller
{
    private string $resource = "admin book";

    public function index( Request $request ) {
        $productController = new ProductController();
        $productController->callInsideFunction = true;

        $dataForPage = array(
            "title" => env( "SITE_NAME" ),
            "description" => "",
            "product_list" => $productController->list(),
            'user_data'     => $this->userInfo( $request ),
        );
        
        return view( 'dashboard.activation-code', $dataForPage );
    }
    
    public function generate( Request $request ) {
        $activationCodeModel = $this->activationCodeModel();

        $count = intval( $request->post( "count" ) );
        $productID = $request->post( "product_id" );

        if ( ! exists( $count ) || ! exists( $productID ) ) return Alert::Error( "wrong_inputs" );
        
        $dataToInsert = array();
        for( $i = 0; $i < $count; $i++ ) {
            $activationCode = $this->generateActivationCode();

            $dataToInsert[] = array(
                "code" => $activationCode,
                "status" => true,
    
                "product_id" => $productID,
                "resource" => $this->resource,
                "order_id" => 0
            );
        }

        try {
            $result = $activationCodeModel->insert( $dataToInsert );

            if ( ! $result ) throw new Exception( "failed" );

            $selectActivationCodes = $activationCodeModel->selectWithResource( $this->resource );

            return Alert::Success( 200, $selectActivationCodes );
        } catch( Exception $e ) {
            logFile( $e );
            return Alert::Error( $e->getMessage() );
        }
    }

    private function generateActivationCode() {
        $activationCodeModel = $this->activationCodeModel();

        do {
            $activationCode = randomVerificationCode( 10, false );
            $checkDuplicateCode = $activationCodeModel->selectCodeByCode( $activationCode );
        } while( exists( $checkDuplicateCode ) );

        return $activationCode;
    }

    public function list() {
        $activationCodeModel = $this->activationCodeModel();

        $productController = new ProductController();
        $productController->callInsideFunction = true;
        $selectProducts = $productController->list();

        $selectCodesMadeBySchoolAdmin = $activationCodeModel->selectWithResource( $this->resource );

        foreach( $selectCodesMadeBySchoolAdmin as $code ) {
            $product = array_values( array_filter( $selectProducts, function( $key ) use( $code ) {
                return $key->ID === $code->product_id;
            } ) )[ 0 ];
            if ( ! exists( $product ) ) continue;

            $code->title = $product->title;
        }

        return Alert::Success( 200, $selectCodesMadeBySchoolAdmin );
    }
}
