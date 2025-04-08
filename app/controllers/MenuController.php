<?php 
require_once __DIR__.'/../helpers/auth.php';

class MenuController extends Controller {
    public function index() {
        requireLogin();
        $this->view("menu");
    }
}