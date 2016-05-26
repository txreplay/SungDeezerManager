<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{
    /**
     * @Route("/api/v1/access_token/{access_token}/playlist/{playlistId}/song/{songId}", name="postToPlaylist")
     */
    public function postToPlaylistAction($access_token, $playlistId, $songId)
    {
        $test = $this->get('deezer.service')->postSong($playlistId, $access_token, $songId);
        $firebase = $this->get('firebase.service')->pushSongToFirebase($playlistId, $songId);

        return $this->json($test);
    }

    /**
     * @Route("/api/v1/search/{query}", name="search")
     */
    public function searchAction($query)
    {
        $result = $this->get('deezer.service')->searchSong($query);

        return $this->json($result);
    }

    private function json($data, $cacheTime = null, $status = 200)
    {
        $response = new JsonResponse($data, $status);
        if (is_integer($cacheTime)) {
            $response->setPublic();
            $response->setMaxAge($cacheTime);
            $response->setSharedMaxAge($cacheTime);
            $date = new \DateTime();
            $date->modify('+'.$cacheTime.' seconds');
            $response->setExpires($date);
        }
        return $response;
    }
}
