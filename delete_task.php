<?php
// Start sessjon
session_start();

// Sjekker om brukeren er logget in
if (!isset($_SESSION['id'])) {
  header('Location: login.php');
  exit;
}

// Koble til databasen
$conn = mysqli_connect('localhost:3306', 'elev21imben2302', 'Skien2204!', 'webhotel_elev21imben2302');

// Sjekker om et skjma er sendt inn
if (isset($_POST['delete_task'])) {
  // henter data fra skjemaet
  $task_id = $_POST['task_id'];

  // Gjør klar en sql spørring
  $stmt = mysqli_prepare($conn, "DELETE FROM todos WHERE id = ?");
  mysqli_stmt_bind_param($stmt, "i", $task_id);

  // kjører sql spørringa
  if (mysqli_stmt_execute($stmt)) {
    // sender til todo.php siden
    header('Location: todo.php');
    exit;
  } else {
    // skriver ut hvis det er en feil
    echo "Error i sletting av oppgave:  " . mysqli_error($conn);
  }
} else {
  // id feil
  echo "Feil ID";
}
