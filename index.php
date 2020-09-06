<?php
  require('dbconnect.php');
  require('model.php');
  session_start();
  // ini_set('display_errors', 1); ini_set('display_startup_errors', 1); error_reporting(E_ALL);
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <?php require('components/head.php');?>
  </head>
  <header>
    <?php require('components/header.php');?>
  </header>
  <body>
    <?php
    // require('components/body-addtask.php');

      switch ($_GET['page']) {
        case 'home':
          $filename = 'body.php';
          break;

        case 'login':
          $filename = 'body-login.php';
          break;

        case 'addtask':
          $filename = 'body-addtask.php';
          break;

        case 'edittask':
          $filename = 'body-addtask.php';
          break;

        default:
          print_r($_GET);
          die('Wrong page parameter.');
          break;
      }

      require('components/'.$filename);

    ?>
  </body>
  <footer>
    <?php require('components/footer.php');?>
  </footer>
</html>

<?php $mysqli->close();?>
