<?php require_once '../app/views/layouts/header.php'; ?>

<div class="container mt-5" style="max-width: 600px;">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="m-0">
                <?= isset($data['produto']) ? 'Editar Produto' : 'Novo Produto' ?>
            </h4>
        </div>
        <div class="card-body">
            
            <form action="/sistema-presidio/public/adminProdutos/salvar" method="POST" enctype="multipart/form-data">
                
                <input type="hidden" name="id" value="<?= isset($data['produto']) ? $data['produto']->id : '' ?>">
                
                <input type="hidden" name="imagem_atual" value="<?= isset($data['produto']) ? $data['produto']->imagem : '' ?>">

                <div class="mb-3">
                    <label class="form-label">Nome do Produto</label>
                    <input type="text" name="nome" class="form-control" required
                           value="<?= isset($data['produto']) ? $data['produto']->nome : '' ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Categoria</label>
                    <select name="categoria_id" class="form-select" required>
                        <option value="">Selecione...</option>
                        <?php foreach ($data['categorias'] as $cat): ?>
                            <?php 
                                $selected = '';
                                if (isset($data['produto']) && $data['produto']->categoria_id == $cat->id) {
                                    $selected = 'selected';
                                }
                            ?>
                            <option value="<?= $cat->id ?>" <?= $selected ?>>
                                <?= $cat->nome ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Preço (R$)</label>
                        <input type="text" name="preco" class="form-control" placeholder="0.00" required
                               value="<?= isset($data['produto']) ? number_format($data['produto']->preco, 2, ',', '.') : '' ?>">
                    </div>
                    
                    <div class="col-md-6 mb-3">
                        <label class="form-label">Imagem do Produto</label>
                        <input type="file" name="imagem_arquivo" class="form-control" accept="image/*">
                        
                        <?php if(isset($data['produto']) && !empty($data['produto']->imagem)): ?>
                            <div class="mt-2">
                                <small>Atual:</small>
                                <img src="/sistema-presidio/public/img/<?= $data['produto']->imagem ?>" height="50">
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao" class="form-control" rows="3"><?= isset($data['produto']) ? $data['produto']->descricao : '' ?></textarea>
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-success btn-lg">Salvar Dados</button>
                    <a href="/sistema-presidio/public/adminProdutos/index" class="btn btn-outline-secondary">Cancelar</a>
                </div>

            </form>
        </div>
    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
