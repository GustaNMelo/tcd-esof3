<?php
class Pedido {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Busca o ID do preso vinculado a este usuário
    public function getPresoId($usuario_id) {
        $this->db->query("SELECT id FROM presos WHERE usuario_id = :uid");
        $this->db->bind(':uid', $usuario_id);
        $row = $this->db->single();
        return $row ? $row->id : null;
    }

    public function criarPedido($usuario_id, $preso_id, $total, $itens) {
        try {
            // 1. Inserir o Cabeçalho do Pedido
            $this->db->query("INSERT INTO pedidos (usuario_id, preso_id, valorTotal, status) VALUES (:uid, :pid, :total, 'Pendente')");
            $this->db->bind(':uid', $usuario_id);
            $this->db->bind(':pid', $preso_id);
            $this->db->bind(':total', $total);
            
            if ($this->db->execute()) {
                $pedido_id = $this->db->lastInsertId();

                // 2. Inserir os Itens (Loop)
                foreach ($itens as $item) {
                    $this->db->query("INSERT INTO itens_pedido (pedido_id, produto_id, quantidade, subtotal) VALUES (:ped_id, :prod_id, :qtd, :sub)");
                    $this->db->bind(':ped_id', $pedido_id);
                    $this->db->bind(':prod_id', $item->id);
                    $this->db->bind(':qtd', $item->qtd_carrinho);
                    $this->db->bind(':sub', $item->subtotal);
                    $this->db->execute();
                }

                return $pedido_id; // Retorna o ID para mostrarmos na tela de sucesso
            } else {
                return false;
            }
        } catch (Exception $e) {
            return false;
        }
    }

    // Busca pedidos de um usuário específico
    public function getPedidosPorUsuario($usuario_id) {
        $this->db->query("SELECT * FROM pedidos WHERE usuario_id = :uid ORDER BY id DESC");
        $this->db->bind(':uid', $usuario_id);
        return $this->db->resultSet();
    }
    
    // Busca TODOS os pedidos (Para o Admin/Atendente usar depois)
    public function getTodosPedidos() {
        // Fazemos JOIN para saber o nome do Cliente e do Preso
        $sql = "SELECT p.*, u.nome as nome_cliente, pr.nome as nome_preso 
                FROM pedidos p
                JOIN usuarios u ON p.usuario_id = u.id
                JOIN presos pr ON p.preso_id = pr.id
                ORDER BY p.id DESC";
        $this->db->query($sql);
        return $this->db->resultSet();
    }

    // Atualizar Status (Para o Admin usar)
    public function atualizarStatus($id, $status) {
        $this->db->query("UPDATE pedidos SET status = :status WHERE id = :id");
        $this->db->bind(':status', $status);
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    // Busca os detalhes do cabeçalho (Cliente + Preso + Status) de um pedido
    public function getPedidoPorId($id) {
        $sql = "SELECT p.*, 
                       u.nome as nome_cliente, u.cpf as cpf_cliente, u.telefone as telefone_cliente,
                       pr.nome as nome_preso, pr.infopen, pr.locInterna
                FROM pedidos p
                JOIN usuarios u ON p.usuario_id = u.id
                JOIN presos pr ON p.preso_id = pr.id
                WHERE p.id = :id";
        
        $this->db->query($sql);
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Busca os produtos desse pedido
    public function getItensDoPedido($pedido_id) {
        $sql = "SELECT ip.*, prod.nome, prod.imagem, prod.descricao
                FROM itens_pedido ip
                JOIN produtos prod ON ip.produto_id = prod.id
                WHERE ip.pedido_id = :pid";
        
        $this->db->query($sql);
        $this->db->bind(':pid', $pedido_id);
        return $this->db->resultSet();
    }
}
