$(document).ready(function() {
    loadData();

    // $('select').select2();
    type_code();
    expire_time();
    range_percent();
    submit_code();
});


function expire_time() {
    $('#expire').MdPersianDateTimePicker({
        targetTextSelector: '#expire',
        placement: 'bottom',
        englishNumber: true,
        disabled: false,
        selectedDate: undefined, //new Date('2018/9/30'),
        disableBeforeToday: false,
        disableAfterToday: false,
        modalMode: false,
        yearOffset: 0,
        enableTimePicker: true,
    }).on('show.bs.popover', function() {

    }).on('hide.bs.popover', function() {

    }).on('change', function() {

    }).on('click', function(e) {
        e.stopPropagation();
    });
}

function type_code() {
    const limit = $('#limit');
    // const count = $('#count_code');

    $('#type_code').off('change').on('change', function() {
        const value = $(this).val();
        if (value == 2) {
            limit.parent().removeClass('d-none');
            // count.parent().removeClass('d-none');
        } else {
            limit.parent().addClass('d-none');
            // count.parent().addClass('d-none');
        }
    });

    if ($('#type_code').val() == 2) {
        limit.parent().removeClass('d-none');
        // count.parent().removeClass('d-none');
    }
}

function range_percent() {
    $('#percent').off('input').on('input', function() {
        const percent_num = $('#percent_num');
        const value = $(this).val();
        percent_num.val(value);
    });

    $('#percent_num').off('keydown').on('keydown', function(event) {
        const percent = $('#percent');
        let value = $(this).val();
        const which = event.which;

        switch (which) {
            case 38://arrow up
            case 39://arrow right
                value++;
                if (value > 100) value = 100;
                break;
            case 37://arrow left
            case 40://arrow down
                value--;
                if (value < 0) value = 0;
                break;
            case 116:
                //f5
                window.location.reload();
            default:
                event.preventDefault();
                console.log(which);
                return;
        }
        $(this).val(value);
        percent.val(value);
    });

    $('#percent_num').val($('#percent').val());
}

function submit_code() {
    $('#form_add_code').off('submit').on('submit', function (e) {
        e.preventDefault();
        const type_code   = parseInt($('#type_code').val());
        let limit         = parseInt($('#limit').val());
        const mobile      = $('#mobile').val();
        const expire      = $('#expire').val();
        const percent     = parseInt($('#percent').val());
        const percent_num = parseInt($('#percent_num').val());
        const count_code  = parseInt($('#count_code').val());

        if (percent !== percent_num) {
            Swal.fire({
                title: 'خطا!',
                text: 'اطلاعات خود را بررسی کنید، سپس دوباره امتحان کنید.',
                type: 'error',
                showCancelButton: false,
                allowOutsideClick: false,
                allowEscapeKey: false,
                confirmButtonText: 'متوجه شدم',
            });
        }
        if (type_code === 1) {
            limit = -1;
        }

        $.ajax({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            url: Routes.discountCodeCreate,
            method: 'POST',
            data: {
                type_code: type_code,
                limit: limit,
                mobile: mobile,
                expired_at: expire,
                percent: percent,
                percent_num: percent_num,
                count_code: count_code,
            },
            dataType: 'json',
            beforeSend: () => {
                $('#submit').attr('disabled','disabled');
            },
            success: (respond) => {
                if (respond.status === 'success') {
                    Swal.fire({
                        title: 'عملیات با موفقیت انجام شد.',
                        type: 'success',
                        showCancelButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonText: 'متوجه شدم',
                    }).then((resp) => {
                        if (resp.value) {
                            window.open(respond.data);
                            $("#datatable-buttons").dataTable().fnDestroy();
                            loadData();
                        }
                    });
                } else {
                    Swal.fire({
                        title: 'خطا!',
                        text: 'اطلاعات خود را بررسی کنید، سپس دوباره امتحان کنید.',
                        type: 'error',
                        showCancelButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        confirmButtonText: 'متوجه شدم',
                    });
                }
            },
            error: () => {
                Swal.fire({
                    title: 'خطا! متاسفانه ارتباط با سرور برقرار نشد.',
                    description: 'لطفا دوباره امتحان کنید.',
                    type: 'error',
                    showCancelButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    confirmButtonText: 'متوجه شدم',
                });
            },
            complete: () => {
                $('#submit').removeAttr('disabled');
            }
        });
    });
}

