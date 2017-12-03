$(document).ready(function () {

    /**
     * edit image name
      */
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


    /**
     * delete image
     */
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

    /**
     * edit document name
     */
    $('.document_edit').click(function() {
        var docId = $(this).val();
        var docName = $('#document_name' + docId).val();

        $.ajax({
            type: "POST",
            url: "/document/edit",
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            data: {"id": docId, "name": docName},
            dataType: 'json',
            success: function (html) {
                var status = JSON.parse(html).status;

                (status == 'ok') ? $('.doc_edit_msg').css('color', 'green') : $('doc_.edit_msg').css('color', 'red');
                $('#doc_edit_msg' + docId).html(status);
            }
        });
    });


    /**
     * delete document
     */
    $('.document_delete').click(function() {
        var docId = $(this).val();

        $.ajax({
            type: "POST",
            url: "/document/delete/" + docId,
            cache: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (html) {
                var status = JSON.parse(html).status;

                (status == 'ok') ? $('.doc_delete_msg').css('color', 'green') : $('.doc_delete_msg').css('color', 'red');
                $('#doc_delete_msg' + docId).html(status);
            }
        });
    })

});
