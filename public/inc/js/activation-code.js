$(document).ready(function() {
    loadData();

    $('select').select2();
    submit_code();
});


function submit_code() {
    $('#form_add_code').off('submit').on('submit', function (e) {
        e.preventDefault();
        const productID   = parseInt($('#product_list').val());
        const count_code  = parseInt($('#count').val());

        console.log($('meta[name="csrf-token"]').attr('content'));
        $.ajax({
            url: Routes.generateCode,
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {
                product_id: productID,
                count: count_code,
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
            error: (data) => {
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
        url: Routes.listCode,
        method: 'GET',
        dataType: 'json',
        success: (respond) => {
            if ( respond.status !== "success" ) return;
            respond.data.forEach((object,index) => {
                let on_created = object.created_at.split(' ');

                let on_created_date = on_created[0].split('-');
                let on_created_time = on_created.reverse()[0];
                on_created_date     = jalaali.toJalaali(+on_created_date[0],+on_created_date[1],+on_created_date[2]);

                $('#datatable-buttons tbody').append(`
                <tr id="${object.id}">
                    <td>${index + 1}</td>
                    <td>${object.code}</td>
                    <td>${object.title}</td>
                    <td>${on_created_date.jy + '/' + on_created_date.jm + '/' + on_created_date.jd + ' ' + on_created_time}</td>
                </tr>
                `);
            });
            loadDataTable();
        }
    });
}