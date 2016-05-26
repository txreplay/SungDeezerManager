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
        $response = $this->get('deezer.service')->postSong($playlistId, $access_token, $songId);
        if ($response === true) {
            $song = $this->get('deezer.service')->getSong($songId);
            $this->get('firebase.service')->pushSongToFirebase($playlistId, $song);

            return $this->json($song);
        } else {
            return $this->json(false);
        }
    }

    /**
     * @Route("/api/v1/like/playlist/{playlistId}/song/{songId}", name="likeASong")
     */
    public function likeASongAction($playlistId, $songId)
    {
        $response = $this->get('firebase.service')->likeOnFirebase($playlistId, $songId);

        return $this->json($response);
    }

    /**
     * @Route("/api/v1/unlike/playlist/{playlistId}/song/{songId}", name="unlikeASong")
     */
    public function unlikeASongAction($playlistId, $songId)
    {
        $response = $this->get('firebase.service')->unlikeOnFirebase($playlistId, $songId);

        return $this->json($response);
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
