# minhas_fotos

Minhas Fotos Preferidas 



<img width="1921" height="1497" alt="Minhas Fotos Preferidas2" src="https://github.com/user-attachments/assets/d569fd40-87f7-4e15-a4b4-ef835b8d0022" />

<img width="1921" height="1497" alt="Minhas Fotos Preferidas" src="https://github.com/user-attachments/assets/eb0108fc-5265-4e1e-8443-3c7ff7ad6b0b" />

<img width="1920" height="1080" alt="Captura de tela 2026-05-18 091121" src="https://github.com/user-attachments/assets/239b9c4b-fd5e-42ab-8ed4-140968445b18" />

 

 
 

# 🌙 Galeria Privada

Sistema de galeria desenvolvido em **PHP + MySQL**, com interface moderna em **tema escuro** e detalhes em **rosa neon**. O projeto possui autenticação segura, controle de permissões e gerenciamento de imagens em ambiente local utilizando **USBWebserver**.

---

## ✨ Funcionalidades

- 🔐 Sistema de login com sessão PHP
- 👑 Área administrativa
- 🖼️ Upload de fotos
- 🗑️ Exclusão de imagens
- 👁️ Modo visitante apenas para visualização
- 🔒 Senhas protegidas com **Bcrypt**
- 🌑 Interface Dark Mode
- 💖 Estilo visual neon moderno

---

## 👥 Níveis de Acesso

### 👑 Administrador
- Pode postar fotos
- Pode excluir imagens
- Possui acesso completo ao sistema

### 👁️ Visitante
- Pode apenas visualizar a galeria
- Não possui acesso às funções administrativas
- Os botões são ocultados diretamente pelo servidor

---

# 🗄️ Banco de Dados

Crie um banco chamado:

```sql
galeria
```

Depois execute o script abaixo no **phpMyAdmin**:

```sql
CREATE TABLE usuarios (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
);

-- Usuário Administrador
INSERT INTO usuarios (usuario, senha)
VALUES ('Admin', 'SUA_HASH_BCRYPT_AQUI');

-- Usuário Visitante
-- Senha: 1234
INSERT INTO usuarios (usuario, senha)
VALUES (
    'visitante',
    '$2y$10$E2UPv7v9S8bZ8xZ8.8f8e.OebgKxJGv2MvGvGvGvGvGvGvGvGvG'
);
```

---

# ⚙️ Configuração no USBWebserver

Coloque a pasta do projeto dentro de:

```txt
USBWebserver/root/
```

Exemplo:

```txt
USBWebserver/
└── root/
    └── galeria_privada/
```

A pasta `uploads/` deve conter apenas:

```txt
index.html
```

---

# 🔌 Configuração do Banco (`conexao.php`)

```php
<?php

$host = "localhost";
$usuario = "root";
$senha = "usbw";
$banco = "minhas_fotos";

$conexao = mysqli_connect($host, $usuario, $senha, $banco);

if (!$conexao) {
    die("Erro na conexão: " . mysqli_connect_error());
}

?>
```

---

# 🚀 Como Executar

1. Inicie o **USBWebserver**
2. Ligue:
   - Apache
   - MySQL
3. Acesse no navegador:

```txt
http://localhost/galeria_privada
```

---

# 🔒 Segurança

- ✔️ Controle de acesso por sessão
- ✔️ Senhas criptografadas com Bcrypt
- ✔️ Proteção de funções administrativas
- ✔️ Estrutura separada para uploads
- ✔️ Ocultação de botões para visitantes

---

# 🎨 Visual

O projeto utiliza:

- 🌑 Tema escuro
- 💖 Destaques em rosa neon
- ✨ Layout moderno e responsivo
- 🖼️ Cards para exibição das imagens

---

# 👩‍💻 Autoria

**Andreza Pires**

Todo o histórico de desenvolvimento, estrutura do sistema e lógica de segurança foram registrados originalmente através de commits no GitHub.
