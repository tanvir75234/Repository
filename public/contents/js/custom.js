setTimeout(function(){
    $('.alert_success').slideUp(1000);
},5000);

setTimeout(function(){
    $('.alert_error').slideUp(1000);
},10000);

// modal code start
$(document).ready(function(){
    $(document).on("click", "#softDelete", function (){
        var deleteID = $(this).data('id');
        $(".modal_body #modal_id").val(deleteID); 
    });
    
    $(document).on("click", "#restore", function (){
        var restoreID = $(this).data('id');
        $(".modal_body #modal_id").val(restoreID); 
    });

    $(document).on("click", "#delete", function (){
        var deleteID = $(this).data('id');
        $(".modal_body #modal_id").val(deleteID); 
    });
});

$(document).ready( function () {
    $('#myTable').DataTable();

    $('#alltableinfo').DataTable({
        "paging": true,
        "lengthchange": true,
        "searching": true,
        "ordering": false,
        "info": false,
        "autoWidth": false,
    });

    $('#myTableDesc').DataTable({
        "paging": true,
        "lengthchange": true,
        "searching": true,
        "ordering": true,
        "order": [[0,"desc"]],
        "info":true,
        "autowidth": false,
    })

    $('#summary').DataTable({
        "paging": false,
        "lengthchange": false,
        "searching": false,
        "order": [[0,"desc"]],
        "info": true,
        "autoWidth": false,
    });


} );

$(function(){
    $('#date').datepicker({
        autoclose:true,
        format:'yyy-mm-dd',
        todayHighlight:true,
    })

    $('#startDate').datepicker({
        autoclose:true,
        format:'yyy-mm-dd',
        todayHighlight:true,
    })

    $('#lasttDate').datepicker({
        autoclose:true,
        format:'yyy-mm-dd',
        todayHighlight:true ,
    })
});