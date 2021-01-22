<?php 

use Phalcon\Mvc\Controller;

class SignupController extends Controller{
    public function indexAction(){


    }

    //CRIACAO DE USUARIO
    public function registerAction(){

        $user = new Users();

        //SETANDO OS ATRIBUTOS
        $user->assign(
            $this->request->getPost(),
            [
                'name',
                'email'
            ]
        );

        //SALVANDO NO BD
        $success = $user->save();

        //PASSANDO O RESULTADO PARA NOSSA VIEW
        $this->view->success = $success;

        if($success){
            $message = "SALVO COM SUCESSO";
        }else{
            $message = "NÃO FOI POSSÍVEL ADICIONAR UM NOVO USUARIO: <br>"
            .implode('<br>',$user->getMessages());
        }

        //PASSANDO A MENSAGEM PARA A VIEW
        $this->view->message = $message;


    }
}