<?php
session_start();
include('includes/config.php'); // Assure-toi que ce chemin est correct !

// On vérifie si le formulaire est soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $recipe_id = (int)$_POST['recipe_id']; // ID de la recette
    $rating = (int)$_POST['rating']; // Note donnée
    $comment = trim($_POST['comment']); // Commentaire

    if ($recipe_id && $rating >= 1 && $rating <= 5 && !empty($comment)) {
        try {
            // Insertion du commentaire dans la base de données
            $stmt = $pdo->prepare("INSERT INTO comments (recipe_id, rating, comment) VALUES (:recipe_id, :rating, :comment)");
            $stmt->execute([
                'recipe_id' => $recipe_id,
                'rating' => $rating,
                'comment' => $comment,
            ]);
            $_SESSION['message'] = "Commentaire ajouté avec succès.";
        } catch (PDOException $e) {
            $_SESSION['error'] = "Erreur lors de l'ajout du commentaire : " . $e->getMessage();
        }
    } else {
        $_SESSION['error'] = "Veuillez remplir tous les champs correctement.";
    }

    // Redirection après soumission
    header('Location: view_recipe.php?id=' . $recipe_id);
    exit;
}
?>
