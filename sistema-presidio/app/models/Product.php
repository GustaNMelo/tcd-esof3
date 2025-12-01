<?php
class Product {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Busca todos (já usado na Home)
    public function getAll() {
        $this->db->query("SELECT p.*, c.nome as nome_categoria 
                          FROM produtos p 
                          JOIN categorias c ON p.categoria_id = c.id
                          ORDER BY p.nome ASC");
        return $this->db->resultSet();
    }

    // Busca UM produto pelo ID (para o Carrinho)
    public function findById($id) {
        // Traz o category_id e o limite_maximo para validar
        $this->db->query("SELECT p.*, c.limite_maximo, c.id as cat_id, c.nome as cat_nome
                          FROM produtos p 
                          JOIN categorias c ON p.categoria_id = c.id
                          WHERE p.id = :id");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // --- MÉTODOS PARA O ADMIN (CRUD) ---

    // Cadastrar novo produto
    public function salvar($dados) {
        $this->db->query("INSERT INTO produtos (categoria_id, nome, descricao, preco, imagem) VALUES (:cat, :nome, :desc, :preco, :img)");
        $this->db->bind(':cat', $dados['categoria_id']);
        $this->db->bind(':nome', $dados['nome']);
        $this->db->bind(':desc', $dados['descricao']);
        $this->db->bind(':preco', $dados['preco']);
        $this->db->bind(':img', $dados['imagem']);
        return $this->db->execute();
    }

    // Atualizar produto existente
    public function atualizar($dados) {
        $this->db->query("UPDATE produtos SET categoria_id = :cat, nome = :nome, descricao = :desc, preco = :preco, imagem = :img WHERE id = :id");
        $this->db->bind(':id', $dados['id']);
        $this->db->bind(':cat', $dados['categoria_id']);
        $this->db->bind(':nome', $dados['nome']);
        $this->db->bind(':desc', $dados['descricao']);
        $this->db->bind(':preco', $dados['preco']);
        $this->db->bind(':img', $dados['imagem']);
        return $this->db->execute();
    }

    // Excluir produto
    public function deletar($id) {
        // Primeiro apaga os itens de pedidos vinculados a esse produto (para não dar erro de FK)
        $this->db->query("DELETE FROM itens_pedido WHERE produto_id = :id");
        $this->db->bind(':id', $id);
        $this->db->execute();

        // Agora apaga o produto
        $this->db->query("DELETE FROM produtos WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
    
    // Buscar categorias (para preencher o select no formulário)
    public function getCategorias() {
        $this->db->query("SELECT * FROM categorias ORDER BY nome ASC");
        return $this->db->resultSet();
    }
}
