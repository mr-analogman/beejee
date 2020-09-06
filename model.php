<?php
  require_once("dbconnect.php");

  $adminTrue = "admin";
  $passwordTrue = "123";

  function FetchTasks($page, $mysqli, $sortBy = "", $asc = "") {
    $offset = ($page-1)*3;
    $sqlRequest = "SELECT * FROM `Tasks` ";
    $sqlRequest = $sqlRequest.SortTasksBy($sortBy)." ".$asc;
    $sqlRequest = $sqlRequest." LIMIT 3 OFFSET $offset";
    $result_query = $mysqli->query($sqlRequest);

    $tasksArr = array();
    for ($i=0; $i < $result_query->num_rows; $i++) {
      $result_query->data_seek($i);
      $tasksArr[$i] = $result_query->fetch_object();

    }

    return $tasksArr;
  }

  function FetchTask($id, $mysqli) {

    $sqlRequest = "SELECT * FROM `Tasks` WHERE `id`=$id";
    $result_query = $mysqli->query($sqlRequest);
    $result_query->data_seek(0);
    $task = $result_query->fetch_object();

    return $task;
  }

  function SortTasksBy($sortBy) {
    switch ($sortBy) {
      case 'name':
        return "ORDER BY ".$sortBy;
        break;
      case 'email':
        return "ORDER BY ".$sortBy;
        break;
      case 'done':
        return "ORDER BY ".$sortBy;
        break;
      default:
        return "";
        break;
    }
  }

  function NumOfTasks($mysqli) {
    $sqlRequest = "SELECT * FROM `Tasks`";
    $result_query = $mysqli->query($sqlRequest);

    return $result_query->num_rows;
  }

  function AddTask($task, $email, $name, $mysqli) {
    $date=time();
    if ((isset($_POST["submitTaskBtn"])) && (isset($_POST["edit"])) && ($_POST["edit"] == 0)) {
      if ((isset($_POST["task"])) && (isset($_POST["email"])) && (isset($_POST["name"])) && (!empty($_POST["task"])) && (!empty($_POST["email"])) && (!empty($_POST["name"]))) {
        if (preg_match("/^([a-z0-9\+_\-]+)(\.[a-z0-9\+_\-]+)*@([a-z0-9\-]+\.)+[a-z]{2,6}$/ix", $email)) {
          $sqlRequest = "INSERT INTO `Tasks`(`name`, `email`, `task`, `date`) VALUES ('$name','$email','$task','$date')";

          $mysqli->real_query($sqlRequest);

          return [true, ''];

        } else {
          return [false, 'invalid email'];
        }
      } else {
        return [false, 'invalid data'];
      }
    } else {
      //button addtask dosen't exist
    }
  }

  function EditTask($id, $task, $mysqli) {
    if(CheckAdmin()){
      if ((isset($_POST["submitTaskBtn"])) && (isset($_POST["edit"])) && ($_POST["edit"] == 1)) {
        if ((isset($_POST["task"])) && (!empty($_POST["task"]))) {
          $sqlRequest = "UPDATE `Tasks` SET `task`='$task', `changed`=1 WHERE `id`='$id'";

          $mysqli->real_query($sqlRequest);
          return [true, ''];
        } else {
          return [false, 'invalid task data'];
        }
      } else {

        //button submit doesn't exist
      }
    } else {
      return [false, 'youre not logged in!'];
      //invalid admin
    }
  }

  // function DeleteTask() {
  //
  // }

  function DoneTask($id, $mysqli) {
    if(CheckAdmin() ){

      $taskDone = GetTaskIsDone($id, $mysqli);
      if ($taskDone == 0) {
        $taskDone = 1;
      } else {
        $taskDone = 0;
      }

      echo ($taskDone);

      $sqlRequest = "UPDATE `Tasks` SET `done`='$taskDone' WHERE `id`='$id'";
      echo $sqlRequest;
      $mysqli->real_query($sqlRequest);

    } else {
      //invalid admin
    }
  }

  function Auth($login, $password){
    echo $adminTrue.$passwordTrue;
    if (isset($_POST["submitLogin"])) {
      if (CheckAdmin() == false) {
        if (($login == 'admin') && ($password == '123')) {
          setcookie("login", "admin");
          return [true, ''];
        } else {
          return [false, 'Invalid login or password'];
        }
      } else {
        return [false, 'Youre already logged in'];
      }
    } elseif ((isset($_GET["action"])) && ($_GET["action"]=="logout")){
      if (CheckAdmin()) {
        setcookie("login", "", time() -3600);
        return [true, ''];
      } else {
        return [false, 'Youre already logged out'];
      }
    } else {
      //invalid
    }
  }

  function CheckAdmin() {
    if ((isset($_COOKIE["login"])) && ($_COOKIE["login"] == "admin")) {
      return true;
    } else {
      return false;
    }
  }

  function GetTaskIsDone($id, $mysqli) {
    $sqlRequest = "SELECT `done` FROM `Tasks` WHERE `id`='$id'";

    $result_query = $mysqli->query($sqlRequest);
    $result_query->data_seek(0);
    $taskIsDone = $result_query->fetch_object();

    return $taskIsDone->done;
  }

  function CheckTaskIsDone($id) {
    if (CheckAdmin()) {
      if (GetTaskIsDone($id)) {
        return true;
      } else {
        return false;
      }
    }
  }

?>
