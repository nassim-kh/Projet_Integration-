<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Register</title>
</head>
<body>
      <div class="container">
        <div class="box form-box">

        <?php 
         
         include("php/config.php");
         if(isset($_POST['submit'])){
            $username = $_POST['username'];
            $email = $_POST['email'];
            $age = $_POST['age'];
            $password = MD5($_POST['password']);

            // Vérification que l'email se termine bien par @gmail.com
            if (substr($email, -10) !== '@gmail.com') {
                echo "<div class='message'>
                        <p>L'email doit se terminer par @gmail.com</p>
                      </div> <br>";
                echo "<a href='javascript:self.history.back()'><button class='btn'>Retour</button>";
            } else {

                // Vérification de l'email unique
                $verify_query = mysqli_query($con,"SELECT Email FROM users WHERE Email='$email'");

                if(mysqli_num_rows($verify_query) != 0 ){
                    echo "<div class='message'>
                            <p>Cet email est déjà utilisé, essayez-en un autre !</p>
                          </div> <br>";
                    echo "<a href='javascript:self.history.back()'><button class='btn'>Retour</button>";
                }
                else {
                    mysqli_query($con,"INSERT INTO users(Username,Email,Age,Password) VALUES('$username','$email','$age','$password')") or die("Erreur lors de l'enregistrement");

                    echo "<div class='message'>
                            <p>Enregistrement réussi !</p>
                          </div> <br>";
                    echo "<a href='index.php'><button class='btn'>Se connecter maintenant</button>";
                }
            }

         } else {
         
        ?>

            <header>Sign Up</header>
            <form action="" method="post">
                <div class="field input">
                    <label for="username">Nom d'utilisateur</label>
                    <input type="text" name="username" id="username" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="age">Âge</label>
                    <input type="number" name="age" id="age" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="password">Mot de passe</label>
                    <input type="password" name="password" id="password" autocomplete="off" required>
                </div>

                <div class="field">
                    <input type="submit" class="btn" name="submit" value="S'inscrire" required>
                </div>
                <div class="links">
                    Déjà membre ? <a href="index.php">Se connecter</a>
                </div>
            </form>
        </div>
        <?php } ?>
      </div>
</body>
</html>
