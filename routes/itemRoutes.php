<?php

use controller\item;

function itemRoutes($app, $twig, $menu, $chemin, $cat, $dpt) {
    $app->get('/item/{n}', function ($request, $response, $arg) use ($twig, $menu, $chemin, $cat) {
        $n = $arg['n'];
        $item = new item();
        $item->afficherItem($twig, $menu, $chemin, $n, $cat->getCategories());
    });

    $app->get('/item/{id}/edit', function ($request, $response, $arg) use ($twig, $menu, $chemin) {
        $id = $arg['id'];
        $item = new item();
        $item->modifyGet($twig, $menu, $chemin, $id);
    });

    $app->post('/item/{id}/edit', function ($request, $response, $arg) use ($twig, $app, $menu, $chemin, $cat, $dpt) {
        $id = $arg['id'];
        $item = new item();
        $item->modifyPost($twig, $menu, $chemin, $id, $cat->getCategories(), $dpt->getAllDepartments());
    });

    $app->map(['GET, POST'], '/item/{id}/confirm', function ($request, $response, $arg) use ($twig, $app, $menu, $chemin) {
        $id = $arg['id'];
        $allPostVars = $request->getParsedBody();
        $item = new item();
        $item->edit($twig, $menu, $chemin, $id, $allPostVars);
    });

    $app->get('/del/{n}', function ($request, $response, $arg) use ($twig, $menu, $chemin) {
        $n = $arg['n'];
        $item = new controller\item();
        $item->supprimerItemGet($twig, $menu, $chemin, $n);
    });

    $app->post('/del/{n}', function ($request, $response, $arg) use ($twig, $menu, $chemin, $cat) {
        $n = $arg['n'];
        $item = new controller\item();
        $item->supprimerItemPost($twig, $menu, $chemin, $n, $cat->getCategories());
    });
}