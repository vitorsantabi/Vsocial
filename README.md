# V Social

**V Social** é uma rede social simples desenvolvida como projeto acadêmico. A plataforma permite que usuários se cadastrem, façam login, publiquem imagens e textos, sigam outros perfis e vejam postagens no feed. O sistema foi construído utilizando HTML, CSS, JavaScript, PHP e MySQL com o ambiente local XAMPP.

## 🚀 Funcionalidades

- Cadastro e login de usuários
- Edição de perfil com foto e bio (até 30 caracteres)
- Criação de postagens com imagem e texto
- Feed com postagens dos usuários
- Sistema de seguir/outros usuários
- Painel de visualização de usuários cadastrados

## 🛠️ Tecnologias Utilizadas

- **Frontend:** HTML5, CSS3, JavaScript
- **Backend:** PHP
- **Banco de Dados:** MySQL
- **Servidor Local:** XAMPP

## 📂 Estrutura do Projeto
vsocial/
├── assets/
│ └── css/
│ └── style.css
├── db.php
├── index.php
├── login.php
├── register.php
├── profile.php
├── upload.php
└── ...
## 💡 Como Executar o Projeto


## 💡 Como Executar o Projeto

1. Clone o repositório:
   ```bash
   git clone https://github.com/vitorsantabi/Vsocial.git
Coloque o projeto dentro da pasta htdocs do XAMPP:

bash
Copiar
Editar
C:/xampp/htdocs/Vsocial
Crie o banco de dados no phpMyAdmin com o nome social.

Importe o arquivo .sql (caso tenha fornecido) ou crie as tabelas manualmente no MySQL com os campos necessários.

Configure a conexão com o banco no arquivo db.php:

php
Copiar
Editar
$conn = new mysqli("localhost", "root", "", "social");
Inicie o servidor Apache e MySQL pelo painel do XAMPP.

Acesse o sistema no navegador:

arduino
Copiar
Editar
http://localhost/Vsocial/

📌 Observações
Projeto com fins educacionais

Pode ser expandido com recursos como comentários, curtidas, mensagens, notificações etc.

👨‍💻 Autor
Vitor Santana
