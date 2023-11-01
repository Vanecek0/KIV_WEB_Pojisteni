<?php

namespace App\Controllers;

use App\Core\FlashMessage;
use App\Core\Request;
use App\Core\Session;
use App\DTO\LoginFormDTO;
use App\DTO\RegisterFormDTO;
use App\Interfaces\IController;
use App\Models\User as UserModel;
use Twig\Environment;

class Auth implements IController
{

    private Environment $twig;
    private UserModel $usermodel;
    private Session $session;
    private FlashMessage $flashmessage;

    public function __construct(Environment $twig)
    {
        $this->twig = $twig;
        $this->usermodel = new UserModel();
        $this->session = Session::getInstance();
        $this->flashmessage = new FlashMessage();
    }

    public function index()
    {
        return $this->twig->render('Login/index.twig', [
            'username_message' => $this->flashmessage->getFlashMessage("username_message"),
            'password_message' => $this->flashmessage->getFlashMessage("password_message"),
            'general_message' => $this->flashmessage->getFlashMessage("general_message")
        ]);
    }

    public function signUpPage()
    {
        return $this->twig->render('Register/index.twig');
    }

    public function register(Request $request)
    {
        if (!$request->isPost()) {
            $request->redirect('/login');
            return false;
        }

        $username = $request->getBody()['username'];
        $password = $request->getBody()['password'];
        $firstname = $request->getBody()['firstname'];
        $lastname = $request->getBody()['lastname'];
        $birth = $request->getBody()['birth'];
        $address = $request->getBody()['address'];
        $gdpr = $request->getBody()['gdpr'];
        $terms = $request->getBody()['terms'];

        $registerFormDTO = new RegisterFormDTO($firstname, $lastname, $birth, $address, $gdpr, $terms, $username, $password);

        if (!$this->handleRegister($registerFormDTO)) {
            return false;
        }

        return true;
    }

    private function handleRegister(RegisterFormDTO $registerFormDTO)
    {
        return false;
    }


    public function credentialLogin(Request $request)
    {

        if (!$request->isPost()) {
            $request->redirect('/login');
            return false;
        }

        $username = $request->getBody()['username'];
        $password = $request->getBody()['password'];

        $loginFormDTO = new LoginFormDTO($username, $password);

        if (!$this->handleLogin($loginFormDTO)) {
            return false;
        }

        return true;
    }

    private function handleLogin(LoginFormDTO $loginFormDTO)
    {
        $username = $loginFormDTO->username;
        $password = $loginFormDTO->password;

        $dbUser = $this->usermodel->getByUsername($username);

        if (!$dbUser) {
            $this->flashmessage->setFlashMessage("username_message", "Uživatel nenalezen!");
            return false;
        }

        if (!password_verify($password, $dbUser->password)) {
            $this->flashmessage->setFlashMessage("password_message", "Chybně zadné heslo!");
            return false;
        }

        $this->session->set('user', json_encode($this->usermodel));
        return true;
    }

    public function logout(Request $request)
    {
        if (!$this->handleLogout()) {
            return false;
        }

        $request->redirect('/login');
        return true;
    }

    private function handleLogout()
    {
        $this->flashmessage->setFlashMessage("general_message", "Uživatel úspěšně odhlášen");

        $this->session->remove('user');
        return true;
    }
}
