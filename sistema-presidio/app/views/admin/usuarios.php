<?php require_once '../app/views/layouts/header.php'; ?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary"><i class="fas fa-users"></i> Gerenciar Usuários</h2>
        <a href="/sistema-presidio/public/admin/dashboard" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> Voltar ao Painel
        </a>
    </div>

    <div class="card shadow">
        <div class="card-body p-0">
            <table class="table table-striped mb-0">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Tipo</th>
                        <th>Preso Vinculado</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['usuarios'] as $user): ?>
                    <tr>
                        <td><?= $user->id ?></td>
                        <td><?= $user->nome ?></td>
                        <td><?= $user->email ?></td>
                        <td>
                            <?php if($user->tipo == 'administrador'): ?>
                                <span class="badge bg-danger">Admin</span>
                            <?php elseif($user->tipo == 'atendente'): ?>
                                <span class="badge bg-warning text-dark">Atendente</span>
                            <?php else: ?>
                                <span class="badge bg-success">Cliente</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?= ($user->tipo == 'cliente') ? 'Sim (Ver detalhes)' : '-' ?>
                        </td>
                        <td>
                            <?php if($user->id != $_SESSION['user_id']): ?>
                                <a href="/sistema-presidio/public/adminUsuarios/deletar/<?= $user->id ?>" 
                                   class="btn btn-sm btn-danger"
                                   onclick="return confirm('Tem certeza que deseja excluir este usuário?');">
                                    <i class="fas fa-trash"></i>
                                </a>
                            <?php else: ?>
                                <small class="text-muted">Eu</small>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php require_once '../app/views/layouts/footer.php'; ?>
