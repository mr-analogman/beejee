<main role="main" class="container-sm p-0">

  <?php session_start();
  print_r ($_SESSION["msg"]);
  // if (isset($_SESSION["error"]) {
  //         echo $_SESSION["error"];
  //         unset($_SESSION["error"]);
  //       }
  unset($_SESSION["msg"]);
  ?>

  <div class="container d-flex justify-content-between mt-5 p-0">
    <div class="dropdown">
      <a class="btn btn-outline-dark dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Sort by
      </a>

      <?php
      $url_addition = '?';
      if($_GET['num']){
        $url_addition .= 'num='.$_GET['num'].'&';
      }
      ?>

      <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
        <a class="dropdown-item" href="<?php echo $url_addition;?>sort=name">Name Ascending</a>
        <a class="dropdown-item" href="<?php echo $url_addition;?>sort=name_desc">Name Descending</a>
        <a class="dropdown-item" href="<?php echo $url_addition;?>sort=email">E-mail Ascending</a>
        <a class="dropdown-item" href="<?php echo $url_addition;?>sort=email_desc">E-mail Descending</a>
        <a class="dropdown-item" href="<?php echo $url_addition;?>sort=done">Done Ascending</a>
        <a class="dropdown-item" href="<?php echo $url_addition;?>sort=done_desc">Done Descending</a>
      </div>
    </div>

    <a href="addtask" type="button" class="btn btn-info">Add task</a>
  </div>

      <div class="container-fluid d-flex p-0 mb-5 mt-3 justify-content-between">


        <?php
        if($_GET['num']){
          $page = $_GET['num'];
        }else{
          $page = 1;
        }
        if($_GET['sort']){
          switch ($_GET['sort']) {
            case 'name':
              $sortby = 'name';
              $asc = 'asc';
              break;

            case 'email':
              $sortby = 'email';
              $asc = 'asc';
              break;

            case 'done':
              $sortby = 'done';
              $asc = 'asc';
              break;

            case 'name_desc':
              $sortby = 'name';
              $asc = 'desc';
              break;

            case 'email_desc':
              $sortby = 'email';
              $asc = 'desc';
              break;

            case 'done_desc':
              $sortby = 'done';
              $asc = 'desc';
              break;

            default:
              $sortby = NULL;
              $asc = NULL;
              break;
          }
        }
        $tasks = FetchTasks($page,$mysqli, $sortby, $asc);

        foreach ($tasks as $task) {
          echo '
          <div class="card col-md-4" style="">
            <div class="card-body">
              <h5 class="card-title">'.$task->name.' <i class="text-muted">('.$task->email.')</i></h5>
              <h6 class="card-subtitle mb-2 mr-1 text-muted">'.date("F j", gmdate($task->date)).'</h6>
              <p class="card-text">'.$task->task.'</p>
              ';
          if($task->changed){
            echo '<p class="font-weight-light text-muted">Edited by Admin</p>';
          }
          if(CheckAdmin()){
              if($task->done){
                echo '<a href="markasdone/'.$task->id.'" class="btn btn-outline-success mt-1 mr-1">Mark as Undone</a>';
              }else{
                echo '<a href="markasdone/'.$task->id.'" class="btn btn-dark mt-1 mr-1">Mark as Done</a>';
              }





              echo '<a href="edittask/'.$task->id.'" class="btn btn-dark mt-1">Edit</a>';
          }else{
            if($task->done){
              echo '<span class="badge badge-success">Done</span>';
            }else{
              echo '<span class="badge badge-info">Pending</span>';
            }
          }
          echo '
          </div>
        </div>
        ';
        }

        ?>



      </div>

      <?php
        if(NumOfTasks($mysqli)>3){
      ?>

      <?php

        $url_addition = '?';
        if($_GET['sort']){
          $url_addition .= 'sort='.$_GET['sort'].'&';
        }

      ?>

      <nav aria-label="...">
        <ul class="pagination d-flex justify-content-center">
          <?php
            for ($i=0; $i < (ceil(NumOfTasks($mysqli)/3)); $i++) {
              if ($i == $page-1) {

          ?>
          <li class="page-item active">
            <span class="page-link">
              <?php echo ($i+1); ?>
            <span class="sr-only">(current)</span></span>
          </li>
          <?php
              } else {
          ?>
          <li class="page-item">
            <a class="page-link" href="<?php echo $url_addition.'num='.($i+1); ?>">
              <?php echo ($i+1); ?>
            </a>
          </li>

          <?php }} ?>
        </ul>
      </nav>
    <?php } ?>


    </main>
