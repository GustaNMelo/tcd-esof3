<?php
class LoginController extends Controller {
    
    // Mostra a tela de login
    public function index() {
        // Se já estiver logado, manda pro painel
        if (isset($_SESSION['user_id'])) {
            $this->redirect('home/index');
        }

        $dados = [
            'erro' => ''
        ];
        
        $this->view('auth/login', $dados);
    }

    // Processa o Login
    public function entrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $email = trim($_POST['email']);
            $senha = trim($_POST['senha']);
            
            $userModel = $this->model('User');
            $usuarioLogado = $userModel->login($email, $senha);
            
            if ($usuarioLogado) {
                $_SESSION['user_id'] = $usuarioLogado->id;
                $_SESSION['user_nome'] = $usuarioLogado->nome;
                $_SESSION['user_tipo'] = $usuarioLogado->tipo;

                if ($usuarioLogado->tipo == 'administrador') {
                     // Por enquanto manda pra home, pois ainda não fizemos dashboard
                     $this->redirect('home/index'); 
                } else {
                     $this->redirect('home/index');
                }
            } else {
                $dados = [
                    'erro' => 'Email ou senha incorretos.'
                ];
                $this->view('auth/login', $dados);
            }
        } else {
            $this->redirect('login/index');
        }
    }

    // Exibir formulário de cadastro
    public function cadastro() {
        $dados = [
            'nome' => '',
            'email' => '',
            'erro' => ''
        ];
        $this->view('auth/cadastro', $dados);
    }

    // Processar o cadastro
    public function registrar() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
            $dados = [
                'nome' => trim($_POST['nome']),
                'email' => trim($_POST['email']),
                'senha' => trim($_POST['senha']), 
                'cpf' => trim($_POST['cpf']),
                'telefone' => trim($_POST['telefone']),
                
                // Dados Preso
                'nome_preso' => trim($_POST['nome_preso']),
                'infopen' => trim($_POST['infopen']),
                'locInterna' => trim($_POST['pavilhao']),
                'cela' => isset($_POST['cela']) ? trim($_POST['cela']) : '', 
                
                'erro' => ''
            ];

            // Verificação básica
            if(empty($dados['email']) || empty($dados['senha'])) {
                 $dados['erro'] = 'Preencha todos os campos.';
                 $this->view('auth/cadastro', $dados);
                 return;
            }

            $userModel = $this->model('User');

            if ($userModel->findUserByEmail($dados['email'])) {
                $dados['erro'] = 'Este email já está cadastrado.';
                $this->view('auth/cadastro', $dados);
            } else {
                if ($userModel->register($dados)) {
                    $this->redirect('login/index');
                } else {
                    die('Erro fatal ao cadastrar no banco.');
                }
            }
        } else {
            $this->cadastro();
        }
    }

    public function sair() {
        session_destroy();
        $this->redirect('login/index');
    }
}
