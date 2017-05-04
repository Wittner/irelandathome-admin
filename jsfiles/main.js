$( document ).ready(function() {


// Edit booking page. Cancel checkbox prompt
$('#cancelStatus').click(function() {
    if($(this).is(':checked')) {
        var cancelled = confirm("Warning! This sale will be cancelled! Accommodation cost will be set to ZERO. You can still enter a booking fee if you wish.");
        if(cancelled === true){
        }else{
            $('#cancelStatus').attr('checked', false);
        }
    
    }
});

});