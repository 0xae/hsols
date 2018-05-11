function renderStack(container, title, categories, series) {
    var seriesExample = [{
        name: 'D1',
        data: [11, 10, 12],
        color: '#681133'
    }, {
        name: 'D2',
        data: [21, 21, 31]
    }, {
        name: 'D3',
        data: [31, 42, 42]
    }, {
        name: 'D4',
        data: [31, 42, 42]
    }];

    Highcharts.chart(container, {
        chart: {
            type: 'column'
        },
        title: {
            text: title
        },
        xAxis: {
            // categories: ['DENÚNCIAS', 'QUEIXAS', 'RECLAMAÇÕES']
            categories: categories
        },
        yAxis: {
            min: 0,
            title: {
                text: ''
            },
            stackLabels: {
                enabled: true,
                style: {
                    fontWeight: 'bold',
                    color: (Highcharts.theme && Highcharts.theme.textColor) || 'gray'
                }
            }
        },
        legend: {
            align: 'right',
            x: -30,
            verticalAlign: 'top',
            y: 25,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.background2) || 'white',
            borderColor: '#CCC',
            borderWidth: 1,
            shadow: false
        },
        tooltip: {
            headerFormat: '<b>{point.x}</b><br/>',
            pointFormat: '{series.name}: {point.y}<br/>Total: {point.stackTotal}'
        },
        plotOptions: {
            column: {
                stacking: 'normal',
                dataLabels: {
                    enabled: true,
                    color: (Highcharts.theme && Highcharts.theme.dataLabelsColor) || 'white'
                }
            }
        },
        series: series
    });        
}
