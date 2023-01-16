<?php
session_start();
if(isset($_SESSION['email']) && isset($_SESSION['password']))
{ 
  echo'<meta http-equiv="refresh" content="0; URL= orders.php">'; exit;
    
}
 

$con=mysqli_connect('localhost','Yusif','1234','anbar');
?>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>


<?//BOOTSTRAP LINKLERI?>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

 <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>

<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">


<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="#">Anbar</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">

      <li class="nav-item active">
        <a class="nav-link" href="#">Haqqımızda</a>
      </li>

      <li class="nav-item active">
        <a class="nav-link" href="#">Əlaqə</a>
      </li>


    </ul>
    <form class="form-inline my-2 my-lg-0" method="post">
      <input class="form-control mr-sm-2" type="email" name="email" placeholder="email" aria-label="Search">
      <input class="form-control mr-sm-2" type="password" name="parol" placeholder="parol" aria-label="Search">
      <button class="btn btn-outline-light btn-sm my-2 my-sm-0" name="enter" type="submit">Daxil ol</button> &nbsp;
    </form>
  </div>
</nav>

<?php

if(isset($_POST['enter']))
{
  if(!empty($_POST['email']) && !empty($_POST['parol']))

  {$email=mysqli_real_escape_string($con,strip_tags(trim($_POST['email'])));
    $parol=mysqli_real_escape_string($con,strip_tags(trim($_POST['parol'])));
  
    $giris=mysqli_query($con,"SELECT * FROM users WHERE email='".$email."' AND password='".$parol."' AND block = 0 ");
  
    if(mysqli_num_rows($giris)>0)
    {
      $info = mysqli_fetch_array($giris);
  
  
      $_SESSION['userid']= $info['id'];
      $_SESSION['name']= $info['name'];
      $_SESSION['surname']= $info['surname'];
      $_SESSION['phone']= $info['phone'];
      $_SESSION['email']= $info['email'];
      $_SESSION['password']= $info['password'];
      $_SESSION['foto']=$info['foto'];
      echo'<meta http-equiv="refresh" content="0; URL= orders.php">';
    }
  }
}
 ?>
<br><br><br><br>

<div class="container">

  <div class="alert alert-warning" role="alert">
  <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-exclamation-circle" viewBox="0 0 16 16">
  <path d="M8 15A7 7 0 1 1 8 1a7 7 0 0 1 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
  <path d="M7.002 11a1 1 0 1 1 2 0 1 1 0 0 1-2 0zM7.1 4.995a.905.905 0 1 1 1.8 0l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 4.995z"/>
</svg> Anbarda işləmək üçün email və parolunuzu daxil edərək sistemə giriş edin və ya qeydiyyatdan keçin
</div>
 


<?php 
$tarix=date('Y-m-d H:i:s');


if(isset($_POST['register']))
{
$name=trim($_POST['ad']);
$name=strip_tags($name);
$name=htmlspecialchars($name);
$name=mysqli_real_escape_string($con,$name);

$surname=trim($_POST['soyad']);
$surname=strip_tags($surname);
$surname=htmlspecialchars($surname);
$surname=mysqli_real_escape_string($con,$surname);

$phone=trim($_POST['tel']);
$phone=strip_tags($phone);
$phone=htmlspecialchars($phone);
$phone=mysqli_real_escape_string($con,$phone);

$email=trim($_POST['email']);
$email=strip_tags($email);
$email=htmlspecialchars($email);
$email=mysqli_real_escape_string($con,$email);

$password=trim($_POST['parol']);
$password=strip_tags($password);
$password=htmlspecialchars($password);
$password=mysqli_real_escape_string($con,$password);

$repass=trim($_POST['tekrar_parol']);
$repass=strip_tags($repass);
$repass=htmlspecialchars($repass);
$repass=mysqli_real_escape_string($con,$repass);

$check=mysqli_query($con, "SELECT * FROM users WHERE phone='".$_POST['tel']."' ");

  $limit=mysqli_num_rows($check);
  if($limit==0)
  {
  
    if($password==$repass)
    { 
      
      $qeydkec=mysqli_query($con, "INSERT INTO users(name,surname,phone,email,password,tarix)
      VALUES ('".$name."','".$surname."','".$phone."','".$email."','".$password."','".$tarix."') ");
  
      if($qeydkec==true)
      {

        echo'<div class="text-center">
                <div class="alert alert-success" role="alert" style="font-size:18px">
                      <b>Qeydiyyat ugurlu oldu</b> <i class="fas fa-check-circle"></i>
              </div>
            </div>';
      }
      else
        {echo'<div class="text-center">
                <div class="alert alert-danger" role="alert" style="font-size:18px">
                    <b>Qeydiyyat ugursuz oldu</b> <i class="fas fa-times"></i>
                </div>
              </div>    ';}
    }
    else
      {echo'<div class="text-center">
              <div class="alert alert-warning" role="alert" style="font-size:18px">
                <b>Parollar uygun deyil!</b><i class="fas fa-exclamation-circle"></i>
            </div>
          </div>';}
  }
  else
    {echo'<div class="text-center">
            <div class="alert alert-warning" role="alert" style="font-size:18px">
                <b>Nömrə artıq bazada mövcuddur</b> <i class="fas fa-exclamation-circle"></i>
            </div>
          </div> ';}
}

 ?>

    <div class="alert alert-info" role="alert">
    <form method = "post" enctype="multipart/form-data">
    Ad:<br>
    <input required type="text" class="form-control" name="ad" autocomplete="off"><br>
    Soyad:<br>
    <input required type="text" class="form-control" name="soyad" autocomplete="off"><br>
    Telefon:<br>
    <input required type="text" class="form-control" name="tel" autocomplete="off"><br>
    Email:<br>
    <input required type="email" class="form-control" name="email" autocomplete="off"><br>
    Parol:<br>
    <input required type="password" class="form-control" name="parol" autocomplete="off"><br>
    Təkrar parol:<br>
    <input required type="password" class="form-control" name="tekrar_parol" autocomplete="off"><br>
    <button type="submit" class="btn btn-success btn-sm" name="register">Qeydiyyatdan keç</button><br>
    </form>
  </div>
</div>

