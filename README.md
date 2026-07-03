# Sistema de Lista de Tarefas (To-Do List) em PHP


Esse é um projetinho que fiz pra praticar PHP, mostrando a evolução de um sistema simples de tarefas: primeiro guardando tudo num arquivo de texto, depois migrando pra um banco de dados relacional de verdade. A ideia foi treinar boas práticas aos poucos, sem pular direto pro banco de dados.

##  Sobre o projeto

O sistema tem duas fases:

- **Fase 1** — CRUD de tarefas usando um arquivo `.txt` como "banco de dados". Serve pra entender a lógica de criar, ler, atualizar e apagar dados sem depender de SQL.
- **Fase 2** — Mesmo CRUD, mas agora salvando tudo em MySQL, usando PHP com boas práticas (conexão, queries preparadas, etc).

##  Tecnologias usadas

- PHP
- MySQL
- HTML/CSS básico
- Nenhum framework — tudo feito na mão mesmo, pra fixar o conteúdo

##  Estrutura de pastas

```
sistema-tarefas/
├── fase1/
│   ├── index.php
│   └── tarefas.txt      (gerado automaticamente)
├── fase2/
│   ├── index.php
│   └── script.sql
└── README.md
```

##  Como rodar o projeto na sua máquina

### O que você vai precisar antes de começar

- Servidor local instalado — pode ser XAMPP, WampServer, Laragon ou até o PHP embutido mesmo (`php -S`), o que você tiver mais à mão.
- MySQL instalado e rodando (já vem junto no XAMPP/WampServer/Laragon).
- Um navegador qualquer.

### Passo 1 — Baixar/copiar o projeto

Coloque a pasta `sistema-tarefas` dentro do diretório raiz do seu servidor local.

Exemplos, dependendo do que você usa, neste caso utilizei o Laragon:

- **Laragon:** `C:/laragon/www/sistema-tarefas/`

### Passo 2 — Ligar o Apache e o MySQL

Abra o painel de controle do seu servidor (o XAMPP Control Panel, por exemplo) e clique em **Start** nos módulos **Apache** e **MySQL**.

### Passo 3 — Testando a Fase 1 (arquivo de texto)

Com o Apache ligado, abra o navegador e acesse:

```
http://localhost/sistema-tarefas/fase1/
```

Você já consegue adicionar, editar e remover tarefas normalmente. O arquivo `tarefas.txt` é criado sozinho na primeira vez que você salva alguma coisa — não precisa criar ele manualmente nem configurar nada antes.

> Se der erro de permissão pra escrever no arquivo (mais comum no Linux/Mac), rode:
> ```
> chmod 777 fase1/
> ```

### Passo 4 — Configurando a Fase 2 (banco de dados)

Aqui entra a parte com banco de verdade. Segue o passo a passo:

1. Abra o **phpMyAdmin** (geralmente em `http://localhost/phpmyadmin`) ou o gerenciador SQL que você preferir.
2. Crie o banco de dados executando o script que está em `fase2/script.sql`. Você pode:
   - Copiar e colar o conteúdo do arquivo direto na aba **SQL** do phpMyAdmin, ou
   - Usar a opção **Importar** e selecionar o arquivo `script.sql`.
3. Confira se o banco e a tabela de tarefas foram criados corretamente.
4. Abra o arquivo `fase2/index.php` num editor de código e ajuste as credenciais de conexão no início do arquivo, caso sejam diferentes do padrão:

```php
$host = 'localhost';
$usuario = 'root';
$senha = '';
$banco = 'nome_do_banco';
```

> Por padrão, XAMPP e Laragon usam usuário `root` e senha em branco. Se você mudou isso na sua instalação, é só refletir aqui.

5. Salve o arquivo e acesse:

```
http://localhost/sistema-tarefas/fase2/
```

Pronto, agora o CRUD já está funcionando direto no banco de dados.


##  Funcionalidades

- [x] Criar tarefa
- [x] Listar tarefas
- [x] Editar tarefa
- [x] Excluir tarefa
- [x] Persistência em arquivo (Fase 1)
- [x] Persistência em banco de dados (Fase 2)

##  O que eu aprendi com esse projeto

Fazer a Fase 1 antes da Fase 2 ajudou bastante a entender que um "banco de dados" é só um jeito mais robusto de guardar informação — a lógica de CRUD é praticamente a mesma, muda é a forma de ler/escrever os dados. Também aprendi na prática a importância de separar a conexão do banco do resto do código e a tomar mais cuidado com queries pra evitar problemas de segurança.



