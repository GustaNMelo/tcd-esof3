<?php
class User {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function register($data) {
        // 1. Inserir na tabela USUARIOS
        $this->db->query('INSERT INTO usuarios (nome, email, senha, cpf, telefone, tipo) VALUES (:nome, :email, :senha, :cpf, :telefone, :tipo)');
        
        $this->db->bind(':nome', $data['nome']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':senha', $data['senha']);
        $this->db->bind(':cpf', $data['cpf']);
        $this->db->bind(':telefone', $data['telefone']);
        $this->db->bind(':tipo', 'cliente');

        if ($this->db->execute()) {
            $novoIdUsuario = $this->db->lastInsertId();

            // 2. Inserir na tabela PRESOS (COM O CAMPO CELA)
            $this->db->query('INSERT INTO presos (usuario_id, nome, infopen, locInterna, cela) VALUES (:usuario_id, :nome_preso, :infopen, :locInterna, :cela)');
            
            $this->db->bind(':usuario_id', $novoIdUsuario);
            $this->db->bind(':nome_preso', $data['nome_preso']);
            $this->db->bind(':infopen', $data['infopen']);
            $this->db->bind(':locInterna', $data['locInterna']);
            
            // Se esqueceu desta linha aqui embaixo, ele não salva!
            $this->db->bind(':cela', $data['cela']); 

            return $this->db->execute();
        } else {
            return false;
        }
    }

    public function login($email, $senha) {
        $this->db->query('SELECT * FROM usuarios WHERE email = :email');
        $this->db->bind(':email', $email);
        $row = $this->db->single();

        if ($row) {
            // Nota: Em produção usar password_verify($senha, $row->senha)
            if ($senha == $row->senha) { 
                return $row;
            }
        }
        return false;
    }

    // VERIFICAR EMAIL
    public function findUserByEmail($email) {
        $this->db->query('SELECT * FROM usuarios WHERE email = :email');
        $this->db->bind(':email', $email);
        $this->db->execute();
        return $this->db->rowCount() > 0;
    }

    // Busca todos os usuários (Para o Admin)
    public function getTodos() {
        $this->db->query("SELECT * FROM usuarios ORDER BY id DESC");
        return $this->db->resultSet();
    }

    // Excluir usuário
    public function deletar($id) {
        $this->db->query("DELETE FROM usuarios WHERE id = :id");
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }
}
