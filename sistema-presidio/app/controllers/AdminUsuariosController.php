<?php
class AdminUsuariosController extends Controller {

    public function __construct() {
        // SEGURANÇA MÁXIMA: Só Administrador entra aqui.
        // Se for Atendente ou Cliente, é expulso.
        if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] != 'administrador') {
            die("Acesso Negado. Apenas Administradores.");
        }
    }

    public function index() {
        $userModel = $this->model('User');
        $usuarios = $userModel->getTodos();

        $dados = [
            'usuarios' => $usuarios
        ];

        $this->view('admin/usuarios', $dados);
    }

    public function deletar($id) {
        $userModel = $this->model('User');
        
        // Evita que o admin se delete
        if ($id == $_SESSION['user_id']) {
            die("Você não pode se excluir!");
        }

        $userModel->deletar($id);
        $this->redirect('adminUsuarios/index');
    }
}
