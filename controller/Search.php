<?php

namespace controller;

use model\Annonce;
use model\Categorie;

class Search
{
    function show($twig, $menu, $chemin, $cat)
    {
        $this->renderTemplate($twig, $chemin, $cat, "search.html.twig");
    }

    function research($array, $twig, $menu, $chemin, $cat)
    {
        $results = $this->performSearch($array);
        $this->renderTemplate($twig, $chemin, $cat, "index.html.twig", ["annonces" => $results]);
    }

    private function renderTemplate($twig, $chemin, $cat, $templateName, $additionalParams = [])
    {
        $template = $twig->load($templateName);
        $menu = array(
            array('href' => $chemin,
                'text' => 'Acceuil'),
            array('href' => $chemin . "/search",
                'text' => "Recherche")
        );

        $params = array_merge(["breadcrumb" => $menu, "chemin" => $chemin, "categories" => $cat], $additionalParams);
        echo $template->render($params);
    }

    private function performSearch($array)
    {
        $query = Annonce::select();

        if (!empty(trim($array['motclef'] ?? ''))) {
            $query->where('description', 'like', '%' . $array['motclef'] . '%');
        }

        if (!empty(trim($array['codepostal'] ?? ''))) {
            $query->where('ville', '=', $array['codepostal']);
        }

        if (($array['categorie'] ?? "Toutes catégories") !== "Toutes catégories" && $array['categorie'] !== "-----") {
            $query->where('id_categorie', '=', $array['categorie']);
        }

        if (($array['prix-min'] ?? "Min") !== "Min") {
            $query->where('prix', '>=', $array['prix-min']);
        }

        if (($array['prix-max'] ?? "Max") !== "Max" && $array['prix-max'] !== "nolimit") {
            $query->where('prix', '<=', $array['prix-max']);
        }

        return $query->get();
    }
}

?>