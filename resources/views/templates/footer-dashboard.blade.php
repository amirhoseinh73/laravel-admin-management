<footer class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <script>document.write(new Date().getFullYear())</script>
                © پلتفرم ویرا.
            </div>
            <div class="col-sm-6">
                <div class="text-sm-right d-none d-sm-block">

                </div>
            </div>
        </div>
    </div>
</footer>
</div>
<!-- end main content-->
</div>
<!-- END layout-wrapper -->

</div>
<!-- end container-fluid -->

<?php if ( ( isset( $discount_code ) && $discount_code ) || ( isset( $page_activation_code ) && $page_activation_code )  ) :?>
    <!-- JAVASCRIPT -->
    <script src="<?= url('assets/libs/jquery/jquery.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <script src="<?= url('assets/libs/bootstrap/js/bootstrap.bundle.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <script src="<?= url('assets/libs/metismenu/metisMenu.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <script src="<?= url('assets/libs/simplebar/simplebar.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <script src="<?= url('assets/libs/node-waves/waves.min.js?ver=' . env( "VERSION" ) ) ?>"></script>

    <!-- Required datatable js -->
    <script src="<?= url('assets/libs/datatables.net/js/jquery.dataTables.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <script src="<?= url('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <!-- Buttons examples -->
    <script src="<?= url('assets/libs/datatables.net-buttons/js/dataTables.buttons.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <script src="<?= url('assets/libs/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <script src="<?= url('assets/libs/jszip/jszip.min.js') ?>"></script>
    <!-- <script src="<?//= url('assets/libs/pdfmake/build/pdfmake.min.js') ?>"></script>
    <script src="<?//= url('assets/libs/pdfmake/build/vfs_fonts.js') ?>"></script> -->
    <script src="<?= url('assets/libs/datatables.net-buttons/js/buttons.html5.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <script src="<?= url('assets/libs/datatables.net-buttons/js/buttons.print.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <script src="<?= url('assets/libs/datatables.net-buttons/js/buttons.colVis.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <!-- Responsive examples -->
    <script src="<?= url('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <script src="<?= url('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <script src="<?=url().'/assets/libs/select2/js/select2.min.js'?>"></script>

    <!-- Datatable init js -->
    <!-- <script src="<?//= url('assets/js/pages/datatables.init.js') ?>"></script> -->

    <!-- App js -->
    <script src="<?= url('assets/js/app.js?ver=' . env( "VERSION" ) ) ?>"></script>

    <script src="<?=url().'/assets/js/libs/jquery.md.bootstrap.datetimepicker.js?ver=' . env( "VERSION" ) ?>"></script>
    
    <script src="<?= url('/assets/libs/sweetalert2/sweetalert2.min.js?ver=' . env( "VERSION" ) )?>"></script>
    <script src="<?= url('/inc/js/libs/jalaali.min.js?ver=' . env( "VERSION" ) )?>"></script>

    <script src="<?= url('/inc/js/config.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <script src="<?= url('/inc/js/helper.js?ver=' . env( "VERSION" ) ) ?>"></script>

    <?php if ( isset( $page_activation_code ) && $page_activation_code ) :?>
        <script src="<?=url().'/inc/js/activation-code.js?ver=' . env( "VERSION" ) ?>"></script>
    <?php else : ?>
        <script src="<?=url().'/inc/js/discount_code.js?ver=' . env( "VERSION" ) ?>"></script>
    <?php endif;?>

   
<?php else :?>
    <!-- JAVASCRIPT -->
    <script src="<?= url('/assets/libs/bootstrap/js/bootstrap.bundle.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <script src="<?= url('/assets/libs/metismenu/metisMenu.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <script src="<?= url('/assets/libs/simplebar/simplebar.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <script src="<?= url('/assets/libs/node-waves/waves.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <script src="<?= url('/assets/libs/sweetalert2/sweetalert2.min.js?ver=' . env( "VERSION" ) )?>"></script>

    <!-- apexcharts -->
    <?php if (isset($has_chart) && $has_chart): ?>
        <script src="<?= url('/assets/libs/apexcharts/apexcharts.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <?php endif; ?>

    <!-- jquery.vectormap map -->
    <script src="<?= url('/assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <script src="<?= url('/assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js?ver=' . env( "VERSION" ) ) ?>"></script>

    <script src="<?= url('/assets/js/pages/dashboard.init.js?ver=' . env( "VERSION" ) ) ?>"></script>

    <!-- Responsive Table js -->
    <script src="<?= url('/assets/libs/admin-resources/rwd-table/rwd-table.min.js?ver=' . env( "VERSION" ) ) ?>"></script>

    <!-- Init js -->
    <script src="<?= url('/assets/js/pages/table-responsive.init.js?ver=' . env( "VERSION" ) ) ?>"></script>

    <script src="<?= url('/assets/js/app.js?ver=' . env( "VERSION" ) ) ?>"></script>

    <script src="<?= url('/inc/js/ibv_vp_dashboard.js?ver=' . env( "VERSION" ) ) ?>"></script>

    <script src="<?= url('/inc/js/helper.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <?php if (isset( $manage_content_book ) && $manage_content_book): ?>
        <script src="<?= url('/inc/js/manage-content-book.js?ver=' . env( "VERSION" ) ) ?>"></script>
    <?php endif; ?>
<?php endif;?>

</body>


<!-- Mirrored from v3dboy.ir/previews/html/qovex/qovex/Vertical/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 11 Jan 2021 09:54:33 GMT -->
</html>