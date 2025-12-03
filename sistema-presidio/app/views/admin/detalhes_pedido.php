<?php require_once '../app/views/layouts/header.php'; ?>

<div class="container mt-4 mb-5">
    
    <div class="d-flex justify-content-between align-items-center mb-4 no-print">
        <h2 class="text-primary"><i class="fas fa-file-invoice"></i> Detalhes do Pedido #<?= $data['pedido']->id ?></h2>
        <div>
            <a href="/sistema-presidio/public/admin/dashboard" class="btn btn-outline-secondary">
                <i class="fas fa-arrow-left"></i> Voltar
            </a>
            <button onclick="window.print()" class="btn btn-dark ms-2">
                <i class="fas fa-print"></i> Imprimir Ficha
            </button>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-header bg-success text-white">
                    <i class="fas fa-user"></i> Dados do Familiar (Cliente)
                </div>
                <div class="card-body">
                    <p class="mb-1"><strong>Nome:</strong> <?= $data['pedido']->nome_cliente ?></p>
                    <p class="mb-1"><strong>CPF:</strong> <?= $data['pedido']->cpf_cliente ?></p>
                    <p class="mb-1"><strong>Telefone:</strong> <?= $data['pedido']->telefone_cliente ?></p>
                    <p class="mb-0"><strong>Data do Pedido:</strong> <?= date('d/m/Y H:i', strtotime($data['pedido']->data)) ?></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card h-100 shadow-sm border-danger">
                <div class="card-header bg-danger text-white">
                    <i class="fas fa-user-lock"></i> Dados do Destinatário (Preso)
                </div>
                <div class="card-body bg-light">
                    <h5 class="card-title"><?= $data['pedido']->nome_preso ?></h5>
                    <hr>
                    <p class="mb-2"><strong>INFOPEN:</strong> <span class="badge bg-dark fs-6"><?= $data['pedido']->infopen ?></span></p>
                    
                    <p class="mb-0">
                        <strong>Localização:</strong> <?= $data['pedido']->locInterna ?> - 
                        <strong>Cela:</strong> <?= $data['pedido']->cela ?>
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="card shadow">
        <div class="card-header bg-secondary text-white d-flex justify-content-between">
            <span>Itens para Separação</span>
            <span>Status Atual: <strong><?= $data['pedido']->status ?></strong></span>
        </div>
        <div class="card-body p-0">
            <table class="table table-striped mb-0 align-middle">
                <thead class="bg-light">
                    <tr>
                        <th style="width: 10%">Qtd</th>
                        <th style="width: 50%">Produto</th>
                        <th style="width: 20%" class="text-end">Preço Unit.</th>
                        <th style="width: 20%" class="text-end">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['itens'] as $item): ?>
                    <tr>
                        <td class="text-center fw-bold fs-5"><?= $item->quantidade ?>x</td>
                        <td>
                            <?= $item->nome ?><br>
                            <small class="text-muted"><?= $item->descricao ?></small>
                        </td>
                        <td class="text-end">R$ <?= number_format($item->subtotal / $item->quantidade, 2, ',', '.') ?></td>
                        <td class="text-end fw-bold">R$ <?= number_format($item->subtotal, 2, ',', '.') ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
                <tfoot class="table-dark">
                    <tr>
                        <td colspan="3" class="text-end pe-4">VALOR TOTAL:</td>
                        <td class="text-end fs-4">R$ <?= number_format($data['pedido']->valorTotal, 2, ',', '.') ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    <div class="card mt-4 no-print">
        <div class="card-body bg-light d-flex align-items-center justify-content-between">
            <span class="text-muted">Alterar status deste pedido:</span>
            
            <form action="/sistema-presidio/public/admin/atualizarStatus" method="POST" class="d-flex gap-2">
                <input type="hidden" name="pedido_id" value="<?= $data['pedido']->id ?>">
                
                <select name="novo_status" class="form-select">
                    <option value="Pendente" <?= $data['pedido']->status=='Pendente'?'selected':'' ?>>Pendente</option>
                    <option value="Pago" <?= $data['pedido']->status=='Pago'?'selected':'' ?>>Pago</option>
                    <option value="Em Separacao" <?= $data['pedido']->status=='Em Separacao'?'selected':'' ?>>Em Separação</option>
                    <option value="Enviado" <?= $data['pedido']->status=='Enviado'?'selected':'' ?>>Enviado</option>
                    <option value="Entregue" <?= $data['pedido']->status=='Entregue'?'selected':'' ?>>Entregue</option>
                </select>

                <button type="submit" class="btn btn-primary">Salvar Status</button>
            </form>
        </div>
    </div>

</div>

<style>
    @media print {
        .no-print, header, footer {
            display: none !important;
        }
        .container {
            margin-top: 0 !important;
            max-width: 100% !important;
        }
        .card {
            border: 1px solid #000 !important;
        }
    }
</style>

<?php require_once '../app/views/layouts/footer.php'; ?>
