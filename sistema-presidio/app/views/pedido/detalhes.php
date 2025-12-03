<?php require_once '../app/views/layouts/header.php'; ?>

<div class="container mt-4 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-success"><i class="fas fa-receipt"></i> Pedido #<?= $data['pedido']->id ?></h2>
        <a href="/sistema-presidio/public/pedido/historico" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
    </div>

    <div class="alert alert-info d-flex justify-content-between align-items-center">
        <span>Status atual do pedido:</span>
        <span class="badge bg-primary fs-6"><?= $data['pedido']->status ?></span>
    </div>

    <div class="row mb-4">
        <div class="col-md-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <strong>Enviado para:</strong>
                </div>
                <div class="card-body">
                    <h5 class="card-title"><?= $data['pedido']->nome_preso ?></h5>
                    <p class="mb-1 text-muted">INFOPEN: <?= $data['pedido']->infopen ?></p>
                    <p class="mb-0 text-muted">Local: <?= $data['pedido']->locInterna ?> - Cela: <?= $data['pedido']->cela ?></p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-success text-white">
            Itens do Pedido
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 60%">Produto</th>
                        <th style="width: 20%" class="text-center">Qtd</th>
                        <th style="width: 20%" class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['itens'] as $item): ?>
                    <tr>
                        <td>
                            <strong><?= $item->nome ?></strong><br>
                            <small class="text-muted"><?= $item->descricao ?></small>
                        </td>
                        <td class="text-center"><?= $item->quantidade ?></td>
                        <td class="text-end fw-bold">R$ <?= number_format($item->subtotal, 2, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="table-dark">
                    <tr>
                        <td colspan="2" class="text-end pe-4">TOTAL PAGO:</td>
                        <td class="text-end fs-5">R$ <?= number_format($data['pedido']->valorTotal, 2, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
    
    <div class="text-center mt-4 text-muted small">
        <p>O Supermercado dos Operários agradece a preferência.</p>
    </div>

</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
