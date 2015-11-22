function process() {
    var query = document.getElementById("query").value;

    dataSpace.first = 1;
    bargraph();
    $('#bar-graph').hide();

    queueFlyingMonkey();

   dataSpace.dates = getCurrentDate();

    makeRequest(query);




}


function makeRequest(query) {

    $.ajax({
        url: '/process/'+ query +'/'+ dataSpace.dates[dataSpace.i] + '/' + dataSpace.dates[dataSpace.i +1] + '/' + $('#rt').val(),
        method: 'get',
        success: function (data) {
            console.log(data);
                if(dataSpace.first) {
                $('#bar-graph').show();
                    bargraph();
                    dataSpace.first = 0;
                    $('#monkey').css('z-index','-1 !important');
                }
                $("#cat_text").hide();
                console.log(data);
                //dataH.html(data);
                addPoint(parseFloat(data),dataSpace.dates[dataSpace.i]);
                dataSpace.i++;
                if(dataSpace.i < 7) {
                    makeRequest(query);
                }

        }
    });

}
function addPoint(data,date) {
    $('#bar-graph').highcharts().series[0].addPoint([date,data]);
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