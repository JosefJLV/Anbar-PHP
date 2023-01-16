<?php
include"header.php";
echo'<div class="container">';


if(isset($_POST['daxilet']))
{
	$daxilet=mysqli_query($con, " INSERT INTO kredit(userid,idmusteri,idmehsul,miqdar,faiz,muddet,ilkinodenis,tarix)
									VALUES('".$_SESSION['userid']."', '".$_POST['cid']."', '".$_POST['pid']."', '".$_POST['miqdar']."',
										'".$_POST['faiz']."', '".$_POST['muddet']."','".$_POST['ilkinodenis']."','".$tarix."')");


				if($daxilet==true)
				{
					echo'Daxil edildi';
				}
}

if(isset($_POST['delete']))
{
	$sil=mysqli_query($con,"DELETE FROM kredit WHERE id='".$_POST['id']."' ");

	if($sil==true)
	{
		echo'Silindi';
	}
}


if(isset($_POST['edit']))
{
	
}


echo'<div class="alert alert-info">
	<form method="post"> 
	Mushteri:
	<select name="cid" class="form-control">
	<option value="">Mushteri secin</option>';
		$msec=mysqli_query($con,"SELECT * FROM clients WHERE userid='".$_SESSION['userid']."' ".$axtar." ORDER BY name ASC");

		while($minfo=mysqli_fetch_array($msec))
		{

			echo'<option value="'.$minfo['id'].'">'.$minfo['name'].' '.$minfo['surname'].'</option>';
		}

echo'</select>
Mehsul secin
<select name="pid" class="form-control">
<option value="">Mehsul secin</option>';


$pid=mysqli_query($con, " SELECT 
								brand.ad,
								trade.name,
								trade.amount,
								trade.id,
								trade.brand_id
								FROM trade,brand WHERE trade.userid='".$_SESSION['userid']."' AND trade.brand_id=brand.id 
								 ORDER BY trade.id ASC");

while($pinfo=mysqli_fetch_array($pid))
{
	echo'<option value="'.$pinfo['id'].'">'.$pinfo['ad'].'-'.$pinfo['name'].'-'.$pinfo['amount'].'</option>';
}

echo'</select>
Miqdar:
<input type="text" name="miqdar" class="form-control">
Faiz derecesi:
<Select name="faiz" class="form-control">
<option value="5">5%</option>
<option value="7">7%</option>
<option value="12">12%</option></select>
Muddet:
<input type="text" name="muddet" class="form-control">
Ilkin odenis:
<input type="text" name="ilkinodenis" class="form-control"><br>
<button type="submit" name="daxilet" class="btn btn-success">Daxil et</button>';
echo'</form></div>';






$sec=mysqli_query($con, "SELECT 
								clients.name,
								clients.surname,
								trade.name AS ad,
								kredit.faiz,
								kredit.id,
								kredit.miqdar,
								kredit.muddet,
								kredit.ilkinodenis,
								trade.sale,
								kredit.faiz,
								kredit.ilkinodenis,
								kredit.idmehsul,
								trade.id,
								kredit.tarix,
								kredit.userid
								FROM kredit,trade,clients WHERE kredit.userid='".$_SESSION['userid']."' 
								 AND kredit.idmusteri=clients.id 
								 AND kredit.idmehsul=trade.id
								 ORDER BY kredit.id DESC ");

$i=0;

echo'
<div class="table">
<form method="post">
<table class="table table-sm">
<thead class="thead-dark">
<th>#</th>
<th>Mushteri</th>
<th>Mehsul</th>
<th>Miqdar</th>
<th>Faiz</th>
<th>Muddet</th>
<th>Ilkin odenis</th>
<th>Borc</th>
<th>Ayliq</th>
<th>Qalan muddet</th>
<th>Odenilen</th>
<th>Depozit</th>
<th>Tarix</th>
<th></th>
</thead></form>
<tbody>';

while($info=mysqli_fetch_array($sec))
{
	$qalanborc=$info['miqdar']*$info['sale']-$info['ilkinodenis'];
	$faiz=$qalanborc*$info['faiz']/100+$qalanborc;
	$ayliq=round($faiz/$info['muddet']);

	$i++;
	echo'<tr>';
	echo'<td>'.$i.'</td>';
	echo'<td>'.$info['name'].' '.$info['surname'].'</td>';
	echo'<td>'.$info['ad'].'</td>';
	echo'<td>'.$info['miqdar'].'</td>';
	echo'<td>'.$info['faiz'].'%</td>';
	echo'<td>'.$info['muddet'].'</td>';
	echo'<td>'.$info['ilkinodenis'].'</td>';
	echo'<td>'.$faiz.'</td>';
	echo'<td>'.$ayliq.'</td>';
	echo'<td>-</td>';
	echo'<td>-</td>';
	echo'<td>-</td>';
	echo '<td>'.$info['tarix'].'</td>';
	echo'<form method="post"><td>
	<input type="hidden" name="id" value="'.$info['id'].'">
	<button type="submit" name="edit" class="btn btn-outline-info btn-sm"><i class="fas fa-edit" style="font-size:19px"></i> </button>
	<button type="submit" name="delete" class="btn btn-outline-danger btn-sm"><i class="far fa-trash-alt" style="font-size:19px"></i></button>
	<button type="submit" name="tesdiq" class="btn btn-outline-success btn-sm"><i class="far fa-check-circle" style="font-size:19px"></i></button></td></form>';
	echo'</tr>';

}

echo'</tbody></table></div>';
echo'</div>';
?>