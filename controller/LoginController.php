<?php

class LoginController extends Controller{
    public function index() {
        $data = [];

        $this->view("login/login", $data);
    }

    public function loginProsess() {
        include_once ('./model/LoginModel.php');

        $model = new LoginModel();
        
        $res = $model->cek_valid($_POST);

        if ($res == 1) {
            $user = $model->get_user_credential($_POST['username']);

            $_SESSION['username'] = $user['username'];
            $_SESSION['password'] = $_POST['password'];
            $_SESSION['isOwner'] = $user['isOwner'];

            header("Location:" . base_url . "/home");
        }
        else {
            header("Location:" .base_url. "/login?failed=true");
        }
    }
}