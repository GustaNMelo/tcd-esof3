<?php
class AdminProdutosController extends Controller {

    public function __construct() {
        if (!isset($_SESSION['user_tipo']) || $_SESSION['user_tipo'] != 'administrador') {
            die("Acesso Negado.");
        }
    }

    // Listar Produtos
    public function index() {
        $prodModel = $this->model('Product');
        $produtos = $prodModel->getAll(); // Já existe esse método
        
        $this->view('admin/produtos/index', ['produtos' => $produtos]);
    }

    // Formulário de Cadastro/Edição
    public function formulario($id = null) {
        $prodModel = $this->model('Product');
        $categorias = $prodModel->getCategorias();
        $produto = null;

        if ($id) {
            $produto = $prodModel->findById($id);
        }

        $dados = [
            'categorias' => $categorias,
            'produto' => $produto
        ];

        $this->view('admin/produtos/formulario', $dados);
    }

    // Salvar (Insert ou Update)
    public function salvar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $prodModel = $this->model('Product');

            // Prepara os dados básicos
            $dados = [
                'id' => $_POST['id'], 
                'nome' => trim($_POST['nome']),
                'categoria_id' => $_POST['categoria_id'],
                'preco' => str_replace(',', '.', $_POST['preco']),
                'descricao' => trim($_POST['descricao']),
                'imagem' => $_POST['imagem_atual'] // Começa assumindo que mantém a imagem velha
            ];

            // --- LÓGICA DE UPLOAD ---
            // Verifica se um arquivo foi enviado e se não deu erro
            if (isset($_FILES['imagem_arquivo']) && $_FILES['imagem_arquivo']['error'] === 0) {
                
                // 1. Pega a extensão (jpg, png)
                $ext = pathinfo($_FILES['imagem_arquivo']['name'], PATHINFO_EXTENSION);
                
                // 2. Cria um nome único (ex: produto_123456.jpg) para não substituir outros
                $novoNome = "produto_" . time() . "." . $ext;
                
                // 3. Define onde salvar (caminho absoluto do servidor)
                $diretorioDestino = __DIR__ . '/../../public/img/';
                
                // 4. Move o arquivo temporário para a pasta final
                if (move_uploaded_file($_FILES['imagem_arquivo']['tmp_name'], $diretorioDestino . $novoNome)) {
                    // Se deu certo, atualiza o nome no banco
                    $dados['imagem'] = $novoNome;
                }
            }
            // ------------------------

            if ($dados['id']) {
                $prodModel->atualizar($dados);
            } else {
                $prodModel->salvar($dados);
            }

            $this->redirect('adminProdutos/index');
        }
    }

    // Excluir
    public function deletar($id) {
        $prodModel = $this->model('Product');
        $prodModel->deletar($id);
        $this->redirect('adminProdutos/index');
    }
}
