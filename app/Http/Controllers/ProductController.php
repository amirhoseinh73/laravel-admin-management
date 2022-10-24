<?php

namespace App\Http\Controllers;

use App\Helpers\Alert;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function list() {
        $selectAllProducts = $this->productModel()->all();
        if ( $this->callInsideFunction ) return json_decode( $selectAllProducts->toJson() );
        
        return Alert::Success( 200, $selectAllProducts );
    }
}