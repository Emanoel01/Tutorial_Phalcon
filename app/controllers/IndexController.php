<?php

use Phalcon\Mvc\Controller;

class IndexController extends Controller{
    public function indexAction(){
        
        //LISTANDO USUARIOS BD
        $this->view->users = Users::find();

    }
}