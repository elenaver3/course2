anychart.onDocumentReady(function() {
    fetch("stats.php")
        .then(response => response.json())
        .then(data => {

        var chartData = data.map(function(row) {
            console.log( row.city, row.count);
            return {city: row.city, count: row.count };
        });

        var chart = anychart.bar();

        var x_axis = chart.xAxis();
        x_axis.title("Субъекты РФ");
        x_axis.labels().format('{%Value}');

        var y_axis = chart.yAxis();
        y_axis.title("Количество объектов в базе данных");

        chart.tooltip().format("Количество объектов в базе данных: {%Value}");

        let palette = anychart.palettes.distinctColors();
        palette.items(
            ['#BEFA8D']
        );
        chart.palette(palette);
        
        chart.data(chartData);
        chart.container('chartContainer');
        chart.draw();

    })
    .catch(error => console.error("Ошибка: ", error));


    fetch("stats2.php")
        .then(response => response.json())
        .then(data => {

            var chartData = data.map(function(row) {
                return {x: row.type_place, value: row.count };
            });

            chart = anychart.pie(chartData);

            chart.tooltip().format("Количество объектов в базе данных: {%Value}");

            chart.labels().position("outside");
            
            let palette = anychart.palettes.distinctColors();
            palette.items(
                ['#6DB72F', '#BEFA8D', '#C18D31', '#FFC764', '#C1B831', '#FFF564']
            );
            chart.palette(palette);

            chart.container('chartContainer2');
            chart.draw();

        })
        .catch(error => console.error("Ошибка: ", error));

});