<?php
// Start sessjon
session_start();

$conn = mysqli_connect('localhost:3306', 'elev21imben2302', 'Skien2204!', 'webhotel_elev21imben2302');

if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
  header("location: login.php");
  exit;
}


// Sjekk om skjema sendes inn
if (isset($_POST['add_task'])) {
  // Hent skjema data
  $user_id = $_SESSION['id'];
  $task = $_POST['task'];


  // gjør klar et sql statment 
  $stmt = mysqli_prepare($conn, "INSERT INTO todos (user_id, task) VALUES (?, ?)");
  mysqli_stmt_bind_param($stmt, "is", $user_id, $task);

  // Utfør klargjort statment
  mysqli_stmt_execute($stmt);

  // Send tilbake til todo siden
  header('Location: todo.php');
  exit;
}

//Hent oppgavene til brukeren som er logget inn
$user_id = $_SESSION['id'];
$stmt = mysqli_prepare($conn, "SELECT * FROM todos WHERE user_id = ?");
mysqli_stmt_bind_param($stmt, "i", $user_id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$tasks = mysqli_fetch_all($result, MYSQLI_ASSOC);



if (isset($_POST['change_status'])) {
  $task_id = $_POST['task_id'];
  
  // Hent oppgaven fra databasen
  $stmt = mysqli_prepare($conn, "SELECT * FROM todos WHERE id = ?");
  mysqli_stmt_bind_param($stmt, "i", $task_id);
  mysqli_stmt_execute($stmt);
  $result = mysqli_stmt_get_result($stmt);
  $task = mysqli_fetch_assoc($result);
  
  // Oppdater statusen
  $new_status = $task['Ferdig'] ? 0 : 1;
  $stmt = mysqli_prepare($conn, "UPDATE todos SET Ferdig = ? WHERE id = ?");
  mysqli_stmt_bind_param($stmt, "ii", $new_status, $task_id);
  mysqli_stmt_execute($stmt);
  
  // Send tilbake til todo siden
  header('Location: todo.php');
  exit;
}

?>




<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Todo</title>

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet"
     integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
  <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js" 
    integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN" crossorigin="anonymous"></script>
</head>
<body>

<header class="p-3 text-bg-dark animate__animated animate__fadeIn">
        <div class="container">
          <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
            <a href="welcome.php" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
              <img src="../assets/b.jpg" height="60px" style="padding-right: 30px">
            </a>
    
            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
              <li><a href="welcome.php" class="nav-link px-3 text-secondary">Hjem</a></li>
              <li><a href="#" class="nav-link px-3 text-white">Om meg</a></li>
              <li><a href="#" class="nav-link px-3 text-white">Prosjekter</a></li>
              <li><a href="todo.php" class="nav-link px-3 text-white">Todo-liste</a></li>
            </ul>  
            <div class="text-end">
            <a href="instillinger.php"><button type="button" class="btn btn-outline-light me-2"><?php echo htmlspecialchars($_SESSION["username"]);?></button></a>
              <a href="logout.php"><button type="button" class="btn btn-primary">Logg ut</button></a>
            </div>
          </div>
        </div>
</header>


  <div class="container my-5">
    <h1 class="mb-3">Hei, <?php echo htmlspecialchars($_SESSION["username"]);?>!<br> Velkommen til din todo liste.</h1>

    <form method="post" class="form-inline my-3">
      <div class="form-group mr-2">
        <input type="text" class="form-control" name="task" placeholder="Ny oppgave">
      </div>
      <button type="submit" class="btn btn-primary" name="add_task">Legg til</button>
    </form>

    <table class="table">
      <thead>
        <tr>
          <th>Oppgave</th>
          <th>Status</th>
          <th>Handling</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($tasks as $task) { ?>
          <tr>
            <td>
              <form method="post">
                <div class="form-check">
                  <input type="hidden" name="status" value="<?php echo $task['status'] ? '0' : '1'; ?>">
                  <label class="form-check-label <?php echo $task['Ferdig'] ? 'completed-task' : ''; ?>"><?php echo $task['task']; ?></label>
                </div>
                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
              </form>
            </td>
            <td>
             <?php echo $task['Ferdig'] ? '<p style="color: green;">Ferdig</p>' : '<p style="color: red;">Uferdig</p>'; ?>
            </td>
            <td>
              <form method="post">
                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                <input type="hidden" name="change_status" value="1">
                <button type="submit" class="btn btn-primary">
                  <?php echo $task['Ferdig'] ? 'Marker som uferdig' : 'Marker som ferdig'; ?>
                </button>
              </form>
              <form method="post" action="delete_task.php" class="float-right">
                <input type="hidden" name="task_id" value="<?php echo $task['id']; ?>">
                <button type="submit" class="btn btn-danger" name="delete_task">Slett</button>
              </form> 
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</body>
</html>
