<?php
namespace App\Core\Middleware;

use App\Core\Application;
use App\Core\Session;

class Guest {

    private Session $session;

    public function __construct() {
        $this->session = Session::getInstance();
    }

    public function handle(string $redirect) {
        if($this->session->get('user')) {
            if($redirect == '') {
                Application::$app->request->redirect('/');
            }
            Application::$app->request->redirect($redirect);
            return false;
        }
    }

}