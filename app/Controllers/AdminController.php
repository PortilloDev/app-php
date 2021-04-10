<?php


namespace App\Controllers;


class AdminController extends BaseController
{

    public function getIndex()
    {
        //carga la vista addJob
        return $this->renderHTML('admin.twig');
    }

   
}
