<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
      <div class="container">
        <a class="navbar-brand" href="/beejee">BEEJEE</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExample07" aria-controls="navbarsExample07" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarsExample07">
          <ul class="navbar-nav mr-auto">
            <li class="nav-item">
              <?php
                if(CheckAdmin()){
              ?>
                <a class="nav-link" href="logout">Log out</a>
              <?php
                }else{
              ?>
                <a class="nav-link" href="login">Login</a>
              <?php } ?>
            </li>
          </ul>
        </div>
      </div>
    </nav>

<?php

?>
