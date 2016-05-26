<?php

namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client as GuzzleClient;

class FirebaseService
{
    private $defaul_url = 'https://sung-2481f.firebaseio.com/';
    private $default_token = 'AIzaSyDYLhMiUps9aup8qrehQcGAdpbhtAnfpZk';
    private $default_path = '/';

    function __construct()
    {
        $this->firebase = new \Firebase\FirebaseLib($this->defaul_url, $this->default_token);
    }

    public function pushSongToFirebase($playlistId, $song, $author='Valentin')
    {
//        $this->firebase->push($this->default_path.'/'.$playlistId.'/'.$song, $author);
        $value = $this->firebase->get($this->default_path);
        var_dump($value);
        die();
    }
}