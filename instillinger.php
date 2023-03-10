<?php
// Start sessjonen
session_start();
 
// Sjekker om brukeren er logget inn hvis de ikke er det så vill en omdirigere dem til hoved siden!
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>

<?php

//resett passord
// Inkluder config fila 
require_once "config.php";
 
// Definer variable
$new_password = $gjenta_passord = "";
$new_password_err = $confirm_password_err = "";
 
// Prosseser data når bruker sender in form
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // valider nytt passord
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Vennlingst skriv inn et passord";     
    } elseif(strlen(trim($_POST["new_password"])) < 8){
        $new_password_err = "Passordet må ha minst 8 tegn!";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Valider gjenta passord
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Vennligst gjenta passordet.";
    } else{
        $gjenta_passord = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $gjenta_passord)){
            $confirm_password_err = "Passordene var ikke like.";
        }
    }
        
    // sjekk input error før vi putter den i databasen
    if(empty($new_password_err) && empty($confirm_password_err)){
        // gjør klar et "prepare statment"
        $sql = "UPDATE users SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variabelene til "prepare statmentet"
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parametere
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // prøv og utfør inputen
            if(mysqli_stmt_execute($stmt)){
                // passordet ble endret og omdiriger til login siden
                session_destroy();
                header("location: login.php");
                exit();
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // likk statmentet
            mysqli_stmt_close($stmt);
        }
    }
    
    // lukk tilkobling.
    mysqli_close($link);
}
?>

<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Instillinger</title>
    <link rel="icon" href="assets/favicon-32x32.png">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>
<body>
    <header class="p-3 text-bg-dark">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="welcome.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
              <img src="assets/b.jpg" height="60px" style="padding-right: 30px">
            </a>
    
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
              <li><a href="welcome.php" class="nav-link px-3 text-secondary">Hjem</a></li>
              <li><a href="#" class="nav-link px-3 text-white">Om meg</a></li>
              <li><a href="#" class="nav-link px-3 text-white">Projekter</a></li>
            </ul>  
            <div class="text-end">
            <a href="welcome.php"><button type="button" class="btn btn-light me-2">Tibake</button></a>
              <a href="logout.php"><button type="button" class="btn btn-primary">Logg ut</button></a>
            </div>
          </div>
        </div>
      </header>

    <h1 class="text-center" style="padding: 20px">Hei, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b> 👋🏻</h1>
<div class="col-md-12 text-center" style="padding-bottom: 20px">
    <a href="logout.php" class="btn btn-danger">Logg ut av brukeren din.</a>
</div>


<center>
<div class="wrapper p-5 mb-4 bg-light rounded-3" style="padding-top: 30px">
    <h2>Reset Passord</h2>
    <p>Fyll ut dette for å resette passordet ditt!.</p>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
        <div class="form-group col-md-3">
            <label>Nytt passord</label>
            <input type="password" name="new_password" class="form-control <?php echo (!empty($new_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $new_password; ?>">
            <span class="invalid-feedback"><?php echo $new_password_err; ?></span>
        </div>
        <div class="form-group col-md-3">
            <label>Gjenta passord</label>
            <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
        </div>
        <div class="form-group">
            <input type="submit" class="btn btn-primary" value="Submit">
        </div>
    </form>
</div>
</center>
  
</body>