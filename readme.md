# 📋 LabSys  
Sistema de gerenciamento de pacientes e exames.

---

## 🔗 Link de Acesso  
Acesse o sistema pelo seguinte link:  
[LabSys - Azure Web App](https://labsys-dfdyg9akbjg5b0eq.brazilsouth-01.azurewebsites.net/index.php)

---

## 🛠 Como Rodar o Projeto Localmente  

### 1. **Clone o repositório:**  

### 1. git clone https://github.com/joaoribeiro03/labsys.git
Entre no repositório clonado: cd labsys
### 2. Configure o Servidor Local:
Certifique-se de ter o servidor Apache e PHP configurados. Pode usar o XAMPP ou WAMP.

### 3. Configuração do Arquivo config.php:
Altere as configurações de conexão com o banco de dados conforme necessário.

### 4. Execute o Projeto:
Inicie o servidor com XAMPP e acesse no navegador.

### 5. Configurar o Banco de Dados:
Execute os seguintes comandos SQL para criar as tabelas necessárias:


```
CREATE DATABASE labsys;

USE labsys;

CREATE TABLE pacientes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    numero_atendimento VARCHAR(20) NOT NULL,
    nome_completo VARCHAR(255) NOT NULL,
    sexo VARCHAR(20),
    email VARCHAR(255),
    celular VARCHAR(20)
);

CREATE TABLE exames (
    id INT AUTO_INCREMENT PRIMARY KEY,
    codigo VARCHAR(10) NOT NULL UNIQUE,
    descricao VARCHAR(255) NOT NULL,
    valor DECIMAL(10, 2) NOT NULL
);

CREATE TABLE paciente_exames (
    paciente_id INT NOT NULL,
    exame_id INT NOT NULL,
    FOREIGN KEY (paciente_id) REFERENCES pacientes(id),
    FOREIGN KEY (exame_id) REFERENCES exames(id),
    PRIMARY KEY (paciente_id, exame_id)
);