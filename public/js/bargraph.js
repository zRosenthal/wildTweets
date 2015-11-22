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
        $('#bar-graph').highcharts({
            chart: {
                type: 'line'
            },
            title: {
                text: 'Sentiment'
            },
            series: [{

                data: []

            }]
        });

}