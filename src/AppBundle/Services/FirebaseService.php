<?php

namespace AppBundle\Services;

use Symfony\Component\HttpFoundation\Request;
use GuzzleHttp\Client as GuzzleClient;

class FirebaseService
{
    private $defaul_url = 'https://sung.firebaseio.com/';
    private $default_token = 'R3EaAojB9LbFJxGu8e1RDWcsWi0M5s8GjJT6yW9F';
    private $default_path = '/playlists';

    function __construct()
    {
        $this->firebase = new \Firebase\FirebaseLib($this->defaul_url, $this->default_token);
    }

    public function pushSongToFirebase($playlistId, $song, $author='Valentin')
    {
        $this->firebase->set($this->default_path.'/'.$playlistId.'/author', $author);
        $this->firebase->set($this->default_path.'/'.$playlistId.'/songs/'.$song->id.'/id', $song->id);
        $this->firebase->set($this->default_path.'/'.$playlistId.'/songs/'.$song->id.'/title', $song->title);
        $this->firebase->set($this->default_path.'/'.$playlistId.'/songs/'.$song->id.'/artist', $song->artist->name);
        $this->firebase->set($this->default_path.'/'.$playlistId.'/songs/'.$song->id.'/likes', 1);
    }
}