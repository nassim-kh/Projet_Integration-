<?php
include('includes/config.php');
include('includes/header.php');

// Vérifier si l'id est présent
if (!isset($_GET['id'])) {
    echo "Recette non trouvée.";
    exit;
}

// Récupérer la recette
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->execute([$_GET['id']]);
$recipe = $stmt->fetch();

if (!$recipe) {
    echo "Recette non trouvée.";
    exit;
}

// Si formulaire soumis
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];
    $category = $_POST['category'];

    // Gérer l'image
    $imageName = $recipe['image']; // garder l'ancienne image par défaut
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], 'assets/uploads/' . $imageName);
    }

    $stmt = $pdo->prepare("UPDATE recipes SET title = ?, ingredients = ?, steps = ?, category = ?, image = ? WHERE id = ?");
    $stmt->execute([$title, $ingredients, $steps, $category, $imageName, $_GET['id']]);

    header('Location: index.php');
}
?>

<h2>Modifier Recette</h2>
<form action="" method="POST" enctype="multipart/form-data" style="    text-align: center;
    background: white;
    padding: 20px;
    margin: 20px auto;
    width: 90%;
    max-width: 500px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <h2>titre:</h2>
    <input type="text" name="title" value="<?php echo htmlspecialchars($recipe['title']); ?>" required><br><br>
    <h2>ingredients:</h2>
    <textarea name="ingredients" required><?php echo htmlspecialchars($recipe['ingredients']); ?></textarea><br><br>
    <h2>Etape:</h2>
    <textarea name="steps" required><?php echo htmlspecialchars($recipe['steps']); ?></textarea><br><br>
    <h2>category:</h2>
    <select name="category" required>
        <option value="Entrée" <?php if ($recipe['category'] == 'Entrée') echo 'selected'; ?>>Entrée</option>
        <option value="Plat" <?php if ($recipe['category'] == 'Plat') echo 'selected'; ?>>Plat</option>
        <option value="Dessert" <?php if ($recipe['category'] == 'Dessert') echo 'selected'; ?>>Dessert</option>
    </select><br><br>

    <p>Image actuelle :</p>
    <?php if ($recipe['image']): ?>
        <img src="assets/uploads/<?php echo htmlspecialchars($recipe['image']); ?>" alt="" style="width: 200px;"><br>
    <?php endif; ?>
    <p>Changer l'image :</p>
    <input type="file" name="image"><br><br>

    <button type="submit">Modifier</button>
</form>

<?php include('includes/footer.php'); ?>
