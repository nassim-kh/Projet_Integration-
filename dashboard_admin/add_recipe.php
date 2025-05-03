<?php
include('includes/config.php');
include('includes/header.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $ingredients = $_POST['ingredients'];
    $steps = $_POST['steps'];
    $category = $_POST['category'];

    $imageName = '';
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $imageName = time() . '_' . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], 'assets/uploads/' . $imageName);
    }

    $stmt = $pdo->prepare("INSERT INTO recipes (title, ingredients, steps, category, image) VALUES (?, ?, ?, ?, ?)");
    $stmt->execute([$title, $ingredients, $steps, $category, $imageName]);

    header('Location: index.php');
}
?>

<h2>Ajouter une Recette</h2>
<form action="" method="POST" enctype="multipart/form-data" style="    text-align: center;
    background: white;
    padding: 20px;
    margin: 20px auto;
    width: 90%;
    max-width: 500px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);">
    <h2>titre:</h2>
    <input type="text" name="title" placeholder="Titre" required><br>
    <h2>ingrediant:</h2>
    <textarea name="ingredients" placeholder="Ingrédients" required></textarea><br>
    <h2>etapes:</h2>
    <textarea name="steps" placeholder="Étapes" required></textarea><br>
    <h2>category:</h2>
    <select name="category" required>
        <option value="Entrée">Entrée</option>
        <option value="Plat">Plat</option>
        <option value="Dessert">Dessert</option>
    </select><br>
    <input type="file" name="image" required><br><br>
    <button type="submit">Ajouter</button>
</form>

<?php include('includes/footer.php'); ?>
