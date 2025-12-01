<?php
// Iniciar Sessão para Login/Carrinho
session_start();

// Configuração básica de erros (para debug)
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Autoload simples (para carregar classes automaticamente)
spl_autoload_register(function ($class_name) {
    // Procura nas pastas app/core, app/controllers, app/models
    $dirs = ['../app/core/', '../app/controllers/', '../app/models/'];
    foreach ($dirs as $dir) {
        if (file_exists($dir . $class_name . '.php')) {
            require_once $dir . $class_name . '.php';
            return;
        }
    }
});

// Roteamento Simples (Baseado na URL)
// Ex: index.php?url=produto/listar
$url = isset($_GET['url']) ? $_GET['url'] : 'home/index';
$url = rtrim($url, '/');
$url = explode('/', $url);

// Define Controller (Padrão: HomeController)
$controllerName = isset($url[0]) ? ucfirst($url[0]) . 'Controller' : 'HomeController';
$methodName = isset($url[1]) ? $url[1] : 'index';
$params = array_slice($url, 2);

// Verifica se arquivo do controller existe
if (file_exists('../app/controllers/' . $controllerName . '.php')) {
    $controller = new $controllerName;
    
    // Verifica se método existe
    if (method_exists($controller, $methodName)) {
        call_user_func_array([$controller, $methodName], $params);
    } else {
        echo "Método não encontrado: $methodName";
    }
} else {
    // Se não achar o controller, redireciona para Login ou 404
    // Vamos redirecionar para LoginController se não achar
    require_once '../app/controllers/LoginController.php';
    $login = new LoginController();
    $login->index();
}
