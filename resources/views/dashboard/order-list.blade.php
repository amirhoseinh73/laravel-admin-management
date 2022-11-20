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
                    <table id="shopping_list_orders" class="table table-bordered table-responsive nowrap row-border hover order-column" data-page-length="25">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>نام</th>
                                <th>نام خانوادگی</th>
                                <th>کد ملی</th>
                                <th>موبایل</th>
                                <th>مبلغ سفارش</th>
                                <th>مبلغ پرداخت شده</th>
                                <th>شماره سفارش</th>
                                <th>محصولات خریداری شده</th>
                                <th>آدرس</th>
                                <th>کد پستی</th>
                                <th>کد رهگیری پرداخت</th>
                                <th>تاریخ پرداخت</th>
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

<script type="text/javascript" src="{{ url('/inc/js/shopping-management.js?ver=' . env( "VERSION" )) }}"></script>

@include('templates.footer.dashboard-footer-bottom')