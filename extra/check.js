var sub_check = document.querySelectorAll('input.sub'), main_check = document.getElementById('all');

for(var i = 0; i < sub_check.length; i++) {
    sub_check[i].onclick = function() {
        var checkedCount = document.querySelectorAll('input.sub:checked').length;

        main_check.checked = checkedCount > 0;
        main_check.indeterminate = checkedCount > 0 && checkedCount < sub_check.length;
        document.getElementById('all').value = "not_all_checked";
    }
}

main_check.onclick = function() {
    for(var i = 0; i < sub_check.length; i++) {
        sub_check[i].checked = this.checked;
    }
    document.getElementById('all').value = "all_checked";
}