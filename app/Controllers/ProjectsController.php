<?php

namespace App\Controllers;

use App\Models\Project;
use Respect\Validation\Validator as v;

class ProjectsController extends BaseController
{

    public function getIndexProject()
    {
        //carga la vista addJob
        return $this->renderHTML('addProject.twig');
    }

    public function getAddProjectsAction($request)
    {
        $responseMessage = "";


        if ($request->getMethod() == 'POST') {
            $postData = $request->getParsedBody();
            $projectValidator = v::key('title', v::stringType()->notEmpty())
                ->key('description', v::stringType()->notEmpty());

            try {
                $projectValidator->assert($postData);
                $project = new Project();
                $project->title = $postData['title'];
                $project->description = $postData['description'];
                $project->save();
                $responseMessage = 'Saved';
            } catch (\Exception $e) {
                $responseMessage = $e->getMessage();
            }
        }

        //carga la vista addProject
        return $this->renderHTML('addProject.twig', [
            'responseMessage' => $responseMessage
        ]);
    }
}
