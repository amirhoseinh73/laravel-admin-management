@include('templates.header.dashboard-header-top')
@include('templates.page.manage-contents-header')
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
                        <h4 class="card-title mb-3">مدیریت محتوا</h4>
                        <div class="row">
                            <div class="col-6 col-lg-3">
                                <label for="list_grade" class="col-form-label">انتخاب پایه</label>
                                <select class="form-control" id="list_grade"></select>
                            </div>
                            <div class="col-6 col-lg-3">
                                <label for="list_book" class="col-form-label">انتخاب کتاب</label>
                                <select class="form-control" id="list_book"></select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3" id="title_list_box">لیست محتواها</h4>
                        <div class="disable_focusable">
                            <table id="manage_content_table" class="table table-bordered table-responsive nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>نوع محتوا</th>
                                        <th>نام کتاب</th>
                                        <th>شماره صفحه</th>
                                        <th>عنوان</th>
                                        <th>توضیحات</th>
                                        <th>منتشر کننده</th>
                                        <th>عرض</th>
                                        <th>ارتفاع</th>
                                        <th>وضعیت
                                            <br/>
                                            <abbr class="badge badge-danger">0</abbr>
                                            <abbr class="badge badge-success">1</abbr>
                                            <abbr class="badge badge-primary">2</abbr>
                                        </th>
                                        <th>اجرا</th>
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

    </div>
    <!-- End Page-content -->

@include('templates.footer.dashboard-footer-top')
@include('templates.page.manage-contents-footer')
@include('templates.footer.dashboard-footer-bottom')