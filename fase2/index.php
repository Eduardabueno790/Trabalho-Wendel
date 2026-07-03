<?php
/**
 * To-Do List - Fase 2: Banco de Dados com PDO e Segurança Total
 * Utiliza Consistentemente Prepared Statements em todas as operações.
 */

$host = 'localhost';
$dbname = 'todo_db';
$username = 'root';
$password = ''; // Altere aqui se o seu ambiente local possuir senha

try {
    // Conexão segura utilizando PDO com tratamento de erros por exceção
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Erro crítico de conexão ao banco de dados: " . $e->getMessage());
}

// 1. OPERAÇÃO: CRIAR (Prepared Statement Seguro contra SQL Injection)
if (isset($_POST['adicionar']) && !empty(trim($_POST['titulo']))) {
    $titulo = htmlspecialchars(trim($_POST['titulo']));
    
    $stmt = $pdo->prepare("INSERT INTO tarefas (titulo, status) VALUES (:titulo, 'Pendente')");
    $stmt->execute([':titulo' => $titulo]);
    
    header("Location: index.php");
    exit;
}

// 2. OPERAÇÃO: ATUALIZAR STATUS (Prepared Statement Seguro)
if (isset($_GET['alternar']) && isset($_GET['status_atual'])) {
    $id = (int)$_GET['alternar'];
    $status_atual = $_GET['status_atual'];
    $novo_status = ($status_atual === 'Pendente') ? 'Concluída' : 'Pendente';
    
    $stmt = $pdo->prepare("UPDATE tarefas SET status = :status WHERE id = :id");
    $stmt->execute([
        ':status' => $novo_status,
        ':id' => $id
    ]);
    
    header("Location: index.php");
    exit;
}

// 3. OPERAÇÃO: DELETAR (Prepared Statement Seguro)
if (isset($_GET['deletar'])) {
    $id = (int)$_GET['deletar'];
    
    $stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = :id");
    $stmt->execute([':id' => $id]);
    
    header("Location: index.php");
    exit;
}

// 4. OPERAÇÃO: LISTAR (Consulta via PDO)
try {
    $stmt = $pdo->query("SELECT * FROM tarefas ORDER BY id DESC");
    $tarefas = $stmt->fetchAll();
} catch (PDOException $e) {
    $tarefas = [];
}
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>To-Do List - Fase 2 (MySQL PDO)</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; color: #333; margin: 40px auto; max-width: 500px; padding: 20px; }
        .container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; color: #2c3e50; text-align: center; }
        form { display: flex; margin-bottom: 20px; }
        input[type="text"] { flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px 0 0 4px; font-size: 14px; }
        button { padding: 10px 15px; background: #3498db; color: #fff; border: none; border-radius: 0 4px 4px 0; cursor: pointer; font-weight: bold; }
        button:hover { background: #2980b9; }
        .tarefa-item { display: flex; justify-content: space-between; align-items: center; padding: 12px; border-bottom: 1px solid #eee; }
        .tarefa-item:last-child { border-bottom: none; }
        .concluida { text-decoration: line-through; color: #7f8c8d; }
        .status-badge { font-size: 11px; padding: 3px 6px; border-radius: 3px; font-weight: bold; margin-right: 5px; }
        .badge-pendente { background: #ffeaa7; color: #d63031; }
        .badge-concluida { background: #badc58; color: #6ab04c; }
        .actions a { text-decoration: none; margin-left: 10px; font-size: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <h2>To-Do List - Fase 2</h2>
        
        <!-- Formulário de Criação -->
        <form method="POST" action="index.php">
            <input type="text" name="titulo" placeholder="Nova tarefa profissional..." required autocomplete="off">
            <button type="submit" name="adicionar">Adicionar</button>
        </form>

        <!-- Listagem de Tarefas -->
        <h3>Suas Tarefas (Banco de Dados)</h3>
        <div>
            <?php if (empty($tarefas)): ?>
                <p style='color: #7f8c8d; text-align:center;'>Nenhuma tarefa encontrada no MySQL.</p>
            <?php else: ?>
                <?php foreach ($tarefas as $tarefa): ?>
                    <div class="tarefa-item">
                        <span class="<?php echo ($tarefa['status'] === 'Concluída') ? 'concluida' : ''; ?>">
                            <span class="status-badge <?php echo ($tarefa['status'] === 'Concluída') ? 'badge-concluida' : 'badge-pendente'; ?>">
                                <?php echo $tarefa['status']; ?>
                            </span>
                            <?php echo $tarefa['titulo']; ?>
                        </span>
                        <div class="actions">
                            <a href="?alternar=<?php echo $tarefa['id']; ?>&status_atual=<?php echo $tarefa['status']; ?>" title="Mudar Status">✔</a>
                            <a href="?deletar=<?php echo $tarefa['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir esta tarefa de forma definitiva?')" title="Excluir" style="color: #e74c3c;">❌</a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
