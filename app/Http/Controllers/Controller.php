<?php

namespace App\Http\Controllers;

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
}
