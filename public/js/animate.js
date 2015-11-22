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
    }, 4000, function() {

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
        }, 4000, function() {

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
                }, 4000, function() {
                    hp.hide();


                    var monkeyH = monkey.height();

                    var monkeyW = monkey.width()

                    var monkeyPosition = monkey.offset();


                    var docH = $(document).height();

                    var docW = $(document).width();

                    var H = docH - monkeyH;

                    var W = docW - monkeyW;

                    monkey.css('z-index', -1);

                    monkey.attr("src","img/monkey2.png");

                    text.html("stuck at hpE - smokes if you got em");

                    monkey.delay(2500).animate({
                        width: "+="+W,
                        height: "+="+H,
                        left: "-="+monkeyPosition.left,
                        top: "-="+monkeyPosition.top
                    }, 4000, function() {

                        monkey.attr("src","img/monkey.jpg");

                        text.html("Space Cat is crunching the data");

                    });

                }
            );

        })
    })

}


