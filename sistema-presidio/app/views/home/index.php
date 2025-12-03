<?php require_once '../app/views/layouts/header.php'; ?>

<section class="banner">
    Facilite seus pedidos para a Penitenciária
</section>

<section class="container">
    <h2>Como Funciona?</h2>
    <div class="steps">
        <div class="step">
            <h3>1️⃣ Cadastro</h3>
            <p>Crie sua conta e informe seus dados e do preso.</p>
        </div>
        <div class="step">
            <h3>2️⃣ Monte sua Lista</h3>
            <p>Escolha os produtos abaixo e monte sua sacola.</p>
        </div>
        <div class="step">
            <h3>3️⃣ Pagamento</h3>
            <p>Pague via Pix e acompanhe o status.</p>
        </div>
        <div class="step">
            <h3>4️⃣ Entrega</h3>
            <p>Nós entregamos e vistoriamos na penitenciária.</p>
        </div>
    </div>
</section>

<hr class="container">

<section class="container">
    <h2>Produtos Disponíveis</h2>
    
    <div class="products-grid">
        <?php if (!empty($data['produtos'])): ?>
            <?php foreach ($data['produtos'] as $produto): ?>
                
                <div class="product-card">
                    <?php 
                        // Define qual imagem usar (do banco ou a padrão)
                        $img = !empty($produto->imagem) ? $produto->imagem : 'default.jpg'; 
                    ?>
                    
                    <img src="/sistema-presidio/public/img/<?= $img ?>" 
                         onerror="this.src='/sistema-presidio/public/img/default.jpg';" 
                         alt="<?= $produto->nome ?>">
                    
                    <h4><?= $produto->nome ?></h4>
                    <p class="category"><?= $produto->nome_categoria ?></p>
                    <p class="desc"><?= $produto->descricao ?></p>
                    <div class="price">R$ <?= number_format($produto->preco, 2, ',', '.') ?></div>
                    
                    <form action="/sistema-presidio/public/carrinho/adicionar" method="POST">
                        <input type="hidden" name="produto_id" value="<?= $produto->id ?>">
                        <button type="submit" class="btn-buy">
                            <i class="fas fa-cart-plus"></i> Adicionar
                        </button>
                    </form>
                </div>

            <?php endforeach; ?>
        <?php else: ?>
            <p>Nenhum produto cadastrado no momento.</p>
        <?php endif; ?>
    </div>
</section>

<?php require_once '../app/views/layouts/footer.php'; ?>
