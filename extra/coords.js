ymaps.ready(init);
var myMap;

function init(){     
    myMap = new ymaps.Map ("map", {
        center: [55.76, 37.64],
        controls: ['zoomControl'],
        zoom: 10
    });

    myMap.controls.add('zoomControl', {
        size: "large"
    });

    var address = 'Россия, Москва, Тверская, д. 7';

    ymaps.geocode(address).then(function(res) {
        var coord = res.geoObjects.get(0).geometry.getCoordinates();

        var myPlacemark = new ymaps.Placemark(coord, null, {
            preset: 'islands#blueDotIcon',
            draggable: true
        });

        /* Событие dragend - получение нового адреса */
        myPlacemark.events.add('dragend', function(e){
            var cord = e.get('target').geometry.getCoordinates();
            $('#ypoint').val(cord);
            ymaps.geocode(cord).then(function(res) {
                var data = res.geoObjects.get(0).properties.getAll();
                $('#address').val(data.text);
            });
            
        });

        myPlacemark.events.add('drag', function(e) {
            document.getElementById("coordinates").value = myPlacemark.geometry.getCoordinates();
        });

        // myMap.events.add('click', function (e) {
        //     myPlacemark.getOverlaySync().getData().geometry.setCoordinates(e.get('target').geometry.getCoordinates());
        //     document.getElementById("coordinates").value = myPlacemark.geometry.getCoordinates();
        // });
        
        myMap.geoObjects.add(myPlacemark);	
        document.getElementById("coordinates").value = myPlacemark.geometry.getCoordinates();
    });


}