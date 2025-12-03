<?php require_once '../app/views/layouts/header.php'; ?>

<div class="container-fluid my-4"> <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-danger"><i class="fas fa-cogs"></i> Painel Administrativo</h2>
        <span class="badge bg-secondary fs-6">Usuário: <?= $_SESSION['user_nome'] ?> (<?= ucfirst($_SESSION['user_tipo']) ?>)</span>
    </div>

    <div class="card shadow">
        <div class="card-header bg-dark text-white">
            Gerenciamento de Pedidos
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0 align-middle">
                    <thead class="bg-light">
                        <tr>
                            <th>ID</th>
                            <th>Data</th>
                            <th>Cliente (Familiar)</th>
                            <th>Preso (Destino)</th>
                            <th>Total</th>
                            <th>Status Atual</th>
                            <th>Alterar Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['pedidos'] as $p): ?>
                        <tr>
                            <td>
                                <a href="/sistema-presidio/public/admin/detalhes/<?= $p->id ?>" class="btn btn-outline-primary btn-sm fw-bold">
                                    #<?= $p->id ?> <i class="fas fa-eye"></i>
                                </a>
                            </td>
                            <td><?= date('d/m/Y H:i', strtotime($p->data)) ?></td>
                            <td><?= $p->nome_cliente ?></td>
                            <td><?= $p->nome_preso ?></td>
                            <td>R$ <?= number_format($p->valorTotal, 2, ',', '.') ?></td>
                            <td>
                                <span class="badge bg-secondary"><?= $p->status ?></span>
                            </td>
                            <td>
                                <form action="/sistema-presidio/public/admin/atualizarStatus" method="POST" class="d-flex gap-2">
                                    <input type="hidden" name="pedido_id" value="<?= $p->id ?>">
                                    
                                    <select name="novo_status" class="form-select form-select-sm" style="width: 130px;">
                                        <option value="Pendente" <?= $p->status=='Pendente'?'selected':'' ?>>Pendente</option>
                                        <option value="Pago" <?= $p->status=='Pago'?'selected':'' ?>>Pago</option>
                                        <option value="Em Separacao" <?= $p->status=='Em Separacao'?'selected':'' ?>>Em Separação</option>
                                        <option value="Enviado" <?= $p->status=='Enviado'?'selected':'' ?>>Enviado</option>
                                        <option value="Entregue" <?= $p->status=='Entregue'?'selected':'' ?>>Entregue</option>
                                        <option value="Cancelado" <?= $p->status=='Cancelado'?'selected':'' ?>>Cancelado</option>
                                    </select>

                                    <button type="submit" class="btn btn-primary btn-sm">
                                        <i class="fas fa-save"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<footer class="text-center py-4 text-muted mt-5">
    Sistema Admin v1.0
</footer>
</body>
</html>
