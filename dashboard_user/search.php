<?php
include('includes/config.php');
include('includes/header.php');

$search = isset($_GET['search']) ? $_GET['search'] : '';

if ($search) {
    $stmt = $pdo->prepare("SELECT * FROM recipes WHERE title LIKE ? OR ingredients LIKE ?");
    $stmt->execute(['%' . $search . '%', '%' . $search . '%']);
    $recipes = $stmt->fetchAll();
}
?>

<h2>Résultat de recherche</h2>
<div class="card-container">
<?php if ($recipes): ?>
    <?php foreach ($recipes as $recipe): ?>
        <div class="recipe-card">
            <img src="assets/uploads/<?php echo htmlspecialchars($recipe['image']); ?>" alt="">
            <h3><?php echo htmlspecialchars($recipe['title']); ?></h3>
            <a href="view_recipe.php?id=<?php echo $recipe['id']; ?>">Voir Détail</a>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <p>Aucune recette trouvée.</p>
<?php endif; ?>
</div>

<?php include('includes/footer.php'); ?>
