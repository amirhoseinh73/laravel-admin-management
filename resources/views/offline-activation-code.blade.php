@include('templates.header.offline-header')
<div class="fix_loading"></div>
<main class="login-fixed" id="login_form_box">
    <div class="row justify-content-center align-content-center align-items-center h-100">
        <section class="col-12 col-sm-11 col-md-10 h-100">

            <div class="login-logo">
                <a href="{{ env( "URL_BOOK" ) }}">
                    <img src="{{ url( '/inc/img/logo.png' ) }}" alt="">
                </a>
            </div>

            <!-- login -->
            <form id="activation_code_form_page" method="post" class="w-100" autocomplete="off">
                <div class="row align-items-center mb-3">
                    <section class="col">
                        <input id="code" type="text" name="code" autocomplete="off"
                            class="custom-input color-text login-inputs pl-3"
                            placeholder="کد فعالسازی 21 رقمی را وارد کنید" inputmode="numeric"/>
                    </section>
                    <section class="col-auto px-0">
                        <label for="code" class="login-icon mb-0">
                            <i class="fas fa-key"></i>
                        </label>
                    </section>
                </div>
                <div class="row align-items-center mb-3">
                    <section class="col">
                        <input id="mobile" type="text" name="mobile" autocomplete="off"
                            class="custom-input color-text login-inputs pl-3"
                            placeholder="شماره همراه خود را وارد کنید" inputmode="numeric"/>
                    </section>
                    <section class="col-auto px-0">
                        <label for="mobile" class="login-icon mb-0">
                            <i class="fas fa-mobile"></i>
                        </label>
                    </section>
                </div>
                <div class="row align-items-center mb-3">
                    <section class="col">
                        <input id="captchaAnswer" type="text" name="captchaAnswer" autocomplete="off"
                            class="custom-input color-text login-inputs pl-3"
                            placeholder="پاسخ را بنویسید" inputmode="numeric"/>
                    </section>
                    <section id="captchaText" class="col-auto dir-ltr">
                        {{-- {{ $captchaText }} --}}
                    </section>
                    <section class="col-auto px-0">
                        <label for="captchaAnswer" class="login-icon mb-0">
                            <i class="fas fa-user"></i>
                        </label>
                    </section>
                </div>
                <div id="show_alert_message" class="row align-items-center mb-3 d-none">
                    
                </div>
                <div class="row align-items-center justify-content-center flex-column">
                    <section class="col-10 col-sm-6 px-0">
                        <button type="submit" class="custom-button green btn-block login-button">ثبت</button>
                    </section>
                </div>
            </form>
            <!-- /login -->

        </section>
    </div>
</main>
@include('templates.footer.offline-footer')