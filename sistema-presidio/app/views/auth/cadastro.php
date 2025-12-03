<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Supermercado Penitenciária</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/sistema-presidio/public/css/style.css">
    <style>
        body { background-color: #f8f9fa; }
        .card-cadastro { max-width: 800px; margin: 40px auto; }
        .header-verde { background-color: #009639; color: white; padding: 15px; border-radius: 5px 5px 0 0; }
    </style>
</head>
<body>

    <div class="container">
        <div class="card card-cadastro shadow">
            <div class="header-verde text-center">
                <h3>Criar Nova Conta</h3>
                <small>Preencha os dados do familiar e do detento</small>
            </div>
            
            <div class="card-body p-4">
                
                <?php if(!empty($data['erro'])): ?>
                    <div class="alert alert-danger"><?= $data['erro']; ?></div>
                <?php endif; ?>

                <form action="/sistema-presidio/public/login/registrar" method="POST">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <h5 class="text-success border-bottom pb-2">👤 Dados do Familiar</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Nome Completo</label>
                                <input type="text" name="nome" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">CPF</label>
                                <input type="text" name="cpf" class="form-control" placeholder="000.000.000-00" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Telefone / WhatsApp</label>
                                <input type="text" name="telefone" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Email (Login)</label>
                                <input type="email" name="email" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Senha</label>
                                <input type="password" name="senha" class="form-control" required>
                            </div>
                        </div>

                        <div class="col-md-6 mb-3">
                            <h5 class="text-success border-bottom pb-2">🔒 Dados do Preso</h5>
                            
                            <div class="mb-3">
                                <label class="form-label">Nome do Preso</label>
                                <input type="text" name="nome_preso" class="form-control" required>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">INFOPEN (Matrícula)</label>
                                <input type="text" name="infopen" class="form-control" placeholder="Ex: 2025-MG-123" required>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-7 mb-3">
                                    <label class="form-label">Pavilhão / Ala</label>
                                    <select name="pavilhao" class="form-select" required>
                                        <option value="">Selecione...</option>
                                        <option value="Pavilhão 1">Pavilhão 1</option>
                                        <option value="Pavilhão 2">Pavilhão 2</option>
                                        <option value="Pavilhão 3">Pavilhão 3</option>
                                        <option value="Pavilhão 4">Pavilhão 4</option>
                                        <option value="Ala A">Ala A</option>
                                        <option value="Ala B">Ala B</option>
                                        <option value="Ala C">Ala C</option>
                                        <option value="Ala D">Ala D</option>
                                        <option value="Ala E">Ala E</option>
                                    </select>
                                </div>
                                <div class="col-md-5 mb-3">
                                    <label class="form-label">Cela</label>
                                    <input type="text" name="cela" class="form-control" placeholder="Ex: 12" required>
                                </div>
                            </div>
                            
                            <div class="alert alert-secondary mt-2">
                                <small>⚠️ Certifique-se que a localização (Pavilhão e Cela) está correta para entrega.</small>
                            </div>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <button type="submit" class="btn btn-success btn-lg">Finalizar Cadastro</button>
                        <a href="/sistema-presidio/public/login" class="btn btn-outline-secondary">Já tenho conta</a>
                    </div>

                </form>
            </div>
        </div>
    </div>

</body>
</html>
