<?php

namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client as GuzzleClient;

class DeezerService
{
    private $deezer_app_id;
    private $deezer_secret_key;
    private $deezer_base_url = 'http://api.deezer.com';

    function __construct($deezer_app_id, $deezer_secret_key)
    {
        $this->client = new GuzzleClient();
        $this->deezer_app_id = $deezer_app_id;
        $this->deezer_secret_key = $deezer_secret_key;
    }

    public function baseRequest(Request $request, $object)
    {
        $session = $request->getSession();

        $code = $_REQUEST["code"];

        $token_url = "https://connect.deezer.com/oauth/access_token.php?app_id=".$this->deezer_app_id."&secret=" .$this->deezer_secret_key."&code=".$code;

        $response  = file_get_contents($token_url);
        $params    = null;
        parse_str($response, $params);

        if (!$session->get('access_token')){
            $session->set('access_token', $params['access_token']);
        }

        $api_url = $this->deezer_base_url.'/'.$object."/?access_token=".$session->get('access_token');
        var_dump($session->get('access_token'));

        return json_decode(file_get_contents($api_url));
    }

    public function postSong($playlistId, $access_token, $songId, $order=0)
    {
        $data = $this->client->post($this->deezer_base_url. "/playlist/".$playlistId."/tracks/", array(
            'query' => [
                'access_token' => $access_token,
                'song' => $songId,
                'order' => $songId
            ]
        ));

        return json_decode($data->getBody()->getContents());
    }

    public function getSong($songId)
    {
        $data = $this->client->get($this->deezer_base_url. "/track/".$songId);

        return json_decode($data->getBody()->getContents());
    }

    public function searchSong($query)
    {
        $data = $this->client->get($this->deezer_base_url. "/search", array(
            'query' => [
                'q' => $query
            ]
        ));

        return json_decode($data->getBody()->getContents());
    }
}