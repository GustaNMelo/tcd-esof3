<?php
class Controller {
    // Carregar Model
    public function model($model) {
        require_once '../app/models/' . $model . '.php';
        return new $model();
    }

    // Carregar View (passando dados)
    public function view($view, $data = []) {
        if (file_exists('../app/views/' . $view . '.php')) {
            require_once '../app/views/' . $view . '.php';
        } else {
            die("View não encontrada: " . $view);
        }
    }
    
    // Redirecionamento auxiliar
    public function redirect($url) {
        header("Location: /sistema-presidio/public/" . $url);
        exit();
    }
}
