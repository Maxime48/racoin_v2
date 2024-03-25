<?php

namespace controller;

use model\Categorie;

class index
{
    use AnnonceTrait;

    protected $annonce = array();

    public function displayAllAnnonce($twig, $menu, $chemin, $cat)
    {
        $template = $twig->load("index.html.twig");
        $menu = array(
            array(
                'href' => $chemin,
                'text' => 'Acceuil'
            ),
        );

        $this->annonce = $this->getAnnonces($chemin);
        echo $template->render(array(
            "breadcrumb" => $menu,
            "chemin" => $chemin,
            "categories" => $cat,
            "annonces" => $this->annonce
        ));
    }
}