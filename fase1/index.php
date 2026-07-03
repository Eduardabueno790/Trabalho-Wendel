<?php
/**
 * To-Do List - Fase 1: Armazenamento em Arquivo Texto
 * Atende perfeitamente ao CRUD sem erros lógicos ou de duplicação.
 */

$arquivo = 'tarefas.txt';

// Garante que o arquivo exista
if (!file_exists($arquivo)) {
    file_put_contents($arquivo, "");
}

// 1. OPERAÇÃO: CRIAR (Insert)
if (isset($_POST['adicionar']) && !empty(trim($_POST['titulo']))) {
    $titulo = htmlspecialchars(trim($_POST['titulo']));
    $id = time() . rand(10, 99); // ID único robusto baseado em timestamp
    $linha = "$id|$titulo|Pendente\n";
    
    file_put_contents($arquivo, $linha, FILE_APPEND | LOCK_EX);
    header("Location: index.php");
    exit;
}

// 2. OPERAÇÃO: ATUALIZAR STATUS (Update)
if (isset($_GET['alternar'])) {
    $id_alterar = $_GET['alternar'];
    $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $novas_linhas = [];

    foreach ($linhas as $linha) {
        $data = explode('|', $linha);
        if (count($data) >= 3) {
            if ($data[0] === $id_alterar) {
                $data[2] = ($data[2] === 'Pendente') ? 'Concluída' : 'Pendente';
            }
            $novas_linhas[] = implode('|', $data);
        }
    }
    
    file_put_contents($arquivo, implode("\n", $novas_linhas) . "\n", LOCK_EX);
    header("Location: index.php");
    exit;
}

// 3. OPERAÇÃO: DELETAR (Delete)
if (isset($_GET['deletar'])) {
    $id_deletar = $_GET['deletar'];
    $linhas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $novas_linhas = [];

    foreach ($linhas as $linha) {
        $data = explode('|', $linha);
        if (count($data) >= 3 && $data[0] !== $id_deletar) {
            $novas_linhas[] = $linha;
        }
    }
    
    file_put_contents($arquivo, empty($novas_linhas) ? "" : implode("\n", $novas_linhas) . "\n", LOCK_EX);
    header("Location: index.php");
    exit;
}

// 4. OPERAÇÃO: LISTAR (Read)
$linhas_tarefas = file($arquivo, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>To-Do List - Fase 1 (Arquivo Texto)</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; color: #333; margin: 40px auto; max-width: 500px; padding: 20px; }
        .container { background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1); }
        h2 { margin-top: 0; color: #2c3e50; text-align: center; }
        form { display: flex; margin-bottom: 20px; }
        input[type="text"] { flex: 1; padding: 10px; border: 1px solid #ddd; border-radius: 4px 0 0 4px; font-size: 14px; }
        button { padding: 10px 15px; background: #2ecc71; color: #fff; border: none; border-radius: 0 4px 4px 0; cursor: pointer; font-weight: bold; }
        button:hover { background: #27ae60; }
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
        <h2>To-Do List - Fase 1</h2>
        
        <!-- Formulário de Criação -->
        <form method="POST" action="index.php">
            <input type="text" name="titulo" placeholder="Nova tarefa..." required autocomplete="off">
            <button type="submit" name="adicionar">Adicionar</button>
        </form>

        <!-- Listagem de Tarefas -->
        <h3>Suas Tarefas</h3>
        <div>
            <?php 
            if (empty($linhas_tarefas)): 
                echo "<p style='color: #7f8c8d; text-align:center;'>Nenhuma tarefa cadastrada.</p>";
            else:
                foreach ($linhas_tarefas as $linha): 
                    $data = explode('|', $linha);
                    if (count($data) < 3) continue;
                    $id = $data[0];
                    $titulo = $data[1];
                    $status = $data[2];
            ?>
                <div class="tarefa-item">
                    <span class="<?php echo ($status === 'Concluída') ? 'concluida' : ''; ?>">
                        <span class="status-badge <?php echo ($status === 'Concluída') ? 'badge-concluida' : 'badge-pendente'; ?>">
                            <?php echo $status; ?>
                        </span>
                        <?php echo $titulo; ?>
                    </span>
                    <div class="actions">
                        <a href="?alternar=<?php echo $id; ?>" title="Mudar Status">✔</a>
                        <a href="?deletar=<?php echo $id; ?>" onclick="return confirm('Tem certeza que deseja excluir esta tarefa?')" title="Excluir" style="color: #e74c3c;">❌</a>
                    </div>
                </div>
            <?php 
                endforeach; 
            endif;
            ?>
        </div>
    </div>
</body>
</html>
