<?php
if (isset($_GET["id"])) {
  $id = $_GET["id"];
  $task = FetchTask($id, $mysqli);
} ?>
<main class="container col-md-5 p-0 my-5">
  <h1 class="mb-3"><?php if($_GET['id']){echo 'Edit';}else{echo 'Add';}?> task</h1>
  <form action="controller.php" method="post">
    <div class="form-group">
      <label for="formGroupExampleInput">Your name</label>
      <input <?php if($_GET['id']){echo 'disabled';}?> type="text" value="<?php echo $task->name; ?>" class="form-control" id="formGroupExampleInput" placeholder="Greg" maxlength="30" value="" name="name">
    </div>
    <div class="form-group">
      <label for="formGroupExampleInput2">E-mail</label>
      <input <?php if($_GET['id']){echo 'disabled';}?>
      type="text" value="<?php echo $task->email; ?>" class="form-control" id="formGroupExampleInput2" placeholder="example@example.com" maxlength="40" value="" name="email">
    </div>
    <div class="form-group">
      <label for="formGroupExampleInput2">Task</label>
      <textarea class="form-control" id="formGroupExampleInput2" placeholder="Do something beatiful ASAP." maxlength="150" rows=3 style="resize:none;" name="task"><?php echo $task->task; ?></textarea>
    </div>
    <input type="hidden" name="edit" value="<?php if($_GET['id']){echo '1';}else{echo '0';}?>">
    <input type="hidden" name="id" value="<?php echo $task->id; ?>">
    <button type="submit" name="submitTaskBtn" class="btn btn-success btn-lg mt-3"><?php if($_GET['id']){echo 'Save';}else{echo 'Add';}?></button>
    <?php session_start();
    print_r ($_SESSION["error"]);
    // if (isset($_SESSION["error"]) {
    //         echo $_SESSION["error"];
    //         unset($_SESSION["error"]);
    //       }
    unset($_SESSION["error"]);
    ?>
  </form>
</main>
