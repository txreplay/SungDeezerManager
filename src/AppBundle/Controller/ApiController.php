<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;

class ApiController extends Controller
{
    /**
     * @Route("/api/v1/track", name="upvotes")
     */
    public function postTrackAction(Request $request)
    {
        $test = $this->get('deezer.service')->postTrack(1862036222, 'fr1YKY1pBQxCvTd7i6GurXWlaVkaOYP3w1kzqfIc0FT3Bz2m88', 124874352);

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
