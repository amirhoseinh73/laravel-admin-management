@include('templates.header.dashboard-header-top')
@include('templates.page.discount-code-header')
@include('templates.header.dashboard-header-bottom')
<!-- ============================================================== -->

        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title mb-3">اضافه سازی</h4>
                        <form method="POST" id="form_add_code">
                            <div class="row">
                                <div class="col-6 col-lg-3">
                                    <label for="product_list" class="col-form-label">
                                        نوع محصول *
                                    </label>
                                    <select class="form-control" id="product_list">
                                        @if( isset( $product_list ) )
                                            @foreach( $product_list as $product )
                                                <option value="{{ $product->ID }}">{{ $product->title }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-3">
                                    <label for="count" class="col-form-label">
                                        تعداد *
                                    </label>
                                    <input type="text" class="form-control text-center" id="count" value="1">
                                </div>
                                <div class="col-3 col-sm-6 mx-auto">
                                    <label for="count" class="invisible col-form-label">
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
                            لیست کد ها
                        </h4>
                        <div class="disable_focusable">
                            <table id="datatable-buttons" class="table table-bordered table-responsive-sm nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>کد</th>
                                        <th>نام محصول</th>
                                        <th>تاریخ ایجاد</th>
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

<script src="{{ url('/inc/js/activation-code.js?ver=' . env( "VERSION" )) }}"></script>

@include('templates.footer.dashboard-footer-bottom')