function process() {
    var query = document.getElementById("query").value;

    dataSpace.first = 1;
    bargraph();
    $('#bar-graph').hide();

    queueFlyingMonkey();

    dates = getCurrentDate();

    for(var i = 0; i<7; i++) {

        console.log(dates[i]);
        console.log(dates[i+1]);
        makeRequest(query, dates[i],dates[i+1]);


    }

}


function makeRequest(query,date1, date2) {

    $.ajax({
        url: '/process/'+ query +'/'+ date1 + '/' + date2,
        method: 'get',
        success: function (data) {
            console.log(data);
                if(dataSpace.first) {
                $('#bar-graph').show();
                    bargraph();
                    dataSpace.first = 0;
                    $('#monkey').css('z-index','-1 !important');
                }
                dataSpace.data = data;
                $("#cat_text").hide();
                console.log(data);
                //dataH.html(data);
                addPoint(parseFloat(data));


        }
    });

}
function addPoint(data) {
    $('#bar-graph').highcharts().series[0].addPoint(data);
}

function getCurrentDate() {

    var dates = [];

    var date = Date();

    for (var i = 0; i<=7; i++) {

        var d = new Date(date),
            month = '' + (d.getMonth() + 1),
            day = '' + (d.getDate() -7 + i),
            year = d.getFullYear();

        if (month.length < 2) month = '0' + month;
        if (day.length < 2) day = '0' + day;
        dates.push([year, month, day].join('-'));

    }

    return dates;

}

function queueFlyingMonkey() {

    var monkey = $("#monkey");

    var twitter = $("#twitter");

    var hp = $("#hp");

    var text = $("#cat_text");

    animateInit(monkey, twitter, hp, text);

}