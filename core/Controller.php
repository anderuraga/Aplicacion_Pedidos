<?php
class Controller {
    public function view($view, $data = []) {
        extract($data);
        require_once __DIR__ ."/../app/views/$view.php";
    }

    public function model($model) {
        require_once __DIR__ ."/../app/models/vo/$model.php";
        return new $model;
    }

    public function dao($dao) {
        $dao .= "DAO";
        require_once __DIR__ ."/../app/models/daos/$dao.php";
        return new $dao;
    }
}