<?php
require '../vendor/autoload.php';

use Abraham\TwitterOAuth\TwitterOAuth;

// Prepare app
$app = new \Slim\Slim(array(
    'templates.path' => '../templates',
));

// Create monolog logger and store logger in container as singleton
// (Singleton resources retrieve the same log resource definition each time)
$app->container->singleton('log', function () {
    $log = new \Monolog\Logger('slim-skeleton');
    $log->pushHandler(new \Monolog\Handler\StreamHandler('../logs/app.log', \Monolog\Logger::DEBUG));
    return $log;
});

// Prepare view
$app->view(new \Slim\Views\Twig());
$app->view->parserOptions = array(
    'charset' => 'utf-8',
    'cache' => realpath('../templates/cache'),
    'auto_reload' => true,
    'strict_variables' => false,
    'autoescape' => true
);
$app->view->parserExtensions = array(new \Slim\Views\TwigExtension());

// Define routes
$app->get('/', function () use ($app) {
    // Sample log message
    $app->log->info("Slim-Skeleton '/' route");
    // Render index view
    $app->render('index.html');
});

$app->get('/callback', function () use ($app) {

    $app->log->info("here");

});


$app->get('/app', function () use ($app) {

    //consumer key for twitter api
    $consumerKey = "4eb9kZcRB4KZf9p6Pp4dxeN1W";

    //consumer secret for twitter api
    $consumerSecret = "xfTRGk2xK7y0QeQ9PjoCB6rTrBWgYpNQL2y9tTigetN1Ftsl4Y";

    //create new OAuth connection
    $connection = new TwitterOAuth($consumerKey, $consumerSecret);

    //request bearer token
    $request_token = $connection->oauth2("oauth2/token", array("oauth_callback" => "http://wildTweets.dev/callback", "grant_type" =>"client_credentials"));

    $app->log->info(json_encode($request_token));

    //get
    $oauth_token=$request_token->access_token;

    $app->log->info("hello world");

    //log tokens for debug
    $app->log->info("Oath token: " . $oauth_token);

    $connection = new TwitterOAuth($consumerKey, $consumerSecret, null, $oauth_token);
    $app->log->info(json_encode($connection));

    $result = $connection->get('statuses/user_timeline', array('screen_name' => 'twitterapi'));
    if ($connection->getLastHttpCode() !== 200) {
        $app->log->info("error");
    }

    $app->log->info(json_encode($result));
});



// Run app
$app->run();
