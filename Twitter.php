<?php
require __DIR__ . '/vendor/autoload.php';
use Abraham\TwitterOAuth\TwitterOAuth;
use Dotenv\Dotenv;
Dotenv::createImmutable(__DIR__)->load();
class Twitter {
    private string $apiKey;
    private string $apiSecret;
    private string $accessToken;
    private string $accessTokenSecret;

    public function __construct() {
        $this->apiKey = $_ENV['API_KEY'];
        $this->apiSecret = $_ENV['API_SECRET_KEY'];
        $this->accessToken = $_ENV['ACCESS_TOKEN'];
        $this->accessTokenSecret = $_ENV['ACCESS_TOKEN_SECRET'];
    }
    public function get_api(): TwitterOAuth {
        return new TwitterOAuth($this->apiKey, $this->apiSecret, $this->accessToken, $this->accessTokenSecret);
    }
    public function post_tweet(string $payload): string {
        $api = $this->get_api();
        $response = $api->post("statuses/update", ["status" => $payload]);
        if ($response) {
            $data = [
                'success' => true,
                'message' => 'tweet posted',
                'tweet_id' => $response->id_str
            ];
        } else {
            $data = [
                'success' => false,
                'message' => 'Failed to post'
            ];
        }
        return json_encode($data);
    }
}

