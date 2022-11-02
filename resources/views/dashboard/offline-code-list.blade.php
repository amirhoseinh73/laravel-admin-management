@include('templates.header.dashboard-header-top')
@include('templates.page.discount-code-header')
@include('templates.header.dashboard-header-bottom')
<!-- ============================================================== -->
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3" id="title_list_box">لیست کدهای آفلاین</h4>
                <div class="disable_focusable">
                    <table id="offline_code_management_table" class="table table-bordered table-responsive nowrap row-border hover order-column" data-page-length="25">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>پایه</th>
                                <th>کد روی جعبه DVD</th>
                                <th>آخرین کد کاربر</th>
                                <th>آخرین کد فعالسازی محصول</th>
                                <th>تعداد استفاده شده</th>
                                <th>تعداد فرصت های باقی مانده</th>
                                <th>اطلاعات استفاده کننده</th>
                                <th>آیا کد برای سایت فروش است؟</th>
                                <th>مشخصات خریدار</th>
                                <th>آیا غیر فعال شده است؟</th>
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

<script src="{{ url('/inc/js/offline-code-management.js?ver=' . env( "VERSION" )) }}"></script>

@include('templates.footer.dashboard-footer-bottom')