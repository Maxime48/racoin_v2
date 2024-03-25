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
        $motclef = trim($array['motclef'] ?? '');
        $codepostal = trim($array['codepostal'] ?? '');
        $categorie = $array['categorie'] ?? "Toutes catégories";
        $prixMin = $array['prix-min'] ?? "Min";
        $prixMax = $array['prix-max'] ?? "Max";

        $query = Annonce::select();

        if ($motclef !== "") {
            $query->where('description', 'like', '%' . $motclef . '%');
        }

        if ($codepostal !== "") {
            $query->where('ville', '=', $codepostal);
        }

        if ($categorie !== "Toutes catégories" && $categorie !== "-----") {
            $categ = Categorie::select('id_categorie')->where('id_categorie', '=', $categorie)->first()->id_categorie;
            $query->where('id_categorie', '=', $categ);
        }

        if ($prixMin !== "Min" && $prixMax !== "Max") {
            if ($prixMax !== "nolimit") {
                $query->whereBetween('prix', array($prixMin, $prixMax));
            } else {
                $query->where('prix', '>=', $prixMin);
            }
        } elseif ($prixMax !== "Max" && $prixMax !== "nolimit") {
            $query->where('prix', '<=', $prixMax);
        } elseif ($prixMin !== "Min") {
            $query->where('prix', '>=', $prixMin);
        }

        return $query->get();
    }
}

?>