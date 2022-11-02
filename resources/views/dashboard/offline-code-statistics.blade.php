@include('templates.header.dashboard-header-top')
@include('templates.header.dashboard-header-bottom')
<!-- ============================================================== -->
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title mb-3" id="title_list_box">آمار کدهای آفلاین</h4>
                <div class="disable_focusable">
                    @if ( exists( $statistics ) )
                    <ul class="list">
                        <li>
                            <strong>تعداد کدهای آفلاین</strong>
                            ============================>
                            <strong style="font-size: 2rem">{{ $statistics[ "countAll" ] }}</strong>
                        </li>
                        <li>
                            <strong>تعداد کدهای آفلاین فعال شده</strong>
                            ====================>
                            <strong style="font-size: 2rem">{{ $statistics[ "countAllActivated" ] }}</strong>

                            <br/>
                            <i class="d-block" style="margin-right: 15rem">تعداد کدهای آفلاین فعال شده بر اساس پایه</i>
                            <ul style="margin-right: 15rem">
                                <li>
                                    <strong>اول</strong>
                                    ====================>
                                    <strong style="font-size: 1.5rem">{{ $statistics[ "countAllActivatedGrade1" ] }}</strong>
                                </li>
                                <li>
                                    <strong>دوم</strong>
                                    ====================>
                                    <strong style="font-size: 1.5rem">{{ $statistics[ "countAllActivatedGrade2" ] }}</strong>
                                </li>
                                <li>
                                    <strong>سوم</strong>
                                    ====================>
                                    <strong style="font-size: 1.5rem">{{ $statistics[ "countAllActivatedGrade3" ] }}</strong>
                                </li>
                                <li>
                                    <strong>چهارم</strong>
                                    ====================>
                                    <strong style="font-size: 1.5rem">{{ $statistics[ "countAllActivatedGrade4" ] }}</strong>
                                </li>
                                <li>
                                    <strong>پنجم</strong>
                                    ====================>
                                    <strong style="font-size: 1.5rem">{{ $statistics[ "countAllActivatedGrade5" ] }}</strong>
                                </li>
                                <li>
                                    <strong>ششم</strong>
                                    ====================>
                                    <strong style="font-size: 1.5rem">{{ $statistics[ "countAllActivatedGrade6" ] }}</strong>
                                </li>
                            </ul>
                        </li>
                        <li>
                            <strong>تعداد کدهای آفلاین حذف شده</strong>
                            ====================>
                            <strong style="font-size: 2rem">{{ $statistics[ "countAllDeactivate" ] }}</strong>
                        </li>
                        <li>
                            <strong>تعداد کدهای آفلاین در سایت فروش</strong>
                            ================>
                            <strong style="font-size: 2rem">{{ $statistics[ "countAllIsForShoppingSite" ] }}</strong>
                        </li>
                        <li>
                            <strong>تعداد کدهای آفلاین فروخته شده در سایت فروش</strong>
                            ======>
                            <strong style="font-size: 2rem">{{ $statistics[ "countAllIsForShoppingSiteSold" ] }}</strong>
                        </li>
                    </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>        
<!-- end row -->

@include('templates.footer.dashboard-footer-top')
@include('templates.footer.dashboard-footer-bottom')