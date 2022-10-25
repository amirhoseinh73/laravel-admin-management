<?php

namespace App\Http\Controllers;

use App\Models\Book\ActivationCodeModel;
use App\Models\Book\BookModel;
use App\Models\Book\ContentModel;
use App\Models\CookieModel;
use App\Models\OfflineActivationCodeModel;
use App\Models\Shopping\DiscountCodeModel;
use App\Models\Shopping\ProductModel;
use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @return object `userInfo`
     * @property `ID` , `firstname`
     */
    public function userInfo( Request $request ) {
        //get token for api requests [GET,POST]
        $token = $request->all( "token" );
        $userInfo = CookieController::UserData( $token[ "token" ] );

        if ( ! exists( $userInfo ) ) return null;
 
		if ( file_exists( public_path( DIR_PROFILE_IMAGE . $userInfo->profile_image ) ) ) $userInfo->profile_image = url( DIR_PROFILE_IMAGE . $userInfo->profile_image );
        else $userInfo->profile_image = url( DIR_PROFILE_IMAGE . "default.png" );

        return $userInfo;
    }

	protected $callInsideFunctionControllers = false;

    //models
    protected function userModel() {
        return new UserModel();
    }

    protected function cookieModel() {
        return new CookieModel();
    }

    protected function productModel() {
        return new ProductModel();
    }

    protected function discountCodeModel() {
        return new DiscountCodeModel();
    }

    protected function bookModel() {
        return new BookModel();
    }

    protected function contentModel() {
        return new ContentModel();
    }

    protected function activationCodeModel() {
        return new ActivationCodeModel();
    }

    protected function offlineActivationCodeModel() {
        return new OfflineActivationCodeModel();
    }
}