function loadData() {
    $('#datatable-buttons tbody').html('');
    $.ajax({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        url: Routes.discountCodeLoad,
        method: 'POST',
        dataType: 'json',
        success: (respond) => {
            respond.forEach((object,index) => {
                let expire     = object.expired_at.split(' ');
                let on_created = object.created_at.split(' ');
                let on_updated = object.updated_at.split(' ');

                let expire_date     = expire[0].split('-');
                let expire_time     = expire.reverse()[0];
                expire_date         = jalaali.toJalaali(+expire_date[0],+expire_date[1],+expire_date[2]);

                let on_created_date = on_created[0].split('-');
                let on_created_time = on_created.reverse()[0];
                on_created_date     = jalaali.toJalaali(+on_created_date[0],+on_created_date[1],+on_created_date[2]);

                let on_updated_date = on_updated[0].split('-');
                let on_updated_time = on_updated.reverse()[0];
                on_updated_date     = jalaali.toJalaali(+on_updated_date[0],+on_updated_date[1],+on_updated_date[2]);

                $('#datatable-buttons tbody').append(`
                <tr id="${object.ID}">
                    <td>${index + 1}</td>
                    <td>${object.discount_code}</td>
                    <td>${object.percent}</td>
                    <td>${(object.limit_usage == -1 ? 'بی نهایت' : object.limit_usage)}</td>
                    <td>${object.used_number}</td>
                    <td><button type="button" class="btn btn-danger btn-remove-dc">حذف</button></td>
                    <td>${expire_date.jy + '/' + expire_date.jm + '/' + expire_date.jd + ' ' + expire_time}</td>
                    <td>${on_created_date.jy + '/' + on_created_date.jm + '/' + on_created_date.jd + ' ' + on_created_time}</td>
                    <td>${on_updated_date.jy + '/' + on_updated_date.jm + '/' + on_updated_date.jd + ' ' + on_updated_time}</td>
                    <td>${object.mobile}</td>
                </tr>
                `);
            });
            remove_discount_code();
            loadDataTable();
        }
    });
}

function remove_discount_code(){
    console.log($('.btn-remove-dc').length);
    $('.btn-remove-dc').off('click').on('click', function () {
        Swal.fire({
            title: "آیا اطمینان دارید؟",
            text: "قادر به بازگردانی این عمل نخواهید بود!",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#34c38f",
            cancelButtonColor: "#f46a6a",
            confirmButtonText: "بله، حذف کن!",
            cancelButtonText: 'انصراف'
        }).then(resp => {
            if (resp.value) {
                let id = $(this).parents('tr').attr('id');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    url: Routes.discountCodeRemove,
                    method: 'POST',
                    dataType: 'json',
                    data: {
                        id: id
                    },
                    success: (respond) => {
                        if (respond.status === 'success') {
                            Swal.fire({
                                title: 'عملیات با موفقیت انجام شد.',
                                type: 'success',
                                showCancelButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: 'متوجه شدم',
                            }).then((resp) => {
                                if (resp.value) {
                                    $(this).parents('tr').remove();
                                }
                            });
                        } else {
                            Swal.fire({
                                title: 'خطا!',
                                text: respond.message,
                                type: 'error',
                                showCancelButton: false,
                                allowOutsideClick: false,
                                allowEscapeKey: false,
                                confirmButtonText: 'متوجه شدم',
                            });
                        }
                    }
                });
            }
        });
    });
}