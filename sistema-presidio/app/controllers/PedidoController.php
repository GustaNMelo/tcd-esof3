<?php
class PedidoController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('login');
        }
    }

    public function checkout() {
        // Verifica se carrinho está vazio
        if (empty($_SESSION['carrinho'])) {
            $this->redirect('home');
        }

        // Prepara os dados
        $productModel = $this->model('Product');
        $itensParaSalvar = [];
        $total = 0;

        foreach ($_SESSION['carrinho'] as $id => $qtd) {
            $produto = $productModel->findById($id);
            if ($produto) {
                $produto->qtd_carrinho = $qtd;
                $produto->subtotal = $produto->preco * $qtd;
                $total += $produto->subtotal;
                $itensParaSalvar[] = $produto;
            }
        }

        // Instancia o Model de Pedido
        $pedidoModel = $this->model('Pedido');
        
        // Descobre quem é o preso desse familiar
        $preso_id = $pedidoModel->getPresoId($_SESSION['user_id']);

        if (!$preso_id) {
            die("Erro crítico: Nenhum preso vinculado a este usuário.");
        }

        // Tenta Salvar
        $pedidoCriadoId = $pedidoModel->criarPedido($_SESSION['user_id'], $preso_id, $total, $itensParaSalvar);

        if ($pedidoCriadoId) {
            // SUCESSO!
            // 1. Limpa o carrinho
            unset($_SESSION['carrinho']);
            
            // 2. Manda para a tela de Pagamento/Sucesso
            $dados = [
                'pedido_id' => $pedidoCriadoId,
                'total' => $total
            ];
            $this->view('pedido/sucesso', $dados);
        } else {
            die("Erro ao salvar pedido no banco de dados.");
        }
    }

    public function historico() {
        $pedidoModel = $this->model('Pedido');
        $pedidos = $pedidoModel->getPedidosPorUsuario($_SESSION['user_id']);
        
        $dados = [
            'pedidos' => $pedidos
        ];
        
        $this->view('pedido/historico', $dados);
    }
}
