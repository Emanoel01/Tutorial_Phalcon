<?php

//CARREGADOR DE ARQUIVO
use Phalcon\Di\FactoryDefault;

//RESONSAVEL POR REGISTRAR  COMPONENTES AUTOMATICAMENTE PARA INJEÇÃO DE DEPENDÊNCIA
use Phalcon\Loader;

//RESPONSAVEL POR REGISTRAR AS VIEWS
use Phalcon\Mvc\View;

//RESPONSAVEL POR CRIARS URI´S
use Phalcon\Mvc\Application;

//RESPONSAVEL POR TRATAR AS REQUISICOES
use Phalcon\Url;

//RESPONSAVEL POR CRIAR CONEXAO COM BD
use Phalcon\Db\Adapter\Pdo\Mysql;

define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

//CARREGADOR DE ARQUIVOS
$loader = new Loader();

//REGISTRANDO DERETÓRIOS
$loader->registerDirs(
    [
        APP_PATH . '/controllers/',
        APP_PATH . '/models/',
    ]
);

$loader->register();

//CRIANDO INJETOR DE DEPENDENCIA
$container = new FactoryDefault();

// OBS: AS VIEWS NAO PODEM SER CARREGADAS PELO LOADER, POR ISSO SEU REGISTRO ESTÁ SEPARADO.
$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

//SETANDO A URI BASE DO PROJETO
$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

//CONECTANDO COM BD
$container->set(
    'db',
    function(){
        return new Mysql(
            [
                'host'     => '127.0.0.1',
                'username' => 'admin',
                'password' => 'bcd127',
                'dbname'   =>  'tutorial'
            ]
        );
    }
);

//INSTANCIANDO CLASSE QUE IRA TRATAR AS RREQUISICOES
$application = new Application($container);

//LIDANDO COM AS REQUISIÇOES
try {

    $response = $application->handle($_SERVER['REQUEST_URI']);

     $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
    echo "ErroLine:",$e->getLine();
}

