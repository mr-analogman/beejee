<?php
require("dbconnect.php");
session_start();

require("model.php");

$admin = $_POST["login"];
$password = $_POST["password"];

$task = $_POST["task"];
$email = $_POST["email"];
$name = $_POST["name"];
$id = $_POST["id"];

if ((isset($_POST["submitLogin"])) || ((isset($_GET["action"])) && ($_GET["action"]=="logout"))) {
  $logged=Auth($admin, $password);
  if ($logged[0]) {
    header("Location: /beejee");
  } else {
    $_SESSION["error"] = $logged[1];
    header("Location: /beejee/login");

  }
} elseif ((isset($_POST["submitTaskBtn"])) && (isset($_POST["edit"])) && ($_POST["edit"] == 0)) {
  $tasked=AddTask($task, $email, $name, $mysqli);
  if ($tasked[0]) {
    header("Location: /beejee");
  } else {
    $_SESSION["error"] = $tasked[1];
    header("Location: /beejee/addtask");
  }
} elseif ((isset($_POST["submitTaskBtn"])) && (isset($_POST["edit"])) && ($_POST["edit"] == 1)) {
  $tasked=EditTask($id, $task, $mysqli);
  if ($tasked[0]) {
    header("Location: /beejee");
  } else {
    $_SESSION["error"] = $tasked[1];
    header("Location: /beejee/edittask/$id");
  }

} elseif ((isset($_GET["action"])) && ($_GET["action"]=="markAsDone")) {
  DoneTask($_GET["id"], $mysqli);
  header("Location: /beejee");
} else {
  header("Location: /beejee");
}


?>
