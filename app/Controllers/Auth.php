<?php

namespace App\Controllers;

use App\Core\Application;
use App\Core\FlashMessage;
use App\Core\Request;
use App\Core\Session;
use App\Interfaces\IController;
use App\Models\User as UserModel;
use Twig\Environment;

class Auth implements IController
{

    private Environment $twig;
    private UserModel $usermodel;
    private Session $session;
    private FlashMessage $flashMessage;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->usermodel = new UserModel();
        $this->session = Session::getInstance();
        $this->flashMessage = new FlashMessage();
    }

    public function index()
    {
        if ($this->isLoggedIn()) {
            Application::$app->request->redirect("/");
        }
        return $this->twig->render('Login/index.twig', [
            'username_message' => $this->flashMessage->getFlashMessage("username_message"),
            'password_message' => $this->flashMessage->getFlashMessage("password_message")
        ]);
    }

    public function signUpPage() {
        return null;
    }

    public function handleRegister(Request $request) {
        return null;
    }

    public function handleLogin(Request $request)
    {
        if ($request->isPost()) {
            $formUsername = $request->getBody()['username'];
            $formPassword = $request->getBody()['password'];
            $dbUser = $this->usermodel->getByUsername($formUsername);

            if (!$dbUser) {
                $this->flashMessage->setFlashMessage("username_message", "Uživatel nenalezen!");
                return false;
            }

            if (!password_verify($formPassword, $dbUser->password)) {
                $this->flashMessage->setFlashMessage("password_message", "Chybně zadné heslo!");
                return false;
            }

            $this->session->set('user',  json_encode($this->usermodel));
            return true;
        }

        if ($request->isGet()) {
            if ($this->isLoggedIn()) {
                return $request->redirect('/');
            }
            return $request->redirect('/login');;
        }
    }

    public function handleLogout(Request $request)
    {
        $this->logout();
        $request->redirect('/login');
    }

    private function isLoggedIn()
    {
        return $this->session->get('user') !== false;
    }

    private function logout()
    {
        return $this->session->remove('user');
    }
}
