# Receitas em PHP

Um projeto simples em PHP para listar e gerenciar receitas, utilizando dados de um arquivo JSON e de um banco de dados MySQL. A aplicação pode ser executada localmente (XAMPP) ou via Docker.

## Pré-requisitos

*   PHP 8.0+
*   Composer
*   Docker e Docker Compose (para rodar com Docker)
*   Um servidor MySQL (como o do XAMPP, para rodar localmente)

## Instalação

1.  Clone o repositório para sua máquina local:
    ```bash
    git clone <url-do-seu-repositorio>
    cd Receitas-PHP
    ```

2.  Instale as dependências do PHP com o Composer:
    ```bash
    composer install
    ```

## Como Rodar o Projeto

Você pode rodar o projeto de duas formas principais:

### Opção 1: Usando Docker (Recomendado)

Este método configura todo o ambiente (servidor web e banco de dados) automaticamente.

1.  Copie o arquivo de exemplo de ambiente para o Docker:
    ```bash
    copy .env.example .env.docker
    ```
    *(Use `cp` em vez de `copy` em sistemas Linux ou macOS).*

2.  Suba os containers com o Docker Compose. A flag `--build` garante que a imagem será construída com todas as dependências corretas.
    ```bash
    docker-compose up --build
    ```

3.  A aplicação estará disponível em `http://localhost:8000`. O banco de dados será criado e populado automaticamente.

### Opção 2: Rodando Localmente (XAMPP ou Servidor Embutido do PHP)

1.  **Configure o Banco de Dados:**
    *   Crie um banco de dados no seu MySQL com o nome `receitas_db`.
    *   Importe a estrutura da tabela executando o conteúdo do arquivo `mysql-init/1-schema.sql`.

2.  **Configure as Variáveis de Ambiente:**
    *   Copie o arquivo de exemplo `.env.example` para `.env`.
    *   Edite o arquivo `.env` com as credenciais do seu banco de dados local (usuário, senha, etc.).

3.  **Inicie o Servidor:**
    *   **Com o servidor embutido do PHP (mais simples):**
        ```bash
        php -S localhost:8000
        ```
    *   **Com XAMPP:** Coloque a pasta do projeto dentro de `htdocs` e acesse `http://localhost/Receitas-PHP/` pelo navegador.


No começo, para fazer os requisitos mínimos, utilizei 4 horas. 
É um projeto simples, porém gastei um tempo no php.net para ver as melhores formas de validar as funções.

O index.php foi a parte mais fácil, mas no detalhe.php tive um pouco de dificuldade para validar e fazer de uma forma boa e funcional. Tive que gastar um pouco mais de tempo, pois não queria utilizar IA nessas partes do projeto. Fazia um tempo que não codava em PHP, então queria me desafiar a não usar IA na lógica.

Mas para melhorar e fazer o CRUD de receitas, um CSS um pouco mais elaborado.
Demorei em torno de 9 a 10 horas totais.

E utilizei IA para:

O receitas.JSON: pedi pra IA gerar.
O CSS em geral foi feito por mim, mas no final, pedi pra IA dar uma "melhorada".
Ajudar a ajustar erros de diretórios.
Ajudar em erros no banco.
E pequenos erros gerais.
Fazer a base do CRUD para não perder muito tempo com código "simples".
(SEMPRE revisando o código que a IA gerou).

No final, revisei tudo e testei nos ambientes local e Docker!

E terminei o projeto e estou satisfeito com o resultado.





