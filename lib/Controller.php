<?php

class Controller {
    public function view($viewName, $data = []) {
        require_once("./view/" . $viewName . ".php");
    }

    // public function model($modelName) {
    //     require_once("./model/" . $modelName . ".php");
    //     return new $modelName;
    // }
}