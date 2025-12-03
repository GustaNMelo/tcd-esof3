-- 1. PREPARAÇÃO DO AMBIENTE (Limpeza)
DROP DATABASE IF EXISTS sistema_presidio;
CREATE DATABASE sistema_presidio;
USE sistema_presidio;

-- Desativa verificação de chaves temporariamente para criação rápida
SET FOREIGN_KEY_CHECKS = 0;

-- 2. CRIAÇÃO DAS TABELAS

-- Tabela de Usuários (Atores: Cliente, Admin, Atendente)
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL,
    tipo ENUM('cliente', 'administrador', 'atendente') DEFAULT 'cliente',
    cpf VARCHAR(14),         -- Apenas para Cliente
    telefone VARCHAR(20),    -- Apenas para Cliente
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabela de Presos (Relação 1:N com Cliente)
CREATE TABLE presos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL, -- O familiar responsável
    nome VARCHAR(100) NOT NULL,
    infopen VARCHAR(50) NOT NULL,
    locInterna VARCHAR(50) NOT NULL, -- Pavilhão/Ala
    cela VARCHAR(20) NOT NULL,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabela de Categorias (Regra de Negócio: Limite de Quantidade)
CREATE TABLE categorias (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(50) NOT NULL,
    limite_maximo INT NOT NULL -- A regra de negócio principal (Ex: 2 sabonetes)
);

-- Tabela de Produtos
CREATE TABLE produtos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    categoria_id INT NOT NULL, -- Liga à categoria
    nome VARCHAR(100) NOT NULL,
    descricao TEXT,
    preco DECIMAL(10, 2) NOT NULL,
    imagem VARCHAR(255),
    FOREIGN KEY (categoria_id) REFERENCES categorias(id)
);

-- Tabela de Pedidos
CREATE TABLE pedidos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL, -- Quem comprou
    preso_id INT NOT NULL,   -- Para quem vai
    valorTotal DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    data DATETIME DEFAULT CURRENT_TIMESTAMP,
    status VARCHAR(20) DEFAULT 'Pendente', -- Pendente, Pago, Enviado, Entregue, Cancelado
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (preso_id) REFERENCES presos(id) ON DELETE CASCADE
);

-- Tabela de Itens do Pedido
CREATE TABLE itens_pedido (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pedido_id INT NOT NULL,
    produto_id INT NOT NULL,
    quantidade INT NOT NULL,
    subtotal DECIMAL(10, 2) NOT NULL,
    FOREIGN KEY (pedido_id) REFERENCES pedidos(id) ON DELETE CASCADE,
    FOREIGN KEY (produto_id) REFERENCES produtos(id)
);

-- Reativa a segurança do banco
SET FOREIGN_KEY_CHECKS = 1;

-- 3. POPULAÇÃO DE DADOS (SEEDS)

-- A. Usuários Iniciais
INSERT INTO usuarios (nome, email, senha, tipo) VALUES 
('Administrador Chefe', 'admin@sistema.com', '1234', 'administrador'),
('Atendente João', 'joao@sistema.com', '1234', 'atendente'),
('Cliente Josias', 'josias@hotmail.com', '1234', 'cliente');

-- B. Preso de Teste (Vinculado ao Josias - ID 3)
INSERT INTO presos (usuario_id, nome, infopen, locInterna, cela) VALUES 
(3, 'Detento Exemplo', '2025-MG-001', 'Pavilhão 1', '10');

