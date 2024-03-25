<?php

namespace controller;

use model\Categorie;

class getCategorie
{
    use AnnonceTrait;

    protected $categories = [];

    protected $annonce = [];

    public function getCategories()
    {
        return Categorie::orderBy('nom_categorie')->get(['nom_categorie', 'id_categorie'])->toArray();
    }

    public function displayCategorie($twig, $menu, $chemin, $cat, $n)
    {
        $template = $twig->load("index.html.twig");
        $menu = array(
            array('href' => $chemin,
                'text' => 'Acceuil'),
            array('href' => $chemin . "/cat/" . $n,
                'text' => Categorie::find($n)->nom_categorie)
        );

        $this->annonce = $this->getAnnonces($chemin, $n);
        echo $template->render(array(
            "breadcrumb" => $menu,
            "chemin" => $chemin,
            "categories" => $cat,
            "annonces" => $this->annonce));
    }
}