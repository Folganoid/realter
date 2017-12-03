$(document).ready(function () {

    $('.image_edit').click(function() {
        var imageId = $(this).val();
        var imageName = $('#name' + imageId).val();


        $.ajax({
            type: "POST",
            url: "/image/edit",
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {"id": imageId, "name": imageName},
            dataType: 'json',
            success: function (html) {
                var status = JSON.parse(html).status;

                (status == 'ok') ? $('.edit_msg').css('color', 'green') : $('.edit_msg').css('color', 'red');
                $('#edit_msg' + imageId).html(status);
            }
        });

    });

    $('.image_delete').click(function() {
        var imageId = $(this).val();

        $.ajax({
            type: "POST",
            url: "/image/delete/" + imageId,
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (html) {
                var status = JSON.parse(html).status;

                (status == 'ok') ? $('.delete_msg').css('color', 'green') : $('.delete_msg').css('color', 'red');
                $('#delete_msg' + imageId).html(status);
            }
        });



    })

});
