@include('templates.header.dashboard-header-top')
@include('templates.page.discount-code-header')
@include('templates.header.dashboard-header-bottom')
<!-- ============================================================== -->
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3" id="title_list_box">لیست کاربران</h4>
                <div class="disable_focusable">
                    <table id="user_management_table" class="table table-bordered table-responsive nowrap row-border hover order-column" data-page-length="25">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th data-class-name="priority">نام</th>
                                <th>نام خانوادگی</th>
                                <th>کد ملی</th>
                                <th>موبایل</th>
                                <th>پایه</th>
                                <th>جنسیت</th>
                                <th>
                                    وضعیت
                                    <br/>
                                    <abbr class="badge badge-success">1 (فعال)</abbr>
                                    <abbr class="badge badge-danger">2 (غیر فعال)</abbr>
                                    <abbr class="badge badge-warning">3 (مسدود شده)</abbr>
                                </th>
                                <th>تاریخ ثبت نام</th>
                                <th>مهلت استفاده</th>
                                <th>تاریخ آخرین ورود به سامانه</th>
                                <th>تاریخ آخرین تغییر رمز عبور</th>
                                <th>عملیات</th>
                            </tr>
                        </thead>

                        <tbody>
                            
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>        
<!-- end row -->

@include('templates.footer.dashboard-footer-top')
@include('templates.page.discount-code-footer')

@if ( exists( $is_user_registered_by_admin ) && $is_user_registered_by_admin )
    <script type="text/javascript">
        const is_user_registered_by_admin = true
    </script>
@endif
<script type="text/javascript" src="{{ url('/inc/js/user-management.js?ver=' . env( "VERSION" )) }}"></script>

@include('templates.footer.dashboard-footer-bottom')