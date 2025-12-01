<?php require_once '../app/views/layouts/header.php'; ?>

<div class="container" style="margin-top: 40px; margin-bottom: 40px;">
    <h2 class="mb-4 text-success"><i class="fas fa-shopping-cart"></i> Seu Carrinho</h2>

    <?php if (!empty($data['erro'])): ?>
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <strong>Atenção:</strong> <?= $data['erro'] ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if (empty($data['itens'])): ?>
        <div class="alert alert-secondary text-center">
            Seu carrinho está vazio. <a href="/sistema-presidio/public/home">Voltar às compras</a>
        </div>
    <?php else: ?>

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <table class="table table-hover mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th>Produto</th>
                            <th>Categoria</th>
                            <th class="text-center">Qtd</th>
                            <th class="text-end">Preço Unit.</th>
                            <th class="text-end">Subtotal</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['itens'] as $item): ?>
                        <tr>
                            <td>
                                <strong><?= $item->nome ?></strong><br>
                                <small class="text-muted"><?= $item->descricao ?></small>
                            </td>
                            <td>
                                <span class="badge bg-secondary"><?= $item->cat_nome ?></span>
                                <br><small style="font-size: 10px">Max: <?= $item->limite_maximo ?></small>
                            </td>
                            <td class="text-center align-middle">
                                <?= $item->qtd_carrinho ?>
                            </td>
                            <td class="text-end align-middle">R$ <?= number_format($item->preco, 2, ',', '.') ?></td>
                            <td class="text-end align-middle fw-bold">R$ <?= number_format($item->subtotal, 2, ',', '.') ?></td>
                            <td class="text-end align-middle">
                                <a href="/sistema-presidio/public/carrinho/remover/<?= $item->id ?>" class="btn btn-sm btn-outline-danger">
                                    <i class="fas fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="4" class="text-end fs-5"><strong>Total do Pedido:</strong></td>
                            <td class="text-end fs-5 text-success fw-bold">R$ <?= number_format($data['total'], 2, ',', '.') ?></td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>

        <div class="d-flex justify-content-between mt-4">
            <a href="/sistema-presidio/public/home" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Continuar Comprando
            </a>
            
            <div class="d-flex gap-2">
                <a href="/sistema-presidio/public/carrinho/limpar" class="btn btn-outline-danger">
                    Limpar Carrinho
                </a>
                <a href="/sistema-presidio/public/pedido/checkout" class="btn btn-success btn-lg">
                    Finalizar Pedido <i class="fas fa-check"></i>
                </a>
            </div>
        </div>

    <?php endif; ?>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
