@include('templates.header.dashboard-header-top')
@include('templates.page.discount-code-header')
@include('templates.header.dashboard-header-bottom')
<!-- ============================================================== -->
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3">اضافه سازی</h4>
                <form method="POST" id="form_register_user">
                    <div class="row">
                        <div class="col-6 col-sm-4">
                            <label for="firstname" class="col-form-label">
                                نام *
                            </label>
                            <input type="text" class="form-control text-center" id="firstname" value=""/>
                        </div>
                        <div class="col-6 col-sm-4">
                            <label for="lastname" class="col-form-label">
                                نام خانوادگی *
                            </label>
                            <input type="text" class="form-control text-center" id="lastname" value=""/>
                        </div>
                        <div class="col-6 col-sm-4">
                            <label for="username" class="col-form-label">
                                کد ملی *
                            </label>
                            <input type="text" class="form-control text-center" id="username" value=""/>
                        </div>
                        <div class="col-6 col-sm-4">
                            <label for="mobile" class="col-form-label">
                                موبایل *
                            </label>
                            <input type="text" class="form-control text-center" id="mobile" value=""/>
                        </div>
                        <div class="col-6 col-sm-4">
                            <label for="password" class="col-form-label">
                                رمز عبور *
                            </label>
                            <input type="text" class="form-control text-center" id="password" value=""/>
                        </div>
                        <div class="col-6 col-sm-4">
                            <label for="gender" class="col-form-label">
                                جنسیت *
                            </label>
                            <select class="form-control" id="gender">
                                <option value='1'>آقا</option>
                                <option value='2'>خانم</option>
                            </select>
                        </div>
                        <div class="col-6 col-sm-4">
                            <label for="grade" class="col-form-label">
                                پایه *
                            </label>
                            <select class="form-control" id="grade" multiple>
                                <option value='1'>اول</option>
                                <option value='2'>دوم</option>
                                <option value='3'>سوم</option>
                                <option value='4'>چهارم</option>
                                <option value='5'>پنجم</option>
                                <option value='6'>ششم</option>
                            </select>
                        </div>

                        <div class="col-6 col-sm-4 mt-auto">
                            <input type="checkbox" id="is_send_sms"/>
                            <label for="is_send_sms" class="col-form-label">
                                آیا پیامک ارسال شود؟
                            </label>
                            <hr class="my-0"/>
                            <label for="expired_at" class="col-form-label">
                                مهلت استفاده *
                            </label>
                            <input type="text" class="form-control text-center" id="expired_at" value="1402/07/01 00:00:00"/>
                        </div>

                        <div class="col-12 col-sm-4 mt-auto">
                            <button type="submit" class="btn btn-primary btn-block">ثبت نام</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end row -->

@include('templates.footer.dashboard-footer-top')
@include('templates.page.discount-code-footer')

<script src="{{ url('/inc/js/user-register.js?ver=' . env( "VERSION" )) }}"></script>

@include('templates.footer.dashboard-footer-bottom')