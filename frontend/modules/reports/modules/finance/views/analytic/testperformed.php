<script type="text/javascript">

Highcharts.chart('tests', {
    chart: {
        type: 'packedbubble',
        height: '100%'
    },
    title: {
        text: 'Tests Performed',
        style: { fontSize: '40px'}
    },
    // colors: ['#2f7ed8', '#0d233a', '#8bbc21', '#910000', '#1aadce',
    //     '#492970', '#f28f43', '#77a1e5', '#c42525', '#a6c96a'],
    tooltip: {
        useHTML: true,
        pointFormat: '<b>{point.name}:</b> {point.value}'
    },
    legend: {
        itemStyle: {
            fontSize: "25px"
        }
    },
    plotOptions: {
        packedbubble: {
            minSize: '40%',
            maxSize: '120%',
            zMin: 0,
            zMax: 1000,
            layoutAlgorithm: {
                splitSeries: true,
                gravitationalConstant: 0.01,
                 seriesInteraction: true,
                dragBetweenSeries: true,
                parentNodeLimit: true
            },
            dataLabels: {
                enabled: true,
                format: '{point.name}',
                filter: {
                    property: 'y',
                    operator: '>',
                    value: 20
                },
                style: {
                    fontSize: '20px',
                    color: 'black',
                    textOutline: 'none',
                    fontWeight: 'normal'
                }
            }
        }
    },
    series : <?= $data ?>
});



</script>