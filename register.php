<?php
// inkluder konfigurasjons filen
require_once "config.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
//  Prosseser informasjon fra klient siden
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Valider bruker navn
    if(empty(trim($_POST["username"]))){
        $username_err = "Vennligst skriv inn et brukernavn.";
    } elseif(!preg_match('/^[a-zA-Z0-9_-]+$/', trim($_POST["username"]))){
        $username_err = "Brukernavnet kan bare inneholde bokstaver, nummer, bindestre og understrek.";
    } else{
        // Gjør klar et "Select Statment"
        $sql = "SELECT id FROM users WHERE username = ?";
        
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variabler til den forberedte setningen som parametere
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parametere
            $param_username = trim($_POST["username"]);
            
            // Kjør den klargjorte "Select Statmenten"
            if(mysqli_stmt_execute($stmt)){
               // Lagre resultat
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Dette brukernavnet er allerede i bruk!";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Oops! Noe gikk galt, prøv igjen senere!";
            }

            // Lukk stament
            mysqli_stmt_close($stmt);
        }
    }
    
    // Valider passord
    if(empty(trim($_POST["password"]))){
        $password_err = "Vennligst skriv inn et passord.";     
    } elseif(strlen(trim($_POST["password"])) < 8){
        $password_err = "Passordet må være minst 8 tegn!";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Valider gjenta passord
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Vennligst gjenta passordet.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Passordene var ikke like.";
        }
    }
    
    // Sjekk alle inputs før vi setter det inn i databasen
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Gjør klar et "Select Statment"
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = mysqli_prepare($link, $sql)){
            // Bind variabler til den forberedte setningen som parametere
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
            
            // Set parametere
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Lager et kryptert passord
            
            // Kjør den klargjorte "Select Statmenten"
            if(mysqli_stmt_execute($stmt)){
                // omdiriger til login siden
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Lukk statement
            mysqli_stmt_close($stmt);
        }
    }
    
    // Kobble fra databasen
    mysqli_close($link);
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Registrer</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>

      <header class="p-3 text-bg-dark">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
              <img src="assets/b.jpg" height="60px" style="padding-right: 30px">
            </a>
    
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
              <li><a href="index.php" class="nav-link px-3 text-secondary">Hjem</a></li>
              <li><a href="#" class="nav-link px-3 text-white">Om meg</a></li>
              <li><a href="#" class="nav-link px-3 text-white">Prosjekter</a></li>
            </ul>  
            <div class="text-end">
              <a href="login.php"><button type="button" class="btn btn-outline-light me-2">Login</button></a>
              <a href="register.php"><button type="button" class="btn btn-primary">Registrer</button></a>
            </div>
          </div>
        </div>
      </header>
    <center>
    <div class="wrapper">
        <h2>Registrer</h2>
        <p>Fyll inn feltene under for å lage en bruker</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Brukernavn</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Passord</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Gjenta passord</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Registrer">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Har du allerede en bruker? <a href="login.php">Login her</a>!</p>
        </form>
    </div

    </center>
