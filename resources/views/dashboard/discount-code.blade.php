@include('templates.header.dashboard-header-top')
@include('templates.page.discount-code-header')
@include('templates.header.dashboard-header-bottom')
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-0 font-size-18">{{ $head_title }}</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active">{{ $description }}</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>
        <!-- end page title -->

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">اضافه سازی</h4>
                        <form method="POST" id="form_add_code">
                            <div class="row">
                                <div class="col-6 col-lg-3">
                                    <label for="type_code" class="col-form-label">
                                        نوع کد *
                                    </label>
                                    <select class="form-control" id="type_code">
                                        <option value='1'>بدون محدودیت تعداد</option>
                                        <option value='2'>چندبار مصرف</option>
                                    </select>
                                </div>
                                <div class="col-6 col-sm d-none">
                                    <label for="limit" class="col-form-label">
                                        تعداد قابل استفاده *
                                    </label>
                                    <input type="text" class="form-control text-center" id="limit" value="1"/>
                                </div>
                                <div class="col-12 col-sm-3">
                                    <label for="system" class="col-form-label">
                                        شماره موبایل
                                    </label>
                                    <input type="text" class="form-control text-center" id="mobile" value=""/>
                                </div>
                                <div class="col-12 col-sm-3">
                                    <label for="expire" class="col-form-label">
                                        تاریخ انقضا
                                    </label>
                                    <input type="text" class="form-control text-center" id="expire"/>
                                </div>
                            </div>
                            <div class="row my-5">
                                <div class="col row">
                                    <label for="percent" class="col-6">
                                        درصد تخفیف *
                                    </label>
                                    <div class="col-5 col-sm-4 col-lg-3 col-xl-2 text-right ml-auto">
                                        <input id="percent_num" type="text" class="w-100 text-center form-control" value="50"/>
                                    </div>
                                    <input type="range" id="percent" min="0" max="100" step="1" placeholder="درصد" class="mt-3 custom-range col-12" style="direction: ltr;">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-4 mt-3">
                                    <label for="count_code" class="col-form-label">
                                        تعداد *
                                    </label>
                                    <input type="text" class="form-control text-center" id="count_code" value="1">
                                </div>
                                <div class="col-8 col-sm-6 mt-3 mx-auto">
                                    <label for="count_code" class="invisible col-form-label">
                                        تعداد
                                    </label>
                                    <button class="btn btn-outline-primary btn-block" id="submit" type="submit">
                                        ایجاد
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3" id="title_list_box">
                            لیست کد تخفیف ها
                        </h4>
                        <div class="disable_focusable">
                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>کد</th>
                                        <th>درصد تخفیف</th>
                                        <th>تعداد قابل استفاده</th>
                                        <th>تعداد دفعات استفاده شده</th>
                                        <th>عملیات</th>
                                        <th>تاریخ انقضا</th>
                                        <th>تاریخ ایجاد</th>
                                        <th>آخرین تاریخ استفاده شده</th>
                                        <th>موبایل</th>
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

    </div>
    <!-- End Page-content -->

@include('templates.footer.dashboard-footer-top')
@include('templates.page.discount-code-footer')

<script src="{{ url('/inc/js/discount_code.js?ver=' . env( "VERSION" )) }}"></script>

@include('templates.footer.dashboard-footer-bottom')