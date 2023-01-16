<?php 
$unvan='images/'.basename($_FILES['foto']['name']);

$tip = strtolower(pathinfo($unvan, PATHINFO_EXTENSION));

if($tip!='jpeg' && $tip!='jpg' && $tip!='png' && $tip!='gif')
    {$error='<div class="alert alert-danger" role="alert"> Foto yalniz <b>jpeg,jpg,png,gif</b> fayl formatlarindan birinde ola biler</div>';}

if($_FILES['foto']['size'] > 5242880)
    {$error='<div class="alert alert-danger" role="alert">Fayl hecmi maksimum <b>5 mb ola biler</b></div>';}

if(isset($error))
    {echo $error;}

else
{
    $unvan='images/'.time().'.'.$tip;
    move_uploaded_file($_FILES['foto']['tmp_name'], $unvan);
}

 ?>