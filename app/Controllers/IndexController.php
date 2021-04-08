<?php

namespace App\Controllers;


use App\Models\{Job, Project};


class IndexController extends BaseController
{

    public function indexAction()
    {


        $jobs = Job::all();

        $projects = Project::all();

        $name = "Iván Portillo";
        $mail = "ipp_1981@hotmail.com";
        $phone = "682177179";
        $linkedin_username = "https://www.linkedin.com/in/iv%C3%A1n-portillo-p%C3%A9rez-a9676878/";
        $twitter_username = "@portillo_dev";
        $web_personal = "https://ivan-portillo-perez.com/";
        $gitHub = "https://github.com/PortilloDev";
        $limiteMonths = 24;

        //carga la vista index
        return $this->renderHTML('index.twig', [
            'name' => $name,
            'mail' => $mail,
            'phone' => $phone,
            'linkedin_username' => $linkedin_username,
            'twitter_username' =>  $twitter_username,
            'web_personal' => $web_personal,
            'gitHub' => $gitHub,
            'limiteMonths' => $limiteMonths,
            'jobs' => $jobs,
            'projects' => $projects
        ]);
    }
}
