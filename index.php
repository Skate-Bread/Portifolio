<!DOCTYPE html>
<html lang="no">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hovedside</title>
    <link rel="icon" href="assets/favicon-32x32.png">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
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
              <li><a href="https://github.com/Skate-Bread" class="nav-link px-3 text-white">Prosjekter</a></li>
              <li><a href="todo.php" class="nav-link px-3 text-white">Todo-liste</a></li>
            </ul>  
            <div class="text-end">
              <a href="login.php"><button type="button" class="btn btn-outline-light me-2">Login</button></a>
              <a href="register.php"><button type="button" class="btn btn-primary">Registrer</button></a>
            </div>
          </div>
        </div>
      </header>

<div class="container py-4 " >
        <div class="p-5 mb-4 bg-light rounded-3 animate__animated animate__slideInDown">
          <div class="container-fluid py-5">
            <h1 class="display-5 fw-bold">Hei, jeg heter Benjamin!</h1>
            <p class="col-md-8 fs-4">Jeg er en kunnskaps??kende gutt som er glad i teknologi. Jeg er spesielt glad i koding. P?? fritiden liker jeg ?? spille, v??re med venner og noe koding.</p>
          </div>
        </div>
    
        <div class="row align-items-md-stretch animate__animated animate__slideInLeft ">
          <div class="col-md-6 ">
            <div class="h-100 p-5 text-bg-dark rounded-3">
              <h2>Sjekk ut prosjektene mine.</h2>
              <p>Jeg har publisert alt jeg har laget p?? fritiden og skolen p?? <a href="https://github.com"><b>Github</b></a>. Trykk p?? knappen under for ?? sjekke ut Github siden min! </p>     
              <a href="https://github.com/Skate-Bread" target="_blank">  <button  class="btn btn-outline-light" type="button">Github siden min!</button> </a>
            </div>
          </div>
        <div class="col-md-6 animate__animated animate__slideInRight">
            <div class="h-100 p-5 text-bg-primary rounded-3">
              <h2>CV</h2>
              <p>Hvis du ??nsker ?? se hva av tiliger erfaring jeg har s?? kan du sjekke ut cven min under!</p>
              <button class="btn btn-dark " type="button">Vis CV</button>
            </div>
          </div>
        </div>
      </div>

<div class="container">
  <footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Hjem</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Om meg</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-muted">Prosjekter</a></li>
    </ul>
    <p class="text-center text-muted">&copy; 2023 Benjamin Bj??rb??k-Hansen <a href="https://github.com/Skate-Bread/Portifolio" target="_blank">source koden</a></p>
  </footer>
</div>
</body>
</html>