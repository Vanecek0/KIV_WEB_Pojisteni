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

    public function logInPage() {
        return $this->twig->render('Login/index.twig');
    }

    public function signUpPage() {
        return $this->twig->render('Register/index.twig');
    }

    public function register(Request $request)
    {
        if (!$request->isPost()) {
            $request->redirect('/register');
            return false;
        }

        $firstname = $request->getBody()['firstname'];
        $lastname = $request->getBody()['lastname'];
        $birth = $request->getBody()['birth'];
        $birth_number = $request->getBody()['birth_number'];
        $email = $request->getBody()['email'];
        $phone = $request->getBody()['phone'];
        $city = $request->getBody()['city'];
        $street = $request->getBody()['street'];
        $psc = $request->getBody()['psc'];
        $username = $request->getBody()['username'];
        $password = $request->getBody()['password'];

        $registerFormDTO = new RegisterFormDTO(
            $firstname, 
            $lastname, 
            $phone, 
            $email, 
            $birth, 
            $birth_number, 
            $city,
            $street,
            $psc, 
            $username, 
            $password
        );


        if (!$this->handleRegister($registerFormDTO)) {
            return false;
        }

        return $this->handleRegister($registerFormDTO);
    }

    private function handleRegister(RegisterFormDTO $registerFormDTO)
    {
        $firstname = $registerFormDTO->firstname;
        $lastname = $registerFormDTO->lastname;
        $phone = $registerFormDTO->phone;
        $email = $registerFormDTO->email;
        $birth = $registerFormDTO->birth;
        $birth_number = $registerFormDTO->birth_number;
        $city = $registerFormDTO->city;
        $street = $registerFormDTO->street;
        $psc = $registerFormDTO->psc;
        $username = $registerFormDTO->username;
        $password = password_hash($registerFormDTO->password, PASSWORD_BCRYPT);

        if($this->usermodel->getByUsername($username) != null) {
            $this->flashmessage->setFlashMessage("register_error", "Uživatelské jméno již existuje, zvolte prosím jiné");
            echo $this->flashmessage->getMessagesArray();
            return false;
        }

        $insertUser = $this->usermodel->create([
            'firstname' => $firstname,
            'lastname' => $lastname,
            'phone' => $phone,
            'email' => $email,
            'birth' => $birth,
            'birth_number' => $birth_number,
            'city' => $city,
            'street' => $street,
            'psc' => $psc,
            'username' => $username,
            'password' => $password
        ]);
        
        if(!$insertUser) {
            $this->flashmessage->setFlashMessage("register_error", "Účet nemohl být vytvořen");
            echo $this->flashmessage->getMessagesArray();
            return false;
        }

        $this->flashmessage->setFlashMessage("register_message", "Váš účet byl úspěšně vytvořen");
        return $this->flashmessage->getMessagesArray();
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

        if ($dbUser == null) {
            $this->flashmessage->setFlashMessage("login_error", "Uživatel nenalezen!");
            echo $this->flashmessage->getMessagesArray();
            return false;
        }

        if (!password_verify($password, $dbUser->password)) {
            $this->flashmessage->setFlashMessage("login_error", "Chybně zadané heslo!");
            echo $this->flashmessage->getMessagesArray();
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
        $this->session->remove('user');
        return true;
    }
}