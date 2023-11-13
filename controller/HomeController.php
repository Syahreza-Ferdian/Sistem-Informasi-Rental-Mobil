<?php

class HomeController extends Controller {
    public function __construct() {
        if (!isset($_SESSION['username'])) {
            header("Location:" .base_url ."/login");
        }
    }

    public function index() {
        if (!isset($_SESSION['username'])) {
            header("Location:" .base_url ."/login");
        }
        include_once("MobilController.php");

        $c = new MobilController();

        $data['pageTitle'] = "Home";

        $this->view("templates/navbar", $data);
        $c->home_graph();
    }


}