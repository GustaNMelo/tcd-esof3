<?php require_once '../app/views/layouts/header.php'; ?>

<div class="container" style="margin-top: 50px; margin-bottom: 50px;">
    <div class="card shadow-lg text-center p-5" style="max-width: 600px; margin: 0 auto;">
        
        <div class="mb-4">
            <i class="fas fa-check-circle text-success" style="font-size: 80px;"></i>
        </div>

        <h2 class="text-success fw-bold">Pedido #<?= $data['pedido_id'] ?> Criado!</h2>
        <p class="lead text-muted">Seu pedido foi recebido com sucesso.</p>
        
        <hr class="my-4">

        <h4 class="mb-3">Valor Total: <span class="fw-bold">R$ <?= number_format($data['total'], 2, ',', '.') ?></span></h4>

        <div class="alert alert-info">
            <i class="fas fa-qrcode"></i> <strong>Pagamento via PIX</strong><br>
            Leia o QR Code abaixo ou copie a chave para finalizar.
        </div>

        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/QR_code_for_mobile_English_Wikipedia.svg" 
             alt="QR Code Pix" style="width: 150px; margin-bottom: 20px;">
        
        <br>
        
        <div class="input-group mb-3">
            <input type="text" class="form-control text-center" value="00020126580014br.gov.bcb.pix0136123e4567..." readonly>
            <button class="btn btn-outline-secondary" type="button">Copiar</button>
        </div>

        <div class="card bg-light border-warning mb-3">
            <div class="card-body py-3">
                <h6 class="text-warning fw-bold mb-2"><i class="fas fa-flask"></i> Pagamento Simulado</h6>
                <p class="small text-muted mb-2">Para fins de apresentação, clique abaixo para simular a confirmação imediata do banco.</p>
                
                <a id="btn-simular-pagamento" href="/sistema-presidio/public/pedido/pagar/<?= $data['pedido_id'] ?>" class="btn btn-warning w-100 fw-bold">
                    <i class="fas fa-bolt"></i> Simular Pagamento Confirmado
                </a>
            </div>
        </div>

        <p class="small text-muted mt-3">
            Após o pagamento, o status mudará para "Pago" automaticamente.
        </p>

        <a href="/sistema-presidio/public/home" class="btn btn-success w-100 mt-2">Voltar ao Início</a>
    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
