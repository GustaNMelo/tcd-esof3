<?php
class CarrinhoController extends Controller {

    public function __construct() {
        // Só aceita mexer no carrinho se estiver logado
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('login');
        }
        
        // Inicia o carrinho se não existir
        if (!isset($_SESSION['carrinho'])) {
            $_SESSION['carrinho'] = [];
        }
    }

    public function index() {
        $productModel = $this->model('Product');
        $itensCarrinho = [];
        $total = 0;

        foreach ($_SESSION['carrinho'] as $id => $qtd) {
            $produto = $productModel->findById($id);
            if ($produto) {
                $produto->qtd_carrinho = $qtd;
                $produto->subtotal = $produto->preco * $qtd;
                $total += $produto->subtotal;
                $itensCarrinho[] = $produto;
            }
        }

        $dados = [
            'itens' => $itensCarrinho,
            'total' => $total,
            'erro'  => isset($_SESSION['erro_carrinho']) ? $_SESSION['erro_carrinho'] : ''
        ];

        unset($_SESSION['erro_carrinho']);

        // ATENÇÃO: A pasta da view continua sendo 'cart' se você criou assim,
        // mas se preferir, renomeie a pasta views/cart para views/carrinho
        // Vou manter 'cart' aqui para não te dar trabalho de renomear pasta.
        $this->view('cart/index', $dados);
    }

    public function adicionar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['produto_id'];
            $productModel = $this->model('Product');
            $produto = $productModel->findById($id);

            if ($produto) {
                // 1. Verifica Quantidade Atual
                $qtdAtual = isset($_SESSION['carrinho'][$id]) ? $_SESSION['carrinho'][$id] : 0;
                $novaQtd = $qtdAtual + 1;

                // 2. VERIFICAÇÃO DE CATEGORIA
                $qtdTotalCategoria = 0;
                
                foreach ($_SESSION['carrinho'] as $idProd => $q) {
                    $prodCheck = $productModel->findById($idProd);
                    // Verifica se é da mesma categoria (e ignora se o produto falhar)
                    if ($prodCheck && $prodCheck->cat_id == $produto->cat_id) {
                        $qtdTotalCategoria += $q;
                    }
                }
                
                $qtdTotalCategoria += 1; // O que estamos adicionando agora

                if ($qtdTotalCategoria > $produto->limite_maximo) {
                    $_SESSION['erro_carrinho'] = "Limite atingido! A categoria '{$produto->cat_nome}' permite apenas {$produto->limite_maximo} itens.";
                    // Redireciona para /carrinho
                    $this->redirect('carrinho'); 
                } else {
                    $_SESSION['carrinho'][$id] = $novaQtd;
                    $this->redirect('carrinho');
                }
            }
        }
    }

    public function remover($id) {
        // Pega o ID da URL (ex: /carrinho/remover/1)
        // O $id já vem como parâmetro da função graças ao Core/App
        if (isset($_SESSION['carrinho'][$id])) {
            unset($_SESSION['carrinho'][$id]);
        }
        $this->redirect('carrinho');
    }

    public function limpar() {
        unset($_SESSION['carrinho']);
        $this->redirect('home');
    }
}
