<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{
    /**
     * @Route("/api/v1/access_token/{access_token}/playlist/{playlist}/song/{song}", name="upvotes")
     */
    public function postTrackAction($access_token, $playlistId, $song)
    {
        $test = $this->get('deezer.service')->postTrack($playlistId, $access_token, $song);

        return $this->json($test);
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
