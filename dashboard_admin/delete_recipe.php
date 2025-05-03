<?php
include('includes/config.php'); // Connexion PDO ici

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    try {
        $id = (int)$_POST['id'];

        // Récupérer la recette
        $stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ?");
        $stmt->execute([$id]);
        $recipe = $stmt->fetch();

        if ($recipe) {
            // Supprimer l'image liée
            if (!empty($recipe['image'])) {
                $imagePath = 'assets/uploads/' . $recipe['image'];
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            // Supprimer les commentaires associés
            $stmt = $pdo->prepare("DELETE FROM comments WHERE recipe_id = ?");
            $stmt->execute([$id]);

            // Supprimer la recette
            $stmt = $pdo->prepare("DELETE FROM recipes WHERE id = ?");
            $stmt->execute([$id]);

            // Vérifier si la suppression a réussi
            if ($stmt->rowCount() > 0) {
                $_SESSION['message'] = "Recette supprimée avec succès";
            } else {
                $_SESSION['error'] = "La recette n'a pas pu être supprimée";
            }
        } else {
            $_SESSION['error'] = "Recette introuvable";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Erreur lors de la suppression: " . $e->getMessage();
    }
}

// Redirection vers la page d'accueil
header('Location: index.php');
exit;
?>