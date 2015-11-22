function bargraph($data) {
    var val = parseFloat($data);
    if(val<0)
    {
        $color = '#FF0000';
    }
    else
        $color = '#0f990f';
    // Age categories
    console.log("in");
    var categories = ['a'];
        $('#bar-graph').highcharts({
            chart: {
                type: 'bar'
            },
            title: {
                text: 'Sentiment of data based on recent Twitter posts'
            },
            xAxis: [{
                categories: categories,
                reversed: false,
                labels: {
                    step: 1
                }
            }, { // mirror axis on right side
                opposite: true,
                reversed: true,
                categories: categories,
                linkedTo: 0,
                labels: {
                    step: 1
                }
            }],
            yAxis: {
                title: {
                    text: null
                },
                labels: {
                    formatter: function () {
                        return Math.abs(this.value) + '%';
                    }
                }
            },

            colors : [$color],

            plotOptions: {
                series: {
                    stacking: 'normal'
                },
                column: {
                    colorByPoint: true
                }
            },

            tooltip: {
                formatter: function () {
                    return '<b>' + this.series.name + ', age ' + this.point.category + '</b><br/>' +
                    'Population: ' + Highcharts.numberFormat(Math.abs(this.point.y), 0);
                }
            },

            series: [{
                name: 'Sentiment',
                data: [val*100]

            }]
        });

}