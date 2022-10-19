<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">

        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-flex align-items-center justify-content-between">
                    <h4 class="page-title mb-0 font-size-18"><?=$head_title?></h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item active"><?=$description?></li>
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
                                    <label for="product_list" class="col-form-label">
                                        نوع محصول *
                                    </label>
                                    <select class="form-control" id="product_list">
                                        <?php
                                            if( isset($product_list) ) {
                                                foreach( $product_list as $product ) {
                                                    echo "<option value='$product->ID'>$product->title</option>";
                                                }
                                            }
                                        ?>
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
                            <table id="datatable-buttons" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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