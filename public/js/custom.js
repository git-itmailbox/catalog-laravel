jQuery(function () {

    $('#createCategoryBtn').click(function () {
        var msgErr = $('#message-error')

        var name = $('#name').val()
        var csrf_token = document.head.querySelector('meta[name="csrf-token"]').content;

        msgErr.hide()
        msgErr.html("")
        $.ajax({
            url: '/admin/category',
            method: 'POST',
            dataType: 'json',
            data: {
                name: name,
                _token: csrf_token

            }
        })
            .done(function (data) {
                if (data.status == 'ok') {
                    location.reload()
                }
            })
            .fail(function (error, textStatus) {
                var response = JSON.parse(error.responseText)
                var ul = $('<ul/>').append(error)

                _.forEach(response.errors, function (error) {
                    var li = $('<li/>').append(error)
                    ul.append(error)
                })

                msgErr.append(ul).show()
                console.log(response.errors)
            })
    });


    $("#image_small").change(function () {

        $('#image_preview_small').html("");

        var total_file = document.getElementById("image_small").files.length;

        for (var i = 0; i < total_file; i++) {
            $('#image_preview_small').append("<img src='" + URL.createObjectURL(event.target.files[i]) + "' width='110'>");
        }

    });


    $("#image_medium").change(function () {

        $('#image_preview_medium').html("");

        var total_file = document.getElementById("image_medium").files.length;

        for (var i = 0; i < total_file; i++) {
            $('#image_preview_medium').append("<img src='" + URL.createObjectURL(event.target.files[i]) + "' width='110'>");
        }

    });


    $("#image_large").change(function (event) {

        $('#image_preview_large').html("");

        var total_file = document.getElementById("image_large").files.length;

        for (var i = 0; i < total_file; i++) {
            $('#image_preview_large').append("<img src='" + URL.createObjectURL(event.target.files[i]) + "' width='110'>");
        }


    });


    $("#deleteSelected").click(function (event) {
        $(".error-message").addClass('text-hide');
        if (confirm('Do you really want delete these pictures')) {

            var csrf_token = document.head.querySelector('meta[name="csrf-token"]').content;
            var ids = new Array();
            $("[name=delete_picture]:checked").each(function () {
                ids.push($(this).val());
            });

            $.ajax({
                url: '/admin/pictures/delete_many',
                method: 'DELETE',
                dataType: 'json',
                data: {
                    ids: ids,
                    _token: csrf_token

                }
            })
                .then(function (data) {
                    if(data.status =='ok')
                    {
                        location.reload()
                    }
                console.log(data)
            })
                .catch(function (data) {
                    $response = JSON.parse(data.responseText)
                    $(".error-message").html($response.message).toggleClass('text-hide');
                });
        }
    });



    $("#deleteProduct").click(function (event) {

        if (confirm('Do you really want delete this product?')) {

            var csrf_token = document.head.querySelector('meta[name="csrf-token"]').content;

            $.ajax({
                url: '',
                method: 'DELETE',
                dataType: 'json',
                data: {
                    _token: csrf_token

                }
            })
                .then(function (data) {
                    if(data.status =='ok')
                    {
                        window.location.href = '/admin/products';
                    }
                    console.log(data)
                })
                .catch(function (data) {
                    $response = JSON.parse(data.responseText)
                    console.log($response)
                });
        }
    });


});
