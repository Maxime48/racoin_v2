<?php

namespace controller;

use model\Annonce;
use model\Annonceur;
use model\Photo;

class viewAnnonceur
{

    protected Annonceur $annonceur;

    public function __construct()
    {
    }

    function afficherAnnonceur($twig, $menu, $chemin, $n, $cat)
    {
        $this->annonceur = annonceur::find($n);
        if (!isset($this->annonceur)) {
            echo "404";
            return;
        }
        $tmp = annonce::where('id_annonceur', '=', $n)->get();

        // Récupérer toutes les photos en une seule requête
        $photos = Photo::whereIn("id_annonce", $tmp->pluck('id_annonce'))->get();

        $annonces = [];
        foreach ($tmp as $a) {
            $a->nb_photo = $photos->where("id_annonce", "=", $a->id_annonce)->count();
            $photo = $photos->where("id_annonce", "=", $a->id_annonce)->first();
            $a->url_photo = ($a->nb_photo > 0 && $photo) ? $photo->url_photo : $chemin . '/img/noimg.png';
            $annonces[] = $a;
        }
        $template = $twig->load("annonceur.html.twig");
        echo $template->render(array('nom' => $this->annonceur,
            "chemin" => $chemin,
            "annonces" => $annonces,
            "categories" => $cat));
    }
}