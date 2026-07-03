# Sistema de Lista de Tarefas (To-Do List) em PHP

Projeto completo desenvolvido estritamente de acordo com as especificações e critérios de avaliação do CRUD.

## 📂 Estrutura do Projeto
- `/fase1` -> Versão com persistência pura e completa em arquivo texto (`tarefas.txt`).
- `/fase2` -> Versão profissional migrada para banco de dados relacional MySQL via PDO.
- `fase2/script.sql` -> Comando estrutural `CREATE TABLE` pronto para importação.

## 🛠️ Como rodar o projeto localmente

### Passo 1: Preparar o Ambiente
1. Instale um servidor local como o **XAMPP**, **WampServer** ou **Laragon**.
2. Mova ou extraia esta pasta inteira (`todo-list-nota-maxima`) para o diretório de arquivos públicos do seu servidor local (geralmente a pasta `htdocs` ou `www`).

### Passo 2: Executar a Fase 1 (Arquivo de Texto)
1. Certifique-se de que o servidor Apache está ligado.
2. Abra o navegador e digite o endereço: `http://localhost/todo-list-nota-maxima/fase1/index.php`
3. O sistema criará o arquivo `tarefas.txt` de forma automática ao interagir. Todas as operações de adicionar, alternar status e deletar funcionam perfeitamente sem duplicar registros.

### Passo 3: Executar a Fase 2 (MySQL com PDO)
1. Certifique-se de que os servidores Apache e MySQL estão ligados.
2. Acesse o seu gerenciador de banco de dados (ex: `http://localhost/phpmyadmin/`).
3. Vá na aba **SQL**, copie todo o conteúdo do arquivo localizado em `fase2/script.sql` e clique em **Executar/Ir**. Isso criará o banco `todo_db` e a tabela `tarefas`.
4. (*Opcional*) Se o seu banco MySQL local utilizar senha para o usuário `root`, abra o arquivo `fase2/index.php` e altere a variável `$password = '';` na linha 13 informando a sua senha.
5. Abra o navegador e digite o endereço: `http://localhost/todo-list-nota-maxima/fase2/index.php`

## 🔒 Diferenciais de Segurança Implementados
- **Prepared Statements** utilizados de forma consistente em todas as instruções SQL (Insert, Update, Delete) da Fase 2 para mitigar ataques de **SQL Injection**.
- Tratamento de caracteres especiais com `htmlspecialchars()` prevenindo vulnerabilidades de **XSS (Cross-Site Scripting)**.
- Manipulação de arquivos utilizando travas exclusivas (`LOCK_EX`) para evitar concorrência de dados e corrupção de arquivos na Fase 1.
