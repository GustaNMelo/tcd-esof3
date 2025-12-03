<?php require_once '../app/views/layouts/header.php'; ?>

<div class="container mt-5 mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success"><i class="fas fa-box"></i> Gerenciar Produtos</h2>
        
        <div>
            <a href="/sistema-presidio/public/admin/dashboard" class="btn btn-outline-secondary me-2">Voltar</a>
            <a href="/sistema-presidio/public/adminProdutos/formulario" class="btn btn-success">
                <i class="fas fa-plus"></i> Novo Produto
            </a>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-striped table-hover mb-0 align-middle">
                    <thead class="bg-dark text-white">
                        <tr>
                            <th>ID</th>
                            <th>Imagem</th>
                            <th>Nome</th>
                            <th>Categoria</th>
                            <th>Preço</th>
                            <th class="text-end">Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['produtos'] as $prod): ?>
                        <tr>
                            <td><?= $prod->id ?></td>
                            <td>
                                <?php $img = $prod->imagem ? $prod->imagem : 'default.jpg'; ?>
                                <img src="/sistema-presidio/public/img/<?= $img ?>" width="40">
                            </td>
                            <td><?= $prod->nome ?></td>
                            <td><span class="badge bg-secondary"><?= $prod->nome_categoria ?></span></td>
                            <td>R$ <?= number_format($prod->preco, 2, ',', '.') ?></td>
                            <td class="text-end">
                                <a href="/sistema-presidio/public/adminProdutos/formulario/<?= $prod->id ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="/sistema-presidio/public/adminProdutos/deletar/<?= $prod->id ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Excluir este produto?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
