<?php
class AdminController extends Controller {

    public function __construct() {
        // Só deixa entrar se não for cliente
        if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] == 'cliente') {
            die("Acesso Negado. Apenas funcionários.");
        }
    }

    public function dashboard() {
        $pedidoModel = $this->model('Pedido');
        $pedidos = $pedidoModel->getTodosPedidos();

        $dados = [
            'pedidos' => $pedidos
        ];

        $this->view('admin/dashboard', $dados);
    }

    // Ação para mudar o status via formulário
    public function atualizarStatus() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['pedido_id'];
            $status = $_POST['novo_status'];

            $pedidoModel = $this->model('Pedido');
            $pedidoModel->atualizarStatus($id, $status);

            // Volta para o painel
            $this->redirect('admin/dashboard');
        }
    }

    public function detalhes($id) {
        $pedidoModel = $this->model('Pedido');
        
        // 1. Busca informações gerais
        $pedido = $pedidoModel->getPedidoPorId($id);
        
        // 2. Busca os produtos
        $itens = $pedidoModel->getItensDoPedido($id);

        if (!$pedido) {
            die("Pedido não encontrado.");
        }

        $dados = [
            'pedido' => $pedido,
            'itens' => $itens
        ];

        $this->view('admin/detalhes_pedido', $dados);
    }
}
