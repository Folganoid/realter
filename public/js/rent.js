$(document).ready(function () {

    checkListRent();

    $('.list_operation').change(function() {
        checkListRent();
    });

});


/**
 * show field 'operation_type' if check RENT operation
 */
function checkListRent() {
    var rent = $('.list_operation').val();
    if(rent == 1) {
        $('.list_rent').prop('disabled', false);
    }
    else {
        $('.list_rent').prop('disabled', true);
    }
}