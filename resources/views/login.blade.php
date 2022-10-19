@php
use App\Helpers\PersianText; 
@endphp
<div class="account-pages my-0 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="alert alert-danger ibv_vp_alert_wrong ibv_vp_all" style="display: none"></div>
                <div class="alert alert-success ibv_vp_alert_success ibv_vp_all" style="display: none"></div>
                @if( isset( $error ) )
                    {{ $error = json_decode( $error, true ) }}
                @endif
                @if( isset( $error ) && intval( $error[ 'type' ] ) === 3 )
                    <div class="alert alert-info ibv_vp_alert_info ibv_vp_all">{{ $error[ 'message' ] }}</div>
                @endif
            </div>
        </div>
        <form id="ibv_vp_login_submit">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="card overflow-hidden">
                    <div class="bg-login text-center">
                        <div class="bg-login-overlay"></div>
                        <div class="position-relative">
                            <h5 class="text-white font-size-20">
                                {{ (isset($title) ? $title : '') }}
                            </h5>
                            <p class="text-white-50 mb-0">{{ ( isset( $description ) ? $description : '' ) }}</p>
                            <a href="{{ url('/') }}" class="logo logo-admin mt-4">
                                <img src="{{ url('/assets/images/logo-sm-dark.png') }}" alt="" height="30">
                            </a>
                        </div>
                    </div>
                    <div class="card-body pt-5">
                        <div class="p-2">
                            <div class="form-group">
                                <label for="ibv_vp_login_username">
                                    {{ PersianText::WORD[ "username" ] }}
                                </label>
                                <input type="text" class="form-control" id="ibv_vp_login_username"
                                       placeholder="{{ PersianText::WORD[ "username" ] }}">
                            </div>

                            <div class="form-group">
                                <label for="ibv_vp_login_password">
                                    {{ PersianText::WORD[ "password" ] }}
                                </label>
                                <input type="password" class="form-control" id="ibv_vp_login_password"
                                       placeholder="{{ PersianText::WORD[ "password" ] }}">
                            </div>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="ibv_vp_remember">
                                <label class="custom-control-label" for="ibv_vp_remember">
                                    {{ PersianText::WORD[ "remember_me" ] }}
                                </label>
                            </div>

                            <div class="mt-3">
                                <button class="btn btn-primary btn-block waves-effect waves-light" type="submit">
                                    {{ PersianText::WORD[ "login" ] }}
                                </button>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="mt-4 text-center">
                    <p><i class="mdi mdi-copyright text-muted px-1"></i>
                        {{ PersianText::WORD[ "copyright" ] }}
                    </p>
                </div>

            </div>
        </div>
        </form>
    </div>
</div>