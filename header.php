<?php
session_start();

if(!isset($_SESSION['email']) or !isset($_SESSION['password']))

{echo'<meta http-equiv="refresh" content="0; URL= user.php">'; exit;}


$con=mysqli_connect('localhost','Yusif','1234','anbar');
$tarix=date('Y-m-d H:i:s');

 ?>


 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>







<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto"> 
      <li class="nav-item active">
        <a class="btn btn-outline-light mr-sm-3 btn-sm" href="profile.php"><img style="width:35px; height:32px;" src="<? echo $_SESSION['foto']?>"><span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="brands.php">Brend<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="clients.php">Müştəri<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="products.php">Məhsul<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="xerc.php">Xərc<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="orders.php">Sifarişlər<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item active">
        <a class="nav-link" href="kredit.php">Kredit<span class="sr-only">(current)</span></a>
      </li>
      <?php  
    if($_SESSION['userid']==6)
    {
      echo'<li class="nav-item active">
        <a class="nav-link" href="istifadeciler.php">İstifadəçilər<span class="sr-only">(current)</span></a>
      </li>';
    }
    ?>
      <li class="nav-item active">
        <a class="nav-link" href="exit.php">Çıxış<span class="sr-only">(current)</span></a>
      </li>
    </ul>

    

    <form method="post" class="form-inline my-2 my-lg-0" action="#cedvel" id="axtarForm">
      <input class="form-control mr-sm-2" type="text" name="query"  placeholder="Axtar" id="axtar"  aria-label="Search">
      <button class="btn btn-outline-light btn-sm axtar" name="axtar" type="button"> <i class="fas fa-search" style="font-size:19px"></i>
      </button>
      <input type="hidden" name="axtar">
      <button class="btn btn-outline-light btn-sm" name="hamisi" type="submit"><i class="fas fa-align-justify" style="font-size:19px"></i>
      </button>
    </form>
  </div>
</nav><br>