-- C. Categorias Reais
INSERT INTO categorias (id, nome, limite_maximo) VALUES 
(1, 'Bíblias', 1),
(2, 'Inverno (Blusas)', 1),
(3, 'Bolachas Grandes (+300g)', 1),
(4, 'Bolachas Peq/Médias', 4),
(5, 'Higiene Pessoal (Banho)', 1),
(6, 'Papelaria', 1),
(7, 'Vestuário Inferior', 1),
(8, 'Vestuário Superior', 1),
(9, 'Calçados', 1),
(10, 'Cama e Banho', 1),
(11, 'Higiene (Unhas)', 1),
(12, 'Hidratantes', 1),
(13, 'Roupas Íntimas (Cuecas)', 2),
(14, 'Limpeza (Desinfetante)', 1),
(15, 'Desodorantes', 1),
(16, 'Correios (Envelopes)', 10),
(17, 'Higiene Oral (Escovas)', 1),
(18, 'Limpeza (Roupas)', 1),
(19, 'Meias', 1),
(20, 'Limpeza (Chão)', 1),
(21, 'Papel Higiênico', 4),
(22, 'Higiene Oral (Pastas)', 1),
(23, 'Barbearia', 1),
(24, 'Sabonetes', 2),
(25, 'Sabão em Pó', 1),
(26, 'Correios (Selos)', 10),
(27, 'Cabelo (Shampoo)', 1),
(28, 'Sucos (Tang/Frisco)', 8),
(29, 'Sucos (Vilma/Promix)', 4),
(30, 'Sucos 1KG', 1);

-- D. Produtos Reais
-- Bíblias
INSERT INTO produtos (categoria_id, nome, preco, descricao) VALUES 
(1, 'Bíblia Novo Testamento', 30.00, 'Edição Novo Testamento'),
(1, 'Bíblia Grande', 75.00, 'Bíblia completa tamanho grande'),
(1, 'Bíblia Pequena', 45.00, 'Bíblia completa tamanho pequeno');

-- Inverno
INSERT INTO produtos (categoria_id, nome, preco, descricao) VALUES 
(2, 'Blusa de Frio Vermelha', 98.00, 'Sem zíper e capuz (Padrão)');

-- Bolachas GRANDES
INSERT INTO produtos (categoria_id, nome, preco, descricao) VALUES 
(3, 'Bolacha Casaredo Chocolate', 9.98, 'Pacote 600g'),
(3, 'Bolacha Rosquinha Mabel (Coco)', 8.90, 'Pacote 600g'),
(3, 'Bolacha Rosquinha Mabel (Choc)', 7.98, 'Pacote 500g'),
(3, 'Bolacha Rosquinha Marilan', 8.98, 'Pacote 500g'),
(3, 'Bolacha Vilma Maisena', 6.48, 'Pacote 360g'),
(3, 'Bolacha Marilan Maisena Choc', 7.98, 'Pacote 350g'),
(3, 'Bolacha Agua e Sal / Cream Cracker', 5.98, 'Pacote 350g');

-- Bolachas PEQUENAS/MÉDIAS
INSERT INTO produtos (categoria_id, nome, preco, descricao) VALUES 
(4, 'Bolacha Bauducco Choc/Banana', 10.98, 'Unidade'),
(4, 'Bolacha Aymore Amanteigados', 6.98, '248g (Choc, Leite, Coco)'),
(4, 'Bolacha Passatempo Maisena', 3.98, '170g'),
(4, 'Bolacha Doce Petyan', 2.98, '200g'),
(4, 'Bolacha Mabel Amanteigados', 8.98, 'Variados'),
(4, 'Bolacha Aymore Cream Cracker', 3.48, '164g'),
(4, 'Bolacha Passatempo Leite', 3.98, 'Unidade'),
(4, 'Bolacha Vilma Maisena Peq', 2.98, '170g'),
(4, 'Bolacha Aymore Salpet', 4.48, '200g'),
(4, 'Bolacha Piraque Leite Maltado', 4.98, 'Unidade'),
(4, 'Bolacha Tostines Coco', 4.48, '160g'),
(4, 'Bolacha Tostines Maça e Canela', 3.98, '160g'),
(4, 'Bolacha Nesfit Banana/Aveia', 3.98, '160g');

-- Diversos
INSERT INTO produtos (categoria_id, nome, preco, descricao) VALUES 
(5, 'Bucha de Banho', 2.98, 'Unidade'),
(6, 'Caderno', 5.98, 'Brochurão 96fls'),
(6, 'Caneta BIC', 1.50, 'Transparente Azul ou Preta'),
(10, 'Cobertor', 42.00, 'Unidade Padrão'),
(11, 'Cortador de Unha', 2.99, 'Sem lixa (2a linha)');

