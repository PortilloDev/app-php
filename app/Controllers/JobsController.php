<?php

namespace App\Controllers;

use App\Models\Job;
use App\Services\JobService;
use Laminas\Diactoros\Response\RedirectResponse;
use Laminas\Diactoros\ServerRequest;
use Respect\Validation\Validator as v;

class JobsController extends BaseController
{
    private $jobService;

    public function __construct(JobService $jobService)
    {
        parent::__construct();
        $this->jobService = $jobService;
    }

    public function indexAction()
    {
        //devuelve todos los jobs, eliminados incluidos
        $jobs =Job::withTrashed()->get();
        return $this->renderHTML('jobs/index.twig', compact('jobs'));
    }

    public function deleteAction(ServerRequest $request)
    {
        $params = $request->getQueryParams();
        $this->jobService->deleteJob($params['id']);
                
        return new RedirectResponse('/jobs');
    }


    public function getIndexJob()
    {
        //carga la vista addJob
        return $this->renderHTML('addJob.twig');
    }

    public function getAddJobAction($request)
    {
        $responseMessage = "";

        if ($request->getMethod() == 'POST') {

            $postData = $request->getParsedBody();
            $jobValidator = v::key('title', v::stringType()->notEmpty())
                ->key('description', v::stringType()->notEmpty());

            try {
                $jobValidator->assert($postData);

                $files = $request->getUploadedFiles();
                $file = $files['file'];
                $filePath = null;
                if ($file->getError() == UPLOAD_ERR_OK) {
                    $fileName = $file->getClientFilename();
                    $filePath = "uploads/$fileName";
                    $file->moveTo($filePath);
                }
                $job = new Job();
                $job->title = $postData['title'];
                $job->description = $postData['description'];
                $job->file = $filePath;
                $job->save();
                $responseMessage = 'Saved';
            } catch (\Exception $e) {
                $responseMessage = $e->getMessage();
            }
        }

        //carga la vista addJob
        return $this->renderHTML('addJob.twig', [
            'responseMessage' => $responseMessage
        ]);
    }
}
