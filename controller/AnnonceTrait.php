<?php

namespace controller;

use model\Annonce;
use model\Photo;

trait AnnonceTrait
{
    protected function getAnnonces($chemin, $n = null)
    {
        $query = Annonce::with(['Annonceur' => function($query) {
            $query->select('id_annonceur', 'nom_annonceur');
        }])
            ->select('id_annonce', 'id_annonceur')
            ->orderBy('id_annonce', 'desc');

        if ($n !== null) {
            $query->where('id_categorie', "=", $n);
        }

        $tmp = $query->get();

        // Récupérer toutes les photos en une seule requête
        $photos = Photo::whereIn("id_annonce", $tmp->pluck('id_annonce'))->get();

        $annonce = [];
        foreach ($tmp as $t) {
            $t->nb_photo = $photos->where("id_annonce", "=", $t->id_annonce)->count();
            $photo = $photos->where("id_annonce", "=", $t->id_annonce)->first();
            $t->url_photo = ($t->nb_photo > 0 && $photo) ? $photo->url_photo : $chemin . '/img/noimg.png';
            $t->nom_annonceur = $t->Annonceur->nom_annonceur;
            $annonce[] = $t;
        }
        return $annonce;
    }
}