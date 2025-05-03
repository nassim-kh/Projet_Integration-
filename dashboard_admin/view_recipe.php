<?php
include('includes/config.php');
include('includes/header.php');

// Vérifier si un id est passé
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
?>
<form action="delete_recipe.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cette recette ?');" style="    text-align: center;
    background: white;
    padding: 20px;
    margin: 20px auto;
    width: 90%;
    max-width: 500px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);">

<div class="recipe-view">
    <h2><?php echo htmlspecialchars($recipe['title']); ?></h2>

    <?php if (!empty($recipe['image'])): ?>
        <img src="assets/uploads/<?php echo htmlspecialchars($recipe['image']); ?>" alt="Image de la recette" style="max-width: 400px; height: auto; border-radius: 8px;">
    <?php else: ?>
        <p><i>Aucune image disponible.</i></p>
    <?php endif; ?>

    <h3>Ingrédients</h3>
    <p><?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></p>

    <h3>Étapes</h3>
    <p><?php echo nl2br(htmlspecialchars($recipe['steps'])); ?></p>

    <h3>Catégorie</h3>
    <p><?php echo htmlspecialchars($recipe['category']); ?></p>

    <!-- Bouton de suppression dans le cadre -->
   
        <input type="hidden" name="id" value="<?php echo $recipe['id']; ?>">
        <button type="submit" style="color: white; background-color: red; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer;">Supprimer</button>
    </form>
</div>

<?php include('includes/footer.php'); ?>
