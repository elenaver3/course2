$(document).ready(function () {
    $('input[type="type_choose"]').
    click(
        function () {
            const inputValue = 
            $(this).attr("value");
            const targetBox = 
            $("." + inputValue);
            $(".choose").
            not(targetBox).hide();
            $(targetBox).show();
        }
    );
});