-- Vestuário
INSERT INTO produtos (categoria_id, nome, preco, descricao) VALUES 
(7, 'Bermuda', 35.00, 'Tam P a G'),
(7, 'Calça Moletom', 98.00, 'Tam P a G'),
(8, 'Camiseta Manga Longa/Curta', 45.00, 'Tam P a G'),
(9, 'Chinelo Havaianas Top', 27.99, 'Preto');

-- Higiene e Limpeza
INSERT INTO produtos (categoria_id, nome, preco, descricao) VALUES 
(12, 'Creme Hidratante Monange/Paixão', 11.90, '200ml'),
(12, 'Creme Hidratante Nivea', 19.90, '200ml'),
(13, 'Cueca de Algodão', 14.90, 'Elástico Simples'),
(14, 'Desinfetante Casa Perfume', 5.98, '500ml Transparente'),
(14, 'Desinfetante Casaflor', 3.98, '500ml Transparente'),
(15, 'Desodorante Herbissimo', 6.98, 'Creme'),
(15, 'Desodorante Red Apple', 6.98, 'Creme'),
(16, 'Envelope para Cartas', 0.20, 'Unidade'),
(17, 'Escova de Dente', 2.70, 'Unidade'),
(18, 'Escova de Roupa', 3.98, 'Plástico'),
(19, 'Meia de Algodão', 7.00, 'Par'),
(20, 'Pano de Chão', 7.68, 'Médio');

-- Papel e Pasta
INSERT INTO produtos (categoria_id, nome, preco, descricao) VALUES 
(21, 'Papel Higiênico Paloma', 3.98, 'Rolo 30m'),
(21, 'Papel Higiênico Personal', 5.98, 'Rolo 30m'),
(22, 'Pasta de Dente Closeup', 6.98, '90g Transparente');

-- Barbearia
INSERT INTO produtos (categoria_id, nome, preco, descricao) VALUES 
(23, 'Prestobarba Probak', 2.48, 'Amarelo (Até 2 lâminas)'),
(23, 'Prestobarba Gilette', 3.48, 'Azul (Até 2 lâminas)');

-- Sabão em Pó
INSERT INTO produtos (categoria_id, nome, preco, descricao) VALUES 
(25, 'Sabão em Pó Tixan', 6.48, '400g'),
(25, 'Sabão em Pó Triex', 3.98, '400g');

-- Sabonetes
INSERT INTO produtos (categoria_id, nome, preco, descricao) VALUES 
(24, 'Sabonete Marluce', 1.50, '90g'),
(24, 'Sabonete Flor de Ype', 1.98, '90g'),
(24, 'Sabonete Albany', 1.98, '90g'),
(24, 'Sabonete Francis', 2.48, '90g'),
(24, 'Sabonete Lux', 2.89, '90g'),
(24, 'Sabonete Palmolive', 2.89, '90g'),
(24, 'Sabonete Pompom', 3.98, '90g'),
(24, 'Sabonete Protex', 3.98, '90g');

-- Outros
INSERT INTO produtos (categoria_id, nome, preco, descricao) VALUES 
(26, 'Selos para Cartas', 4.48, 'Unidade'),
(27, 'Shampoo Seda', 12.80, '350ml'),
(27, 'Shampoo Dove', 16.90, '350ml'),
(27, 'Shampoo Seda Anti Caspa', 16.98, '350ml');

-- Sucos
INSERT INTO produtos (categoria_id, nome, preco, descricao) VALUES 
(28, 'Suco Tang', 1.48, 'Unidade'),
(28, 'Suco Frisco', 1.25, 'Unidade'),
(29, 'Suco Vilma', 3.48, 'Unidade'),
(29, 'Suco Promix', 8.98, '250g'),
(30, 'Suco Vilma 1kg', 13.98, 'Pacote 1kg');
