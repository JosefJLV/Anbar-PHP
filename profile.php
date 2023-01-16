<?php
include'header.php';
echo'<div class="container">';



if(isset($_POST['deyis']))
 {
    if($_POST['parol']==$_SESSION['password'])
    {
    $yoxlama=mysqli_query($con,"SELECT * FROM users WHERE (phone='".$_SESSION['phone']."' OR  email='".$_SESSION['email']."') AND id!='".$_SESSION['userid']."'");

    $say=mysqli_num_rows($yoxlama);

    if($say==0)
    {
        if(empty($_POST['yeni_parol']))
        {$parol=$_SESSION['password'];}
        else
        {$parol=mysqli_real_escape_string($con,trim(htmlspecialchars(strip_tags($_POST['yeni_parol']))));}

        $ad=mysqli_real_escape_string($con,trim(htmlspecialchars(strip_tags($_POST['ad']))));
        $soyad=mysqli_real_escape_string($con,trim(htmlspecialchars(strip_tags($_POST['soyad']))));
        $tel=mysqli_real_escape_string($con,trim(htmlspecialchars(strip_tags($_POST['tel']))));
        $email=mysqli_real_escape_string($con,trim(htmlspecialchars(strip_tags($_POST['email']))));        
    
        if($_FILES['foto']['size']<1024)
            {$unvan = $_POST['cari_foto'];}
        else
            {include"upload.php";}

         $profile=mysqli_query($con, "UPDATE users SET 
                                                    foto='".$unvan."',
                                                    name='".$ad."',
                                                    surname='".$soyad."',
                                                    phone='".$tel."',
                                                    email='".$email."',
                                                    password='".$parol."'

                                                    WHERE id='".$_SESSION['userid']."' ");
        if($profile==true)
        {
          echo'<div class="text-center">
                <div class="alert alert-primary" role="alert"> 
                <b>Yeniləndi</b>
                </div></div>';

          $_SESSION['name'] = $ad;
          $_SESSION['surname'] = $soyad;
          $_SESSION['phone'] = $tel;
          $_SESSION['email'] = $email;
          $_SESSION['foto'] = $unvan;
          $_SESSION['password'] = $parol;

          echo'<meta http-equiv="refresh" content="0; URL= profile.php">';
        }
        else
        {echo'<div class="text-center">
                <div class="alert alert-warning" role="alert">
                <b>Yenilənə bilmədi</b>
                </div></div>';}
    }
    else
        {echo'<div class="text-center">
                <div class="alert alert-warning" role="alert">
                <b>Nömrə bazada mövcuddur</b>
                 </div></div>';}
    }
    else 
        {echo'<div class="text-center">
                <div class="alert alert-primary" role="alert">
                <b>Parol yalnışdır</b>
                </div></div>';}
 }
echo'<div class="alert alert-info">
    <form method="post" enctype="multipart/form-data">
	  <img style="width:75px; height:70px;" src="'.$_SESSION['foto'].'"><br><br>
	  <input type="file" name="foto"><br>
 	  Ad:<br>
 	  <input required type="text" name="ad" class="form-control" value="'.$_SESSION['name'].'"><br>
 	  Soyad:<br>
 	  <input required type="text" name="soyad" class="form-control" value="'.$_SESSION['surname'].'"><br>
 	  Telefon:<br>
 	  <input required type="text" name="tel" class="form-control" value="'.$_SESSION['phone'].'"><br>
 	  Email:<br>
 	  <input required type="text" name="email" class="form-control" value="'.$_SESSION['email'].'"><br>
 	  Parol (Əgər dəyişməyəcəksinizsə boş buraxın):
 	  <input type="password" name="yeni_parol" class="form-control"><br>
      Dəyişiklikləri yadda saxlamaq üçün cari parolu daxil edin:<br>
      <input required type="password" name="parol" class="form-control" autocomplete="off"><br>

      <input type="hidden" name="uid" value="'.$_SESSION['userid'].'">
      <input type="hidden" name="cari_foto" value="'.$_SESSION['foto'].'">
      <input type="hidden" name="id" value="'.$info['id'].'">
 	  <button type="submit" class="btn btn-primary" name="deyis">Dəyiş</button>
 </form></div>';

 
echo'</div>';
 ?>
 