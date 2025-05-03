<?php 
   session_start();
   include("includes/header.php");
    
   include("../php/config.php");
   if(!isset($_SESSION['valid'])){
       header("Location: index.php");
   }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Change Profile</title>
</head>
<body>

    <div class="container">
        <div class="box form-box">
            <?php 
               if(isset($_POST['submit'])){
                $username = $_POST['username'];
                $email = $_POST['email'];
                $age = $_POST['age'];

                // Validation de l'email pour s'assurer qu'il se termine par @gmail.com
                if (substr($email, -10) !== '@gmail.com') {
                    echo "<div class='message'>
                            <p>L'email doit se terminer par @gmail.com</p>
                          </div> <br>";
                          
                } else {
                    // Si l'email est valide, mettre à jour le profil
                    $id = $_SESSION['id'];

                    $edit_query = mysqli_query($con,"UPDATE users SET Username='$username', Email='$email', Age='$age' WHERE Id=$id ") or die("Erreur lors de la mise à jour");

                    if($edit_query){
                        echo "<div class='message'>
                        <p>Profile Updated!</p>
                    </div> <br>";
                        
                    }
                }
               } else {

                $id = $_SESSION['id'];
                $query = mysqli_query($con,"SELECT*FROM users WHERE Id=$id ");

                while($result = mysqli_fetch_assoc($query)){
                    $res_Uname = $result['Username'];
                    $res_Email = $result['Email'];
                    $res_Age = $result['Age'];
                }

            ?>
            <header>Change Profile</header>
            <form action="" method="post" style="
    text-align: center;
    background: white;
    padding: 20px;
    margin: 20px auto;
    width: 90%;
    max-width: 500px;
    border-radius: 10px;
    box-shadow: 0 0 10px rgba(0,0,0,0.1);
">
                <div class="field input">
                    <label for="username">Username</label>
                    <input type="text" name="username" id="username" value="<?php echo $res_Uname; ?>" autocomplete="off" required>
                </div>

                <div class="field input">
                    <label for="email">Email</label>
                    <input type="text" name="email" id="email" value="<?php echo $res_Email; ?>" autocomplete="off"  required>
                </div>

                <div class="field input">
                    <label for="age">Age</label>
                    <input type="number" name="age" id="age" value="<?php echo $res_Age; ?>" autocomplete="off" required>
                </div>
                
                <div class="field">
                    <input type="submit" class="btn" name="submit" value="Update" required>
                </div>
                
            </form>
        </div>
        <?php } ?>
      </div>

</body>
</html>
<?php include("includes/footer.php"); ?>


