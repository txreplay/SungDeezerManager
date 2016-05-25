<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class FrontController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        return $this->render('front/index.html.twig', array(
            'deezer_app_id' => $this->getParameter('deezer_app_id'),
            'deezer_redirect_uri' => $this->getParameter('deezer_redirect_uri'),
        ));
    }

    /**
     * @Route("/app", name="app")
     */
    public function appAction(Request $request)
    {
        $user = $this->get('deezer.service')->baseRequest($request, 'user/me');
        $playlists = $this->get('deezer.service')->baseRequest($request, 'user/me/playlists');

        $uberPlaylist = null;
        foreach ($playlists->data as $playlist) {
            if ($playlist->title == 'Süng') {
                $uberPlaylist = $playlist;
            }
        }

        $tracks = $this->get('deezer.service')->baseRequest($request, 'playlist/'.$uberPlaylist->id.'/tracks');

        return $this->render('front/app.html.twig', array(
            'deezer_app_id' => $this->getParameter('deezer_app_id'),
            'deezer_secret_key' => $this->getParameter('deezer_secret_key'),
            'deezer_redirect_uri' => $this->getParameter('deezer_redirect_uri'),
            'user' => $user,
            'playlist' => $uberPlaylist,
            'tracks' => $tracks,
        ));
    }
}
