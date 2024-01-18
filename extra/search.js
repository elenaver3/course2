function liveSearch(searchText) {
    // Отправляем запрос на сервер при изменении текста в поле ввода
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                document.getElementById('searchResults').innerHTML = xhr.responseText;
            } else {
                console.error('Произошла ошибка при выполнении запроса');
            }
        }
    };
    xhr.open('GET', 'search.php?query=' + searchText, true);
    xhr.send();
}