# 🛒 Sistema de Pedidos para Penitenciária

> **Trabalho de Conclusão da Disciplina:** Engenharia de Software 3  
> **Status:** ✅ Concluído (MVP)

## 📖 Sobre o Projeto
Este sistema foi desenvolvido para solucionar um problema logístico real de um supermercado familiar que atende uma penitenciária local. O objetivo é substituir o processo manual (via WhatsApp) por uma plataforma de E-commerce controlada.

O sistema permite que **familiares de detentos** realizem pedidos de itens permitidos, respeitando rigorosamente as **regras de limitação de quantidade por categoria** impostas pela penitenciária (ex: máx. 2 sabonetes, independente da marca).

---

## 🚀 Tecnologias Utilizadas

* **Linguagem:** PHP 8+ (Puro/Vanilla)
* **Arquitetura:** MVC (Model-View-Controller) construído do zero
* **Banco de Dados:** MySQL / MariaDB
* **Frontend:** HTML5, CSS3, Bootstrap 5
* **Servidor Local:** Apache (XAMPP)
* **Testes:** Selenium IDE (Automação de Interface)

---

## ⚙️ Funcionalidades Principais

### 👤 Módulo Cliente (Familiar)
* **Cadastro Duplo:** Vincula os dados do familiar aos dados do preso (INFOPEN, Pavilhão).
* **Vitrine de Produtos:** Visualização de itens permitidos com fotos.
* **Carrinho Inteligente:** Validação em tempo real das restrições de quantidade (Regra de Negócio).
* **Histórico:** Acompanhamento do status do pedido (Pendente -> Enviado -> Entregue).

### 🛡️ Módulo Administrativo & Atendente
* **Gestão de Pedidos:** Visualização completa, alteração de status e impressão de ficha de separação.
* **Gestão de Produtos:** CRUD completo com upload de imagens.
* **Gestão de Usuários:** Listagem e controle de clientes cadastrados.
* **Controle de Acesso:** Diferenciação de permissões entre Admin, Atendente e Cliente.

---

## 🧠 Regra de Negócio Crítica (O Diferencial)
A principal complexidade do sistema reside no **Controle de Limites por Categoria**.
Diferente de e-commerces tradicionais que limitam estoque, este sistema limita a compra baseada na **Categoria Penitenciária**.

>
