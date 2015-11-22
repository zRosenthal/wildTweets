/**
 * Created by zacharyrosenthal on 11/21/15.
 */

function process() {
    var query = document.getElementById("query").value;



    var dataH = $('#display_header');

    $.ajax({
        url: '/process/'+ query,
        method: 'get',
        success: function (data) {
            $("#cat_text").hide();
            dataH.show();
            console.log(data);
            dataH.html(data);

        }

    });

   queueFlyingMonkey(monkey);

}
function queueFlyingMonkey() {

    var monkey = $("#monkey");

    var twitter = $("#twitter");

    var hp = $("#hp");

    var text = $("#cat_text");

    animateInit(monkey, twitter, hp, text);

}