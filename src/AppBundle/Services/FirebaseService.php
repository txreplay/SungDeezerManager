<?php

namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client as GuzzleClient;

class FirebaseService
{
    private $defaul_url = 'https://sung.firebaseio.com/';
    private $default_token = 'R3EaAojB9LbFJxGu8e1RDWcsWi0M5s8GjJT6yW9F';
    private $default_path = '/data';

    function __construct()
    {
        $this->firebase = new \Firebase\FirebaseLib($this->defaul_url, $this->default_token);
    }

    public function pushSongToFirebase($playlistId, $song, $author='Valentin')
    {
        $this->firebase->push($this->default_path.'/'.$playlistId.'/'.$song, $author);
    }
}