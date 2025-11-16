<?php
require '../db/conexao.php';

$message = '';
$error = '';


$upload_dir = '../assets/img/uploads/';
if (!is_dir($upload_dir)) {
    mkdir($upload_dir, 0755, true);
}

// add
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'create') {
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
    $tempo = mysqli_real_escape_string($conn, $_POST['tempo']);
    $pessoas = mysqli_real_escape_string($conn, $_POST['pessoas']);
    $nivel = mysqli_real_escape_string($conn, $_POST['nivel']);
    $tags = mysqli_real_escape_string($conn, $_POST['tags']);
    $ingredientes = mysqli_real_escape_string($conn, $_POST['ingredientes']);
    $modo_preparo = mysqli_real_escape_string($conn, $_POST['modo_preparo']);
    

    $thumbnail = '';
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
        $file_name = time() . '_' . basename($_FILES['imagem']['name']);
        $file_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $file_path)) {
            $thumbnail = 'assets/img/uploads/' . $file_name;
        } else {
            $error = "Erro ao fazer upload da imagem.";
        }
    }
    
    if (!$error) {
        $sql = "INSERT INTO receitas (titulo, descricao, thumbnail, tempo, pessoas, nivel, tags, ingredientes, modo_preparo) 
                VALUES ('$titulo', '$descricao', '$thumbnail', '$tempo', '$pessoas', '$nivel', '$tags', '$ingredientes', '$modo_preparo')";
        
        if (mysqli_query($conn, $sql)) {
            $message = "Receita adicionada com sucesso!";
        } else {
            $error = "Erro ao adicionar receita: " . mysqli_error($conn);
        }
    }
}

// Edit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'update') {
    $id = intval($_POST['id']);
    $titulo = mysqli_real_escape_string($conn, $_POST['titulo']);
    $descricao = mysqli_real_escape_string($conn, $_POST['descricao']);
    $tempo = mysqli_real_escape_string($conn, $_POST['tempo']);
    $pessoas = mysqli_real_escape_string($conn, $_POST['pessoas']);
    $nivel = mysqli_real_escape_string($conn, $_POST['nivel']);
    $tags = mysqli_real_escape_string($conn, $_POST['tags']);
    $ingredientes = mysqli_real_escape_string($conn, $_POST['ingredientes']);
    $modo_preparo = mysqli_real_escape_string($conn, $_POST['modo_preparo']);
    
    
    $result = mysqli_query($conn, "SELECT thumbnail FROM receitas WHERE id=$id");
    $receita = mysqli_fetch_assoc($result);
    $thumbnail = $receita['thumbnail'];
    
    
    if (isset($_FILES['imagem']) && $_FILES['imagem']['error'] == UPLOAD_ERR_OK) {
        
        if ($thumbnail && file_exists('../' . $thumbnail)) {
            unlink('../' . $thumbnail);
        }
        
        $file_name = time() . '_' . basename($_FILES['imagem']['name']);
        $file_path = $upload_dir . $file_name;
        
        if (move_uploaded_file($_FILES['imagem']['tmp_name'], $file_path)) {
            $thumbnail = 'assets/img/uploads/' . $file_name;
        } else {
            $error = "Erro ao fazer upload da imagem.";
        }
    }
    
    if (!$error) {
        $sql = "UPDATE receitas SET titulo='$titulo', descricao='$descricao', thumbnail='$thumbnail', 
                tempo='$tempo', pessoas='$pessoas', nivel='$nivel', tags='$tags', ingredientes='$ingredientes', modo_preparo='$modo_preparo' WHERE id=$id";
        
        if (mysqli_query($conn, $sql)) {
            $message = "Receita atualizada com sucesso!";
        } else {
            $error = "Erro ao atualizar receita: " . mysqli_error($conn);
        }
    }
}

// Delete
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'delete') {
    $id = intval($_POST['id']);
    
   
    $result = mysqli_query($conn, "SELECT thumbnail FROM receitas WHERE id=$id");
    $receita = mysqli_fetch_assoc($result);
    
    if ($receita['thumbnail'] && file_exists('../' . $receita['thumbnail'])) {
        unlink('../' . $receita['thumbnail']);
    }
    
    $sql = "DELETE FROM receitas WHERE id=$id";
    
    if (mysqli_query($conn, $sql)) {
        $message = "Receita deletada com sucesso!";
    } else {
        $error = "Erro ao deletar receita: " . mysqli_error($conn);
    }
}


$edit_receita = null;
if (isset($_GET['edit'])) {
    $id = intval($_GET['edit']);
    $result = mysqli_query($conn, "SELECT * FROM receitas WHERE id=$id");
    $edit_receita = mysqli_fetch_assoc($result);
}

