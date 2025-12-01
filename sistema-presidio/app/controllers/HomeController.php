<?php
class HomeController extends Controller {
    
    public function index() {
        // Conectar ao banco
        $db = new Database();
        
        // Buscar produtos E o nome da categoria (JOIN)
        $sql = "SELECT p.*, c.nome as nome_categoria 
                FROM produtos p 
                JOIN categorias c ON p.categoria_id = c.id
                ORDER BY p.nome ASC";
                
        $db->query($sql);
        $produtos = $db->resultSet();
        
        // Enviar dados para a View
        $dados = [
            'produtos' => $produtos
        ];
        
        $this->view('home/index', $dados);
    }
}
