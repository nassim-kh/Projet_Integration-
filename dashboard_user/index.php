<?php
include('includes/config.php');
include('includes/header.php');

$filter = isset($_GET['category']) ? $_GET['category'] : '';
$query = "SELECT * FROM recipes";
if ($filter) {
    $query .= " WHERE category = ?";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$filter]);
} else {
    $stmt = $pdo->query($query);
}
$recipes = $stmt->fetchAll();
?>

<h2>Recettes</h2>
<div class="card-container">
<?php foreach ($recipes as $recipe): ?>
    <div class="recipe-card">
        <img src="../dashboard_admin/assets/uploads/<?php echo htmlspecialchars($recipe['image']); ?>" alt="">
        <h3><?php echo htmlspecialchars($recipe['title']); ?></h3>

        <a href="view_recipe.php?id=<?php echo $recipe['id']; ?>">Voir Détail</a><br>
        

        <!-- FORMULAIRE SUPPRIMER CORRIGÉ -->
        <form action="delete_recipe.php" method="POST" style="display:inline;">
            <input type="hidden" name="id" value="<?php echo $recipe['id']; ?>">
            
        </form>
    </div>
<?php endforeach; ?>
</div>

<?php include('includes/footer.php'); ?>