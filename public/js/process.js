function process(count) {
    var query = document.getElementById("query").value;

    if(count == 20) {
        console.log(count);
        process(60);
        queueFlyingMonkey();
    } else if(count == 60) {
        console.log(count);
        process(120);
    } else if(count == 120) {
        console.log(count);
        process(200);
    }



    var dataH = $('#display_header');

    $.ajax({
        url: '/process/'+ query +'/'+ count,
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
function queueFlyingMonkey() {

    var monkey = $("#monkey");

    var twitter = $("#twitter");

    var hp = $("#hp");

    var text = $("#cat_text");

    animateInit(monkey, twitter, hp, text);

}