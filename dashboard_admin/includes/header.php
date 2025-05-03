<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
<header>
    <h1><a href="index.php"><img src="../5526265.jpg" alt="" srcset="" style=" width: 200px;         /* ou toute autre taille */
  height: 200px;        /* doit être égale à la largeur pour un cercle parfait */
  object-fit: cover;    /* pour que l'image remplisse bien le cercle */
  border-radius: 50%;   /* transforme le carré en cercle */
  overflow: hidden;"></a></h1>
    <nav>
        <a href="index.php">Accueil</a>
        <a href="add_recipe.php">Ajouter Recette</a>
        <a href="../php/logout.php">logout</a><br><br><br>
        <form action="search.php" method="GET" style="display:inline;     text-align: center;
    background: white;
    padding: 20px;
    margin: 20px auto;
    width: 90%;
    height: 400px;
    max-width: 500px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1); " >
            <input type="text" name="search" placeholder="Rechercher ingrédient..." style="    width: 80%;
    padding: 10px;
    margin-top: 5px;
    margin-bottom: 15px;
    border: 1px solid #ccc;
    border-radius: 5px;"   required>
            <button type="submit">Rechercher</button>
        </form>
    </nav>
    <br><br>
    <div>
        <a href="index.php?category=Entrée">Entrées</a> | 
        <a href="index.php?category=Plat">Plats</a> | 
        <a href="index.php?category=Dessert">Desserts</a>
    </div>
</header>
<main>
