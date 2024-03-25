<?php

namespace controller;

use model\ApiKey;

class KeyGenerator
{
    private $apiKey;

    public function __construct()
    {
        $this->apiKey = new ApiKey();
    }

    function show($twig, $menu, $chemin, $cat)
    {
        $this->renderTemplate($twig, $chemin, $cat, "key-generator.html.twig");
    }

    function generateKey($twig, $menu, $chemin, $cat, $nom)
    {
        $nospace_nom = str_replace(' ', '', $nom);

        if ($nospace_nom === '') {
            $this->renderTemplate($twig, $chemin, $cat, "key-generator-error.html.twig");
        } else {
            $key = $this->generateUniqueKey();
            $this->saveKey($key, $nom);
            $this->renderTemplate($twig, $chemin, $cat, "key-generator-result.html.twig", ["key" => $key]);
        }
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

    private function generateUniqueKey()
    {
        return uniqid();
    }

    private function saveKey($key, $nom)
    {
        $this->apiKey->id_apikey = $key;
        $this->apiKey->name_key = htmlentities($nom);
        $this->apiKey->save();
    }
}

?>