// listar receitas
$receitas = mysqli_query($conn, "SELECT * FROM receitas ORDER BY id DESC");
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/crud.css">
    <title>CRUD - Gerenciar Receitas</title>
    
</head>
<body>
    <div class="container">
        <h1>CRUD - Gerenciar Receitas</h1>

        <?php if ($message): ?>
            <div class="message success"><?php echo $message; ?></div>
        <?php endif; ?>

        <?php if ($error): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>

        <div class="crud-container">
            <div class="form-section">
                <h2><?php echo $edit_receita ? 'Editar Receita' : 'Adicionar Nova Receita'; ?></h2>
                <form method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="<?php echo $edit_receita ? 'update' : 'create'; ?>">
                    <?php if ($edit_receita): ?>
                        <input type="hidden" name="id" value="<?php echo $edit_receita['id']; ?>">
                    <?php endif; ?>

                    <div class="form-group">
                        <label for="titulo">Título</label>
                        <input type="text" id="titulo" name="titulo" required value="<?php echo $edit_receita['titulo'] ?? ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="descricao">Descrição</label>
                        <textarea id="descricao" name="descricao" required><?php echo $edit_receita['descricao'] ?? ''; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="imagem">Foto da Receita</label>
                        <input type="file" id="imagem" name="imagem" accept="image/*">
                        <?php if ($edit_receita && $edit_receita['thumbnail']): ?>
                            <p style="font-size: 0.9rem; color: #666; margin-top: 5px;">
                                📷 Imagem atual salva no banco
                            </p>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="tags">Tags</label>
                        <input type="text" id="tags" name="tags" placeholder="ex: doce, rápido, sobremesa" value="<?php echo $edit_receita['tags'] ?? ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="ingredientes">Ingredientes (um por linha)</label>
                        <textarea id="ingredientes" name="ingredientes" placeholder="Farinha&#10;Açúcar&#10;Ovos"><?php echo $edit_receita['ingredientes'] ?? ''; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="modo_preparo">Modo de Preparo (um passo por linha)</label>
                        <textarea id="modo_preparo" name="modo_preparo" placeholder="Passo 1...&#10;Passo 2...&#10;Passo 3..."><?php echo $edit_receita['modo_preparo'] ?? ''; ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="tempo">Tempo</label>
                        <input type="text" id="tempo" name="tempo" placeholder="ex: 45 min" value="<?php echo $edit_receita['tempo'] ?? ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="pessoas">Pessoas</label>
                        <input type="text" id="pessoas" name="pessoas" placeholder="ex: 8 porções" value="<?php echo $edit_receita['pessoas'] ?? ''; ?>">
                    </div>

                    <div class="form-group">
                        <label for="nivel">Nível de Dificuldade</label>
                        <select id="nivel" name="nivel">
                            <option value="">Selecione...</option>
                            <option value="Fácil" <?php echo ($edit_receita['nivel'] ?? '') == 'Fácil' ? 'selected' : ''; ?>>Fácil</option>
                            <option value="Médio" <?php echo ($edit_receita['nivel'] ?? '') == 'Médio' ? 'selected' : ''; ?>>Médio</option>
                            <option value="Difícil" <?php echo ($edit_receita['nivel'] ?? '') == 'Difícil' ? 'selected' : ''; ?>>Difícil</option>
                        </select>
                    </div>

                    <div class="button-group">
                        <button type="submit" class="btn btn-primary">
                            <?php echo $edit_receita ? 'Atualizar' : 'Adicionar'; ?>
                        </button>
                        <?php if ($edit_receita): ?>
                            <a href="crud.php" class="btn btn-secondary">Cancelar</a>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="receitas-list">
                <h2>Receitas Cadastradas (<?php echo mysqli_num_rows($receitas); ?>)</h2>
                
                <?php
                mysqli_data_seek($receitas, 0);
                while ($receita = mysqli_fetch_assoc($receitas)):
                ?>
                    <div class="receita-item">
                        <div>
                            <h3><?php echo htmlspecialchars($receita['titulo']); ?></h3>
                            <p><strong>Tempo:</strong> <?php echo htmlspecialchars($receita['tempo']); ?></p>
                            <p><strong>Nível:</strong> <?php echo htmlspecialchars($receita['nivel']); ?></p>
                        </div>
                        <div class="receita-actions">
                            <a href="crud.php?edit=<?php echo $receita['id']; ?>" class="btn-edit">Editar</a>
                            <form method="POST" style="display: inline;" onsubmit="return confirm('Tem certeza que deseja deletar?');">
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="id" value="<?php echo $receita['id']; ?>">
                                <button type="submit" class="btn-delete">Deletar</button>
                            </form>
                        </div>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>

        <div style="margin-top: 40px; text-align: center;">
            <a href="../index.php" class="back-link">Voltar</a>
        </div>
    </div>
</body>
</html>

<?php mysqli_close($conn); ?>
