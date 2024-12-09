const Toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
});


$(function(){
    $.ajaxSetup({
        headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    $('#dataTable').DataTable();

    $('#dataTableOrder').DataTable({
        "paging"        : true,
        "lengthChange"  : false,
        "searching"     : false,
        "ordering"      : true,
        "info"          : true,
        "autoWidth"     : false,
    });

    $('.alert').delay(5000).slideUp('slow', function(){
        $(this).alert('close');
    });

    if ($(".select2").length > 0) $('.select2').select2();

    $(document).on("wheel", "input[type=number]", function (e) {
        $(this).blur();
    });

    if ($("input[data-bootstrap-switch]").length > 0) {
        $("input[data-bootstrap-switch]").each(function(){
            $(this).bootstrapSwitch('state', $(this).prop('checked'));
        });
    }

});

function returnNumber(value){
    value = parseFloat(value);
    return !isNaN(value) ?  value : 0;
}


function returnNumberFormat(value){
    return (value).toFixed(2).replace(/\d(?=(\d{3})+\.)/g, '$&,');
}


function filePreview(input, div) {
    $('#'+div).html('');
    if (input.files && input.files[0]) {
        var base_url = $('meta[name="base_url"]').attr('content');
        $('#'+div).html(`<img src="${base_url}/image_loading.gif" style="height:80px; width: 120px" class="profile-user-img img-responsive img-rounded  "/>`);

        var reader = new FileReader();

        if(input.files[0].size > 3000000){
            input.value='';
            $('#'+div).html('');
        }
        else{
            reader.onload = function (e) {
                $('#'+div).html('<img src="'+e.target.result+'" style="height:80px; width: 120px" class="profile-user-img img-responsive img-rounded  "/>');
            }
            reader.readAsDataURL(input.files[0]);
        }
    }


}



function input_field_validation(input_field, error_message = "Input Field Required"){
    var input_field_value = $(`#${input_field}`).val();
    if (input_field_value == '') {
        toastr.error(error_message);
        $(`#${input_field}`).css('border-color', 'red');
        return false;
    } else {
        $(`#${input_field}`).css('border-color', '#ced4da');
        return true;
    }
}

function input_number_field_validation(input_field, error_message = "Input Field Required"){

    var input_field_value = returnNumber($(`#${input_field}`).val());
    if (input_field_value == 0) {
        toastr.error(error_message);
        $(`#${input_field}`).css('border-color', 'red');
        return false;
    } else {
        $(`#${input_field}`).css('border-color', '#ced4da');
        return true;
    }
}

function select_field_validation(input_field, error_message = "Input Field Required"){

    var input_field_value = $(`#${input_field} option:selected`).val();
    if (input_field_value == '0') {
        toastr.error(error_message);
        $(`#select2-${input_field}-container`).parent().css('border-color', 'red');
        return false;
    } else {
        $(`#select2-${input_field}-container`).parent().css('border-color', '#ced4da');
        return true;
    }

}
