<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Supermercado dos Operários</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/sistema-presidio/public/css/style.css">
    <style>
        body { 
            background-color: #f8f9fa; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            min-height: 100vh; 
        }
        .card-login { 
            width: 100%; 
            max-width: 400px; 
            border: none;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }
        .login-header {
            background-color: #009639; /* Verde do seu CSS */
            color: white;
            padding: 20px;
            text-align: center;
            border-radius: 5px 5px 0 0;
        }
        .login-header img {
            height: 50px; /* Ajuste conforme seu logo */
            margin-bottom: 10px;
        }
        .btn-login {
            background-color: #009639;
            color: white;
            font-weight: bold;
        }
        .btn-login:hover {
            background-color: #007a2e;
            color: white;
        }
    </style>
</head>
<body>

    <div class="card card-login">
        <div class="login-header">
            <h4 class="m-0">Acesso ao Sistema</h4>
        </div>
        
        <div class="card-body p-4">
            
            <?php if(!empty($data['erro'])): ?>
                <div class="alert alert-danger text-center">
                    <?= $data['erro']; ?>
                </div>
            <?php endif; ?>

            <form action="/sistema-presidio/public/login/entrar" method="POST">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="seu@email.com" required>
                </div>
                
                <div class="mb-3">
                    <label for="senha" class="form-label">Senha</label>
                    <input type="password" name="senha" class="form-control" placeholder="Sua senha" required>
                </div>
                
                <div class="d-grid gap-2 mt-4">
                    <button type="submit" class="btn btn-login btn-lg">Entrar</button>
                </div>
            </form>
            
            <hr class="my-4">
            
            <div class="text-center">
                <p class="text-muted small">Não tem conta?</p>
                <a href="/sistema-presidio/public/login/cadastro" class="text-success fw-bold text-decoration-none">Criar conta Familiar</a>
                <div class="mt-3">
                    <a href="/sistema-presidio/public/home" class="text-secondary small text-decoration-none">← Voltar para a Loja</a>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
