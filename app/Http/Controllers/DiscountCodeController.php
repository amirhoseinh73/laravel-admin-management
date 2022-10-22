<?php

namespace App\Http\Controllers;

use App\Helpers\Alert;
use App\Helpers\PersianText;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DiscountCodeController extends Controller
{
    public function index ( Request $request ) {
        $data = array (
            'head_title'    => PersianText::WORD[ "discount_code" ],
            'description'   => PersianText::WORD[ "discount_code_management" ],
            'user_data'     => $this->userInfo( $request ),
            'discount_code' => true
        );
        return view( 'dashboard.discount-code', $data );
    }

    public function create( Request $request ) {
        $type_code   = $request->post('type_code');
        $limit       = $request->post('limit');
        $mobile      = $request->post('mobile');
        $expired_at  = $request->post('expired_at');
        $percent     = $request->post('percent');
        $percent_num = $request->post('percent_num');
        $count_code  = $request->post('count_code');

        if ( ! exists( $mobile ) ) $mobile = null;

        if ( ! exists( $type_code ) || ! exists( $limit ) || !exists( $percent ) ||
             ! exists( $percent_num ) || ! exists( $count_code ) || $percent_num !== $percent || ! exists( $expired_at ) )
             return Alert::Error( "wrong_inputs" );

        $i = 0;
        $data = array();
        $data_return = array();
        $discount_code_mdl = $this->discountCodeModel();

        $expired_at = explode( ' ', $expired_at );
        $expire_jalali = $expired_at[0];
        $expire_date = explode('/',$expire_jalali);
        $expire_time = $expired_at[(count($expired_at) - 1)];
        
        $expire_gregorian = jalali_to_gregorian($expire_date[0], $expire_date[1], $expire_date[2],'-');

        $file_name = 'excel-discount-codes-' . time() . '.csv';
        $excel = fopen( public_path( 'excel/' . $file_name ) ,'w' );
        fwrite($excel,pack('CCC',0xef,0xbb,0xbf));
        fwrite($excel , implode(',', array(
            'کد',
            'درصد تخفیف',
            'تعداد قابل استفاده',
            'تاریخ انقضا',
            'موبایل',
            'تاریخ ایجاد',
        )) . '
        ');
        while ($i < intval($count_code)){
            $i++;
            do {
                $code = randomVerificationCode( 7, false );
                $sel_exists_code = $discount_code_mdl->selectCodeByCode( $code );
            } while( exists( $sel_exists_code ) );
            
            array_push(
                $data,
                array(
                    'discount_code'    => $code,
                    'percent' => $percent,
                    'limit_usage'   => $limit,
                    'status'    => true,
                    'mobile' => $mobile,
                    'expired_at'  => $expire_gregorian . ' ' . $expire_time,
                )
            );

            $data_return = array(
                $code,
                $percent,
                $limit,
                $expire_jalali . ' ' . $expire_time,
                $mobile,
                jdate('Y/m/d H:i:s')
            );
            fwrite($excel, implode(',', $data_return) . '
            ');
        }
        fclose($excel);
        try {
            $result = $discount_code_mdl->insert($data);
            if ( ! exists( $result ) ) return Alert::Error( "failed" );

            return Alert::Success( 200, url( '/excel/' . $file_name ) );
        } catch ( Exception $e ) {
            return Alert::Error( $e->getMessage() );
        }
    }

    public function load () {
        return $this->discountCodeModel()->all()->toJson();
    }

    public function remove( Request $request ){
        $id = $request->post('id');
        if ( ! exists( $id ) ) return Alert::Error( "wrong_inputs" );

        $discount_code_mdl = $this->discountCodeModel();
        $sel_dc = $discount_code_mdl->selectCodeByID( $id );
        if ( ! exists( $sel_dc ) ) return Alert::Error( "wrong_inputs" );

        if ( ! exists( $sel_dc ) || ! exists( $sel_dc->ID ) ) return Alert::Error( -1 );

        try {

            $result = $discount_code_mdl->deleteCodeByID( $sel_dc->ID );
            if ( ! exists( $result ) ) throw new Exception( "failed" );
            return Alert::Success( 200 );
        } catch ( Exception $e) {
            return Alert::Error( $e->getMessage() );
        }
    }
}
