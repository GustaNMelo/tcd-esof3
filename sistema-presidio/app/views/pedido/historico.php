<?php require_once '../app/views/layouts/header.php'; ?>

<div class="container my-5">
    <h2 class="mb-4 text-success"><i class="fas fa-list"></i> Meus Pedidos</h2>

    <?php if (empty($data['pedidos'])): ?>
        <div class="alert alert-info">Você ainda não realizou nenhum pedido.</div>
    <?php else: ?>
        <div class="card shadow-sm">
            <table class="table table-hover mb-0">
                <thead class="table-light">
                    <tr>
                        <th># Pedido</th>
                        <th>Data</th>
                        <th>Valor Total</th>
                        <th>Status</th>
                        <th>Ação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['pedidos'] as $pedido): ?>
                    <tr>
                        <td>#<?= $pedido->id ?></td>
                        <td><?= date('d/m/Y H:i', strtotime($pedido->data)) ?></td>
                        <td class="fw-bold">R$ <?= number_format($pedido->valorTotal, 2, ',', '.') ?></td>
                        <td>
                            <?php 
                                $cor = 'secondary';
                                if($pedido->status == 'Pendente') $cor = 'warning';
                                if($pedido->status == 'Pago') $cor = 'info';
                                if($pedido->status == 'Enviado') $cor = 'primary';
                                if($pedido->status == 'Entregue') $cor = 'success';
                            ?>
                            <span class="badge bg-<?= $cor ?>"><?= $pedido->status ?></span>
                        </td>
                        <td>
                            <a href="/sistema-presidio/public/pedido/detalhes/<?= $pedido->id ?>" class="btn btn-sm btn-outline-primary">
                                <i class="fas fa-eye"></i> Ver Detalhes
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endif; ?>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
