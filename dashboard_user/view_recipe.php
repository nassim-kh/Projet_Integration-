<?php
session_start();
include('includes/config.php');
include('includes/header.php'); 

// Vérifier si un ID est passé dans l'URL
if (!isset($_GET['id']) || empty($_GET['id'])) {
    echo "Recette non trouvée.";
    exit;
}

$recipe_id = (int)$_GET['id'];

// Récupérer la recette
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->execute([$recipe_id]);
$recipe = $stmt->fetch();

// Vérifier si la recette existe
if (!$recipe) {
    echo "Recette non trouvée.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($recipe['title']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f9f9f9;
            padding: 20px;
        }
        .recipe-container {
            
            background: #fff;
            padding: 20px;
            max-width: 800px;
            margin: auto;
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .rating {
            display: flex;
            justify-content: center;
            padding-bottom: 15px;
        }
        .rating input {
            display: none;
        }
        .rating label {
            font-size: 30px;
            color: #ccc;
            cursor: pointer;
            transition: color 0.2s;
        }
        .rating input:checked ~ label,
        .rating label:hover,
        .rating label:hover ~ label {
            color: gold;
        }
        .rating label:hover {
            color: gold;
        }
        .message {
            text-align: center;
            margin-bottom: 15px;
            padding: 10px;
            border-radius: 8px;
        }
        .message.success {
            background-color: #d4edda;
            color: #155724;
        }
        .message.error {
            background-color: #f8d7da;
            color: #721c24;
        }
        .comment-box {
            margin-top: 20px;
        }
        .comment-box textarea {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border-radius: 8px;
            border: 1px solid #ccc;
            resize: vertical;
        }
        .comment-box button {
            background-color: #28a745;
            border: none;
            padding: 10px 20px;
            margin-top: 15px;
            color: white;
            border-radius: 8px;
            cursor: pointer;
        }
        .comment-box button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="recipe-container">
    <h1><?php echo htmlspecialchars($recipe['title']); ?></h1>

    <?php if (!empty($recipe['image'])): ?>
        <img src="../dashboard_admin/assets/uploads/<?php echo htmlspecialchars($recipe['image']); ?>" alt="Image de la recette" style="max-width: 400px; height: auto; border-radius: 8px;">
    <?php else: ?>
        <p><i>Aucune image disponible.</i></p>
    <?php endif; ?>

    <h3>Ingrédients</h3>
    <p><?php echo nl2br(htmlspecialchars($recipe['ingredients'])); ?></p>

    <h3>Étapes</h3>
    <p><?php echo nl2br(htmlspecialchars($recipe['steps'])); ?></p>

    <h3>Catégorie</h3>
    <p><?php echo htmlspecialchars($recipe['category']); ?></p>

    <h3>Commentaires</h3>
    <?php
    // Récupérer les commentaires pour cette recette
    $stmt_comments = $pdo->prepare("SELECT * FROM comments WHERE recipe_id = ? ORDER BY created_at DESC");
    $stmt_comments->execute([$recipe_id]);
    $comments = $stmt_comments->fetchAll();

    if (count($comments) > 0) {
        foreach ($comments as $comment) {
            echo "<div>";
            echo "<strong>Note: " . $comment['rating'] . "★</strong><br>";
            echo "<p>" . htmlspecialchars($comment['comment']) . "</p>";
            echo "<small>Posté le " . $comment['created_at'] . "</small><br>";
            echo "</div><hr>";
        }
    } else {
        echo "<p>Aucun commentaire pour cette recette.</p>";
    }
    ?>

    <div class="comment-box">
        <h3>Laisser un commentaire</h3>
        <form action="comment_recipe.php" method="POST">
            <input type="hidden" name="recipe_id" value="<?php echo htmlspecialchars($recipe_id); ?>">

            <div class="rating">
                <?php for ($i = 5; $i >= 1; $i--): ?>
                    <input type="radio" id="star<?php echo $i; ?>" name="rating" value="<?php echo $i; ?>" required>
                    <label for="star<?php echo $i; ?>">★</label>
                <?php endfor; ?>
            </div>

            <textarea name="comment" rows="5" placeholder="Écrivez votre commentaire..." required></textarea>

            <button type="submit">Envoyer</button>
        </form>
    </div>
</div>

</body>
</html>

<?php include('includes/footer.php'); ?>