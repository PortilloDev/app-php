<?php

namespace App\Controllers;

use App\Models\Job;
use Respect\Validation\Validator as v;

class JobsController extends BaseController
{

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

                if ($file->getError() == UPLOAD_ERR_OK) {
                    $fileName = $file->getClientFilename();
                    $file->moveTo("uploads/$fileName");

                }
                $job = new Job();
                $job->title = $postData['title'];
                $job->description = $postData['description'];
                $job->file = $fileName;
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
