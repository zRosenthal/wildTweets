<?php
/**
 * Created by PhpStorm.
 * User: rosent76
 * Date: 11/21/15
 * Time: 5:38 PM
 */
require '../vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;

class TwitterRequest {


    const CONSUMER_KEY = "4eb9kZcRB4KZf9p6Pp4dxeN1W";
    const CONSUMER_SECRET = "xfTRGk2xK7y0QeQ9PjoCB6rTrBWgYpNQL2y9tTigetN1Ftsl4Y";

    private $connection;

    public function __construct()
    {
        //create new OAuth connection
        $connection = new TwitterOAuth(self::CONSUMER_KEY, self::CONSUMER_SECRET);
        $fp = fopen("debug.txt", 'w');
        fwrite($fp, json_encode($connection));
        fclose($fp);
        //request bearer token
        $request_token = $connection->oauth2("oauth2/token", array("oauth_callback" => "http://wildTweets.dev/callback", "grant_type" =>"client_credentials"));

        //get
        $oauth_token=$request_token->access_token;

        $this->connection = new TwitterOAuth(self::CONSUMER_KEY, self::CONSUMER_SECRET, null, $oauth_token);
    }


    function requestTweet($query,$args)
    {
        $result = $this->connection->get($query, $args);
        return $result;
    }
}