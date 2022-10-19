@extends('templates.header-dashboard')

@section('submenu')
    @parent

    <ul class="metismenu list-unstyled" id="side-menu">
        <li class="menu-title">منو</li>
        <li>
            <a href="{{ url('dashboard') }}" class="waves-effect">
                <i class="mdi mdi-airplay"></i>
                <span>داشبورد</span>
            </a>
        </li>
        @if ( isset( $user_data ) && !!$user_data->is_admin )
            <li>
                <a href="{{ url('dashboard/discount-code') }}" class="waves-effect">
                    <i class="bx bxs-discount"></i>
                    <span>کد های تخفیف</span>
                </a>
            </li>

            <li>
                <a href="{{ url( "dashboard/manage-book-content" ) }}" class="waves-effect">
                    <i class="fa fa-images"></i>
                    <span>مدیریت محتوا</span>
                </a>
            </li>

            <li>
                <a href="{{ url( "dashboard/generate-activation-code" ) }}" class="waves-effect">
                    <i class="fa fa-barcode"></i>
                    <span>کدهای فعال سازی</span>
                </a>
            </li>
        @endif
        <li>
            <a href="{{ url( "/logout" ) }}" class="waves-effect">
                <i class="fa fa-power-off text-danger"></i>
                <span>خروج</span>
            </a>
        </li>
    </ul>
@endsection