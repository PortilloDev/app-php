<?php

namespace App\Controllers;

use App\Models\Users;
use Respect\Validation\Validator as v;

class UsersController extends BaseController
{

    public function getIndexUser()
    {
        //carga la vista addJob
        return $this->renderHTML('registerUser.twig');
    }

    public function postAddUser($request)
    {
        $responseMessage = "";

        if ($request->getMethod() == 'POST') {

            $postData = $request->getParsedBody();

           
           /* $userValidator = v::key('email', v::email()->validate($postData['email']))
                ->key('username', v::stringType()->notEmpty());*/

            try {
                //$userValidator->assert($postData);

                
                $user = new Users();
                $user->username = $postData['username'];
                $user->email = $postData['email'];
                $user->password = password_hash($postData['password'], PASSWORD_DEFAULT);
                $user->save();
                $responseMessage = 'Saved';
            } catch (\Exception $e) {
                $responseMessage = $e->getMessage();
            }
        }

        //carga la vista addJob
        return $this->renderHTML('registerUser.twig', [
            'responseMessage' => $responseMessage
        ]);
    }
}