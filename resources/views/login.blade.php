@php
use App\Helpers\PersianText;
@endphp
@include( "templates.header.header" )
<div class="account-pages my-0 pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-6 col-xl-5">
                <div class="alert alert-danger alert_wrong all" style="display: none"></div>
                <div class="alert alert-success alert_success all" style="display: none"></div>
                @if( isset( $error ) )
                    {{ $error = json_decode( $error, true ) }}
                @endif
                @if( isset( $error ) && intval( $error[ 'type' ] ) === 3 )
                    <div class="alert alert-info alert_info all">{{ $error[ 'message' ] }}</div>
                @endif
            </div>
        </div>
        <form id="login_submit">
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
                                <label for="login_username">
                                    {{ PersianText::WORD[ "username" ] }}
                                </label>
                                <input type="text" class="form-control" id="login_username"
                                       placeholder="{{ PersianText::WORD[ "username" ] }}">
                            </div>

                            <div class="form-group position-relative">
                                <label for="login_password">
                                    {{ PersianText::WORD[ "password" ] }}
                                </label>
                                <input type="password" class="form-control" id="login_password"
                                       placeholder="{{ PersianText::WORD[ "password" ] }}">
                                <button type="button" class="btn btn-transparent fas fa-eye btn-view-password"></button>
                            </div>

                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="remember">
                                <label class="custom-control-label" for="remember">
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
@include( "templates.footer.footer" )