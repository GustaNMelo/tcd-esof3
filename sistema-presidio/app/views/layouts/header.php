<!DOCTYPE html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Supermercado dos Operários</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/sistema-presidio/public/css/style.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
  <header class="header">
        <a href="/sistema-presidio/public/home">
            <img class="logo" src="/sistema-presidio/public/img/logo.png" alt="Logo da Empresa">
        </a>

        <div class="search-box">
            <input type="text" placeholder="Pesquisar produto...">
            <i class="fas fa-search"></i>
        </div>

        <nav>
            <a href="/sistema-presidio/public/home">
                <i class="fas fa-home"></i> Início
            </a>

            <?php if (isset($_SESSION['user_id'])): ?>

                <?php if ($_SESSION['user_tipo'] == 'administrador' || $_SESSION['user_tipo'] == 'atendente'): ?>
                    
                    <a href="/sistema-presidio/public/admin/dashboard" class="text-dark fw-bold">
                        <i class="fas fa-clipboard-list"></i> Pedidos
                    </a>

                    <?php if ($_SESSION['user_tipo'] == 'administrador'): ?>
                        <a href="/sistema-presidio/public/adminUsuarios/index" class="text-primary fw-bold">
                            <i class="fas fa-users"></i> Usuários
                        </a>
                        <a href="/sistema-presidio/public/adminProdutos/index" class="text-success fw-bold">
                            <i class="fas fa-box"></i> Produtos
                        </a>
                    <?php endif; ?>

                    <span class="ms-3 text-muted">|</span>

                <?php else: ?>
                    
                    <a href="/sistema-presidio/public/carrinho">
                        <i class="fas fa-shopping-cart"></i> Carrinho
                    </a>
                    
                    <a href="/sistema-presidio/public/pedido/historico">
                        <i class="fas fa-list"></i> Meus Pedidos
                    </a>

                <?php endif; ?>

                <a href="#" class="ms-3">
                    <i class="fas fa-user"></i> Olá, <?= explode(' ', $_SESSION['user_nome'])[0]; ?>
                </a>

                <a href="/sistema-presidio/public/login/sair" style="color: #ffcccc;">
                    <i class="fas fa-sign-out-alt"></i> Sair
                </a>

            <?php else: ?>
                
                <a href="#">
                    <i class="fas fa-question-circle"></i> Como Comprar?
                </a>
                <a href="/sistema-presidio/public/login">
                    <i class="fas fa-sign-in-alt"></i> Entrar
                </a>
                <a href="/sistema-presidio/public/login/cadastro">
                    <i class="fas fa-user-plus"></i> Cadastro
                </a>

            <?php endif; ?>
        </nav>
    </header>
