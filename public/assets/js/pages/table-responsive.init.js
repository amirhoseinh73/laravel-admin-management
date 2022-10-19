/*
Template Name: Qovex - Responsive Bootstrap 4 Admin Dashboard
Author: Themesbrand
Website: https://themesbrand.com/
Contact: themesbrand@gmail.com
File: table responsive 
*/

$(function() {
    $('.table-responsive.enable_focusable').responsiveTable({
		addFocusBtn: true,
		addDisplayAllBtn: 'btn btn-secondary',
		i18n: {
			focus: 'تمرکز',
			display: 'نمایش',
			displayAll: 'نمایش همه'
		}
    });

	$('.table-responsive.disable_focusable').responsiveTable({
		addFocusBtn: false
	});
});