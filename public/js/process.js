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

function animateInit(monkey, twitter, hp, text) {

    text.show();

    text.html("SpaceCat To The Rescue");



    var docH = $(document).height();

    var docW = $(document).width();

    var left = docW/2 -100;

    var top = docH - 225;

    var W = -(250 - docW);

    var H = -(200 - docH);


    monkey.animate({
        width: "-="+W,
        height: "-="+H,
        left: "+="+left,
        top: "+="+top
    }, 5000, function() {

        monkey.css('z-index', 1);

        text.html("SpaceCat retrieving tweets");

        twitter.show();

        var twitterPosition = twitter.offset();

        var monkeyPosition = monkey.offset();


        var top = twitterPosition.top - monkeyPosition.top;

        var left = twitterPosition.left - monkeyPosition.left;



        monkey.animate({
            left: "+="+left,
            top: "+="+top
        }, 5000, function() {

            twitter.hide();

            text.html("Tweets Retrieved, off to Hp<span style='font-size:32px; font-weight: 900'>E</span>");

            hp.show();

            var monkeyPosition = monkey.offset();

            var hpPosition = hp.offset();

            var top = hpPosition.top - monkeyPosition.top;

            var left = hpPosition.left - monkeyPosition.left;


            monkey.animate({
                    left: "+="+left,
                    top: "+="+top
                }, 5000, function() {

                    hp.hide();

                    text.hide();

                    var monkeyH = monkey.height();

                    var monkeyW = monkey.width()

                    var monkeyPosition = monkey.offset();


                    var docH = $(document).height();

                    var docW = $(document).width();

                    var H = docH - monkeyH;

                    var W = docW - monkeyW;

                    monkey.css('z-index', -1);

                    monkey.animate({
                        width: "+="+W,
                        height: "+="+H,
                        left: "-="+monkeyPosition.left,
                        top: "-="+monkeyPosition.top
                    }, 5000, function() {

                        text.html("Space Cat is crunching the datag");

                    });

                }
            );

        })
    })

}


