function process(count) {
    var query = document.getElementById("query").value;

    var dataH = $('#display_header');

    dates = getCurrentDate();

    for(var i = 0; i<7; i++) {

        makeRequest(dates[i],dates[i+1]);

    }

}


function makeRequest(date1, date2) {

    $.ajax({
        url: '/process/'+ query +'/'+ date1 + '/' + date2,
        method: 'get',
        success: function (data) {
            console.log(data);
            if (parseFloat(data) == dataSpace.data) {
                console.log("do nothing");
            }
            else {
                dataSpace.data = data;
                $("#cat_text").hide();
                dataH.show();
                console.log(data);
                //dataH.html(data);
                bargraph(data);
            }

        }
    })

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