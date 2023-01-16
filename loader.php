<?php
session_start();
$con=mysqli_connect('localhost','Yusif','1234','anbar');
$tarix=date('Y-m-d H:i:s');



if(isset($_GET['brands']))
{

	if(isset($_POST['axtar']) && !empty($_POST['query']))
	{
	$axtar=" AND (ad LIKE'%".$_POST['query']."%' OR tarix LIKE'%".$_POST['query']."%') ";

	$yoxlama=mysqli_query($con, "SELECT * FROM brand WHERE ad='".$_POST['query']."' AND userid='".$_SESSION['userid']."' ");

		$say=mysqli_num_rows($yoxlama);
		if($say==0)
			{echo'<div class="text-center">
					<div class="alert alert-warning" role="alert" style="font-size:18px">
							<b>Məlumat tapılmadı!</b>
					</div>
				</div>';}
	}



	if(isset($_POST['edit_id']))
	{
		$sec=mysqli_query($con, "SELECT * FROM brand WHERE id='".$_POST['edit_id']."' ");

		$info=mysqli_fetch_array($sec);
		 echo'
		<form method="post" enctype="multipart/form-data" id="updateForm">
		<b>Brand:</b>
		<input required type="text" class="form-control" name="brand" value="'.$info['ad'].'"><br>
		<b>Logo:</b><br>
		<img style="width:65px; height: 57px;" src="'.$info['foto'].'"><br>
		<input type="file" name="foto"><br><br>
		<input type="hidden" name="update">
		<button type="button" name="update" class="btn btn-primary btn-sm update"><b>Yenilə</b></button><br>
		<input type="hidden" name="id" value="'.$info['id'].'">
		<input type="hidden" name="cari_foto" value="'.$info['foto'].'">
		</form>';

	}
		
	if(isset($_POST['update']))
	{
	$brand=trim($_POST['brand']);
	$brand=strip_tags($brand);
	$brand=htmlspecialchars($brand);
	$brand=mysqli_real_escape_string($con,$brand);

			if(!empty($_POST['brand']))
			{	

				if($_FILES['foto']['size']<1024)
				{$unvan = $_POST['cari_foto'];}
				else
				{include"upload.php";}

				if(!isset($error))
				{
						$yenile=mysqli_query($con, "UPDATE brand SET 
						foto='".$unvan."',
						ad='".$brand."'
						
						WHERE id='".$_POST['id']."' ");

					if($yenile==true)
						echo'<div class="text-center">
									<div class="alert alert-primary" role="alert" style="font-size:18px">
									<b>Yeniləndi</b> <i class="fas fa-sync"></i>
								</div>
							</div>';

					else
						{echo'<div class="text-center">
													<div class="alert alert-danger" role="alert" style="font-size:18px">
													<b>Yənilənə bilmədi</b> <i class="fas fa-times"></i>
												</div>
											</div>';}
				}
			}
			else
				echo'<div class="text-center">
							<div class="alert alert-warning" role="alert" style="font-size:18px">
							<b>Məlumatları tam doldurun</b> <i class="fas fa-exclamation-circle"></i>
						</div>
					</div>';
	}





if(isset($_POST['daxilet']))
{
$brand=trim($_POST['brand']);
$brand=strip_tags($brand);
$brand=htmlspecialchars($brand);
$brand=mysqli_real_escape_string($con,$brand);


	if(!empty($brand))
	{
		$yoxlama=mysqli_query($con, "SELECT * FROM brand WHERE ad='".$_POST['brand']."' AND userid='".$_SESSION['userid']."' ");
		$say=mysqli_num_rows($yoxlama);
		if($say==0 && !isset($error))
		{
			include "upload.php";
			
			$daxil_et=mysqli_query($con, "INSERT INTO brand(userid,foto,ad,tarix) 
			VALUES ('".$_SESSION['userid']."','".$unvan."','".$_POST['brand']."','".$tarix."') ");

			if($daxil_et==true)
				{echo '<div class="text-center">
							<div class="alert alert-success" role="alert" style="font-size:18px">
							<b>Əlavə olundu </b><i class="fas fa-check-circle"></i>
						</div>
					</div>';}
			else
				{echo'<div class="text-center">
							<div class="alert alert-danger" role="alert" style="font-size:18px">
							<b>Əlavə oluna bilmədi </b><i class="fas fa-times"></i>
						</div>
					</div>';}
				
		}
		else
			{echo'<div class="text-center">
							<div class="alert alert-warning" role="alert" style="font-size:18px">
							<b>Bu brend artıq bazada mövcuddur </b><i class="fas fa-exclamation-circle"></i>
						</div>
					</div>';}
	}
	else
		{echo '<div class="text-center">						
								<div class="alert alert-warning" role="alert" style="font-size:18px">
							<b><b>Məlumatları tam doldurun </b><i class="fas fa-exclamation-circle"></i>
					</div>
				</div>';}
}




if(!isset($_POST['edit_id']))
{
	echo'<div class="alert alert-info">
	<form method="post" id="insertForm">
		<b>Brend:</b>
	<input type="text" class="form-control" name="brand" placeholder="Brendin adı" required ><br>
	<b>Logo:</b><br>
	<input type="file" name="foto"><br><br>
	<input type="hidden" name="daxilet">
	<button type="button" name="daxilet" class="btn btn-success daxilet"><b>Daxil et</b></button><br>
	
	</div></form>';
}


//----------------------BRANDS DELETE START----------------------------------


	if(isset($_POST['del_id']))
	{
		$check=mysqli_query($con, "SELECT brand_id FROM trade WHERE brand_id='".$_POST['del_id']."' ");
			$a=mysqli_num_rows($check);
			if($a>0)
				{echo'<div class="text-center">
								<div class="alert alert-warning" role="alert" style="font-size:16px">
								<b>Brendin anbarda məhsulu var </b><i class="fas fa-exclamation-circle"></i>
							</div>
						</div>';}

			else
				{
					$sil=mysqli_query($con, "DELETE FROM brand WHERE id='".$_POST['del_id']."' ");

					if($sil==true)
						{echo'<div class="text-center">
										<div class="alert alert-warning" role="alert" style="font-size:18px">
										<b>Silindi </b><i class="fas fa-cut"></i>
									</div>
								</div>';}

					else
						{echo'<div class="text-center">
										<div class="alert alert-primary" role="alert" style="font-size:18px">
										<b>Silinə bilmədi </b><i class="fas fa-times"></i>
									</div>
						</div>';}

				}
	}
			
	
//----------------------BRANDS DELETE END----------------------------------

//---------------------BRAND SECSIL START-----------------------------------




//---------------------BRAND SECSIL END------------------------------------


//----------------------BRANDS SELECT START--------------------------------

	if($_GET['f1']=='ASC')
	{
		$order = ' ORDER BY ad ASC ';
		$f1 = '<a href="?f1=DESC#cedvel"><i class="bi bi-sort-alpha-down-alt"></i></a>';
	}

	elseif($_GET['f1']=='DESC')
	{
		$order = ' ORDER BY ad DESC ';
		$f1 = '<a href="?f1=ASC#cedvel"><i class="bi bi-sort-alpha-down"></i></a>';
	}

	else
	{$f1 = '<a href="?f1=ASC#cedvel"><i class="bi bi-sort-alpha-down"></i></a>';}


	if($_GET['f2']=='ASC')
	{
		$order = ' ORDER BY tarix ASC ';
		$f2 = '<a href="?f2=DESC#cedvel"><i class="bi bi-sort-alpha-down-alt"></i></a>';
	}

	elseif($_GET['f2']=='DESC')
	{
		$order = ' ORDER BY tarix DESC ';
		$f2 = '<a href="?f2=ASC#cedvel"><i class="bi bi-sort-alpha-down"></i></a>';
	}

	else
	{$f2 = '<a href="?f2=ASC#cedvel"><i class="bi bi-sort-alpha-down"></i></a>';}



	if(!isset($_GET['f1']) && !isset($_GET['f2']))
	{$order = ' ORDER BY id DESC ';}

	$sec=mysqli_query($con, "SELECT * FROM brand  WHERE userid='".$_SESSION['userid']."' ".$axtar.$order);

	$say=mysqli_num_rows($sec);

	{echo '<medium><b>Overall: '.$say.'</b></medium>';}
	$i=0;
	echo '<form method="post">
	<div class="table-hover">
	<table class="table table-sm" id="cedvel">
		<thead class="thead-dark">
		<th>#</th>
		<th>Logo</th>
		<th>Brendlər '.$f1.'</th>
		<th>Tarix '.$f2.'</th>
		<th><button type="submit" name="secsil" class="btn btn-danger btn-sm " >Seçilənləri sil</button></th>
	</thead>
	<tbody>';

	while($info=mysqli_fetch_array($sec))
	{
		$i++;

		echo'<tr>';
		echo '<td><input type="checkbox" name="secilmis[]" value="'.$info['id'].'"><b>'.$i.'</b></td>';
		echo'<td><img style="width:55px; height: 47px;" src="'.$info['foto'].'"></td>';
		echo '<td><i>'.$info['ad'].'</i></td>';
		echo '<td>'.$info['tarix'].'</td>';
		echo'
	<form method="post"><td>
		
		<input type="hidden" name="id" value="'.$info['id'].'">
		<input type="hidden" name="brandad" value="'.$info['ad'].'">
		<button type="button" name="edit" class="btn btn-outline-info btn-sm edit" id="'.$info['id'].'"><i class="fas fa-edit" style="font-size:19px"></i> </button>
		<button type="button" name="delete" class="btn btn-outline-danger btn-sm sil" id="'.$info['id'].'"><i class="far fa-trash-alt" style="font-size:19px"></i></button>
		 </td></form>';
	echo'</tr>';

	}


	echo'
	</tbody>
	</table>';
}
//---------------------------BRANDS SELECT END------------------------------

if(isset($_GET['clients']))
{


	if(isset($_POST['edit_id']))
{
	$sec=mysqli_query($con, "SELECT * FROM clients WHERE id='".$_POST['edit_id']."' ");
	$info=mysqli_fetch_array($sec);
	echo'
	<form method="post" enctype="multipart/form-data" id="updateForm">
	<b>Ad:</b><br>
	<input type="text" name="name" class="form-control" value="'.$info['name'].'">
	<b>Soyad:</b><br>
	<input type="text" name="surname" class="form-control" value="'.$info['surname'].'">
	<b>Telefon:</b><br>
	<input type="text" name="phone" class="form-control" value="'.$info['phone'].'">
	<b>Şirkət:</b><br>
	<input type="text" name="company" class="form-control" value="'.$info['company'].'"><br>
	<img style="width:65px; height: 57px;" src="'.$info['foto'].'"><br>
	<input type="file" name="foto"><br><br>
	<input type="hidden" name="update">
	<button type="button" name="update" class="btn btn-primary btn-sm update"><b>Update</b></button>
	<input type="hidden" name="id" value="'.$info['id'].'">
	<input type="hidden" name="caro_foto" value="'.$info['foto'].'">
	</form>';

}
if(isset($_POST['update']))
{
$name=trim($_POST['name']);
$name=htmlspecialchars($name);
$name=strip_tags($name);
$name=mysqli_real_escape_string($con,$name);

$surname=trim($_POST['surname']);
$surname=htmlspecialchars($surname);
$surname=strip_tags($surname);
$surname=mysqli_real_escape_string($con,$surname);

$phone=trim($_POST['phone']);
$phone=htmlspecialchars($phone);
$phone=strip_tags($phone);
$phone=mysqli_real_escape_string($con,$phone);

$company=trim($_POST['company']);
$company=htmlspecialchars($company);
$company=strip_tags($company);
$company=mysqli_real_escape_string($con,$company);

	if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['phone']) && !empty($_POST['company']))
	{
		if($_FILES['foto']['size']<1024)
			{$unvan = $_POST['cari_foto'];}
			else
			{include"upload.php";}

			if(!isset($error))
			{
				$update=mysqli_query($con, "UPDATE clients SET 
					foto='".$unvan."',
					name='".$_POST['name']."', 
					surname='".$_POST['surname']."',
					phone='".$_POST['phone']."',
					company='".$_POST['company']."'
					WHERE id='".$_POST['id']."' ");
		
					if($update==true)
					{echo'<div class="text-center">
								<div class="alert alert-primary" role="alert" style="font-size:18px"><i class="fas fa-sync"></i>
								<b>Yeniləndi</b>
							</div>
						</div>';}
		
					else
					{echo'<div class="text-center">
								<div class="alert alert-danger" role="alert"style="font-size:18px"><i class="fas fa-exclamation-circle"</i>
									<b>Yenilənə bilmədi!</b>
							</div>
						</div>';}
		}
	}
	else
		{echo'<div class="text-center">
					<div class="alert alert-warning" role="alert" style="font-size:18px"><i class="fas fa-exclamation-circle"></i>
						<b>Məlumatları tam doldurun!</b>
				</div>
			</div>';}
}




if(isset($_POST['add']))
{

$name=trim($_POST['name']);
$name=htmlspecialchars($name);
$name=strip_tags($name);
$name=mysqli_real_escape_string($con,$name);

$surname=trim($_POST['surname']);
$surname=htmlspecialchars($surname);
$surname=strip_tags($surname);
$surname=mysqli_real_escape_string($con,$surname);

$phone=trim($_POST['olkekod'].$_POST['prefix'].$_POST['phone']);
$phone=htmlspecialchars($phone);
$phone=strip_tags($phone);
$phone=mysqli_real_escape_string($con,$phone);

$company=trim($_POST['company']);
$company=htmlspecialchars($company);
$company=strip_tags($company);
$company=mysqli_real_escape_string($con,$company);


	if(!empty($_POST['name']) && !empty($_POST['surname']) && !empty($_POST['phone']) && !empty($_POST['company']))
	{
		$check=mysqli_query($con, "SELECT * FROM clients WHERE phone='".$_POST['phone']."' ");
		$limit=mysqli_num_rows($check);
			if($limit==0 && !isset($error))
			{
				include "upload.php";
				
				$daxilet=mysqli_query($con, "INSERT INTO clients(userid,foto,name,surname,phone,company,date1) 
					VALUES('".$_SESSION['userid']."','".$unvan."','".$name."','".$surname."','".$phone."','".$company."','".$tarix."') ");
				
								if($daxilet==true)
									{echo'<div class="text-center">
												<div class="alert alert-success" role="alert" style="font-size:18px"><i class="fas fa-check-circle"></i>
													<b> Yeni müştəri əlavə olundu!</b>
											</div>
										</div>';}
								else
									{echo '<div class="text-center">
													<div class="alert alert-danger" role="alert" style="font-size:18px"><i class="fas fa-times"></i>
													<b>Yeni müştəri əlavə oluna bilmedi!</b>
												</div>
											</div>';}
											
			}
			else
				{echo'<div class="text-center">
							<div class="alert alert-warning" role="alert" style="font-size:18px"><i class="fas fa-exclamation-circle"></i>
								<b> Bu nömrə artıq bazada mövcuddur!</b>
						</div>
					</div>';}
	}
	else
		{echo '<div class="text-center">
						<div class="alert alert-warning" role="alert" style="font-size:18px"><i class="fas fa-exclamation-circle"></i>
							<b>Məlumatlari tam doldurun!</b>
					</div>
				</div>';}
}

if(!isset($_POST['edit_id']))
	{
		echo'<div class="alert alert-info">
		
	<form method="post" enctype="multipart/form-data" id="insertForm">
	<div class="input-group">
	<span class="input-group-text"><b>Ad:</b></span>
	<input type="text" name="name" class="form-control"  required></div><br>
	<div class="input-group">
	<span class="input-group-text"><b>Soyad:</b></span>
	<input type="text" name="surname" class="form-control"  required></div><br>
	<div class="input-group">
	<span class="input-group-text"><b>Telefon:</b></span>
	<input type="text" name="phone" class="form-control"  required></div><br>
	<div class="input-group">
	<span class="input-group-text"><b>Şirkət:</b></span>
	<input type="text" name="company" class="form-control"  required></div><br>
	<div class="input-group">
	<span class="input-group-text"><b>Şəkil:</b></span>
	<input type="file" name="foto" class="form-control" title="Şəkil seçmək üçün klikləyin"><br></div><br>
	<input type="hidden" name="add">
	<button type="button" name="add" class="btn btn-success btn add"><b>Daxil et</b></button><br>
</form></div>';
}





//--------------------------CLIENTS DELETE START----------------------------

if(isset($_POST['del_id']))
{
	$check=mysqli_query($con,"SELECT clientid FROM orders WHERE clientid='".$_POST['del_id']."' ");

		$a=mysqli_num_rows($check);
		if($a>0){
			echo'<div class="text-center">
					<div class="alert alert-warning" role="alert" style="font-size:18p"> 
						<b>Müştərinin sifarişi var!</b>
					</div>
				</div>';
		}
		else
			{
				$delete=mysqli_query($con,"DELETE FROM clients WHERE id='".$_POST['del_id']."' ");
				if($delete==true)
				{echo'<div class="text-center">
								<div class="alert alert-success" role="alert" style="font-size:18px"><i class="fas fa-cut"></i>
								<b>Silindi!</b>
							</div>
						</div>';}
				else
					{echo'<div class="text-center">
							<div class="alert alert-danger" role="alert" style="font-size:18px"><i class="fas fa-times"></i>
							<b>Silinə bilmədi!</b>
							</div>
						</div>';}
			}

}

//-----------------------------CLIENTS DELETE END---------------------


	if($_GET['f1']=='ASC')
	{
		$order = ' ORDER BY name ASC ';
		$f1 = '<a href="?f1=DESC#cedvel"><i class="bi bi-sort-alpha-down-alt"></i></a>';
	}

	elseif($_GET['f1']=='DESC')
	{
		$order = ' ORDER BY surname DESC ';
		$f1 = '<a href="?f2=ASC#cedvel"><i class="bi bi-sort-alpha-down"></i></a>';
	}

	else
	{$f1 = '<a href="?f2=ASC#cedvel"><i class="bi bi-sort-alpha-down"></i></a>';}


	if($_GET['f2']=='ASC')
	{
		$order = ' ORDER BY surname ASC ';
		$f2 = '<a href="?f2=DESC#cedvel"><i class="bi bi-sort-alpha-down-alt"></i></a>';
	}

	elseif($_GET['f2']=='DESC')
	{
		$order = ' ORDER BY date1 DESC ';
		$f2 = '<a href="?f2=ASC#cedvel"><i class="bi bi-sort-alpha-down"></i></a>';
	}

	else
	{$f2 = '<a href="?f2=ASC#cedvel"><i class="bi bi-sort-alpha-down"></i></a>';}


	if($_GET['f3']=='ASC')
	{
		$order = ' ORDER BY date1 ASC ';
		$f3 = '<a href="?f3=DESC#cedvel"><i class="bi bi-sort-alpha-down-alt"></i></a>';
	}

	elseif($_GET['f3']=='DESC')
	{
		$order = ' ORDER BY date1 DESC ';
		$f3 = '<a href="?f3=ASC#cedvel"><i class="bi bi-sort-alpha-down"></i></a>';
	}

	else
	{$f3 = '<a href="?f3=ASC#cedvel"><i class="bi bi-sort-alpha-down"></i></a>';}


	if($_GET['f4']=='ASC')
	{
		$order='ORDER BY company ASC';

		$f4='<a href="?f4=DESC#cedvel"><i class="bi bi-sort-alpha-down-alt"></i></a> ';
	}
	elseif($_GET['f4']=='DESC')
	{
		$order='ORDER BY company DESC';
		$f4='<a href="?f4=ASC#cedvel"><i class="bi bi-sort-alpha-down"></i></a>';
	}

	else
	{
		$f4='<a href="?f4=DESC#cedvel"><i class="bi bi-sort-alpha-down"></i></a>';
	}


	if(!isset($_GET['f1']) && !isset($_GET['f2']) && !isset($_GET['f3']) && !isset($_GET['f4']))
	{
	$order='ORDER BY id DESC';
	}

	$sec=mysqli_query($con, "SELECT * FROM clients WHERE userid='".$_SESSION['userid']."' ".$axtar.$order);
	$say=mysqli_num_rows($sec);
	{echo'<b>Ümumi say: '.$say.'</b>';}

	$i=0;
	echo'<div class="table-striped">
	<form method="post">
	<table class="table table-sm" id="cedvel">
		<thead class="thead-dark">
		<th>#</th>
		<th>Foto</th>
		<th>Ad'.$f1.'</th>
		<th>Soyad'.$f2.'</th>
		<th>Telefon</th>
		<th>Şirkət'.$f4.'</th>
		<th>Tarix'.$f3.'</th>
		<th><button type="submit" name="secsil" class="btn btn-danger btn-sm">Seçilənləri sil</button> </th>
	</thead></form>
	<tbody>';
	while($info=mysqli_fetch_array($sec))
	{$i++;
		echo'<tr>';
		echo'<td> <input type="checkbox" name="secilmis[]" value="'.$info['id'].'"><b> '.$i.'</b></td>';
		echo'<td><img style="width:55px; height: 47px;" src="'.$info['foto'].'"></td>';
		echo'<td>'.$info['name'].'</td>';
		echo'<td>'.$info['surname'].'</td>';
		echo'<td>'.$info['phone'].'</td>';
		echo'<td>'.$info['company'].'</td>';
		echo'<td>'.$info['date1'].'</td>';
		echo'
		<td><form method="post">
		<input type="hidden" name="id" value="'.$info['id'].'">
		<input type="hidden"  name="clientad" value="'.$info['name'].'">
		<input type="hidden"  name="clientsoyad" value="'.$info['surname'].'">
		<button type="button" name="edit" class="btn btn-outline-info btn-sm edit" id="'.$info['id'].'"><i class="fas fa-edit" style="font-size:18px"></i></button>
		<button type="button" name="delete" class="btn btn-outline-danger btn-sm sil" id="'.$info['id'].'"><i class="far fa-trash-alt" style="font-size:18px"></i></button>
		
		</form></td>';
		echo'</tr>';
	}
{echo'
</tbody>
</table>
</div>';}

}




if(isset($_GET['istifadeciler']))
{
	if(isset($_POST['edit_id']))
{
	$edit = mysqli_query($con,"SELECT * FROM users WHERE id='".$_POST['edit_id']."' ");

	$einfo = mysqli_fetch_array($edit);
	echo'<div class="alert alert-info">
	<form method="post" enctype="multipart/form-data" id="updateForm">
	Ad:
	<input type="text" name="ad" class="form-control" value="'.$einfo['name'].'">
	Soyad:
	<input type="text" name="soyad" class="form-control" value="'.$einfo['surname'].'">
	Telefon:
	<input type="text" name="telefon" class="form-control" value="'.$einfo['phone'].'">
	Email:
	<input type="text" name="email" class="form-control" value="'.$einfo['email'].'">
	Parol:
	<input type="text" name="parol" class="form-control" value="'.$einfo['password'].'"><br>
	<img style="width:65px; height: 57px;" src="'.$einfo['foto'].'"><br>
	<input type="hidden" name="id" value="'.$einfo['id'].'">
	<input type="hidden" name="cari_foto" value="'.$einfo['foto'].'">
	<input type="hidden" name="update">
	<input type="file" name="foto"><br><br>
	<button type="button" name="update" class="btn btn-primary update">Yenilə</button>
	</form></div>';
}

if(isset($_POST['update']))
{
		$name=trim($_POST['ad']);
		$name=strip_tags($name);
		$name=htmlspecialchars($name);
		$name=mysqli_real_escape_string($con,$name);

		$surname=trim($_POST['soyad']);
		$surname=strip_tags($surname);
		$surname=htmlspecialchars($surname);
		$surname=mysqli_real_escape_string($con,$surname);

		$phone=trim($_POST['telefon']);
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

	if($_FILES['foto']['size']<1024)
		{$unvan = $_POST['cari_foto'];}

	else
		{include"upload.php";}

	if(!isset($error))
	{
		$update = mysqli_query($con,"UPDATE users SET 
														 	foto='".$unvan."',
		                                                    name='".$name."',
		                                                    surname='".$surname."',
		                                                    phone='".$phone."',
		                                                    email='".$email."',
		                                                    password='".$password."'

		                                                    WHERE id='".$_POST['id']."'	");

		if($update == true)
			{echo'Yenilendi';}
	}
}


if(isset($_POST['daxilet']))
{
		$name=trim($_POST['ad']);
		$name=strip_tags($name);
		$name=htmlspecialchars($name);
		$name=mysqli_real_escape_string($con,$name);

		$surname=trim($_POST['soyad']);
		$surname=strip_tags($surname);
		$surname=htmlspecialchars($surname);
		$surname=mysqli_real_escape_string($con,$surname);

		$phone=trim($_POST['telefon']);
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
		if(!isset($error))
		{
			include"upload.php";
				
						$daxilet = mysqli_query($con,"INSERT INTO users(name,surname,phone,email,password,tarix,foto)
							VALUES('".$name."','".$surname."','".$phone."','".$email."','".$password."','".$tarix."','".$unvan."') ");
				
							if($daxilet==true)
							{echo'Qeydiyyat tamamlandi';}
		}		
}



if(!isset($_POST['edit_id']))
{
	echo'<div class="alert alert-info">
	<form method="post" enctype="multipart/form-data" id="insertForm">
	Ad:
	<input type="text" name="ad" class="form-control">
	Soyad:
	<input type="text" name="soyad" class="form-control">
	Telefon:
	<input type="text" name="telefon" class="form-control">
	Email:
	<input type="text" name="email" class="form-control">
	Parol:
	<input type="text" name="parol" class="form-control"><br>
	<input type="file" name="foto"><br><br>
	<input type="hidden" name="daxilet">
	<button type="button" name="daxilet" class="btn btn-primary daxilet">Daxil et</button>
	<input type="hidden" name="cari_foto" value="'.$einfo['foto'].'">
	</form></div>';
}

//=====================ISTIFADECILER SELECT START=========================

$sec = mysqli_query($con, "SELECT * FROM users ORDER BY id DESC");

$i=0;
echo'<div class="table">
	<table class="table table-sm">
	<thead class="thead-dark">
	<th>#</th>
	<th>Foto</th>
	<th>İstifadəçi</th>
	<th>Əlaqə</th>
	<th>Email</th>
	<th>Qeydiyyat tarixi</th>
	<th></th>
	</thead><tbody>';
while($info = mysqli_fetch_array($sec))
{
	$i++;
	echo'<tr>';
	echo'<td>'.$i.'</td>';
	echo'<td><img style="width:55px; height:52px;" src="'.$info['foto'].'?>"></td>';
	echo'<td>'.$info['name'].' '.$info['surname'].'</td>';
	echo'<td>'.$info['phone'].'</td>';
	echo'<td>'.$info['email'].'</td>';
	echo'<td>'.$info['tarix'].'</td>';
	echo'<td><form method="post">
	<input type="hidden" name="id" value="'.$info['id'].'">';
	if($info['block']==1)
	{
		echo'<button type="submit" name="cancel" class="btn btn-danger btn-sm">Legv</button>';
	}

	else{
		echo'
		<button type="button" name="edit" class="btn btn-info btn-sm edit" id="'.$info['id'].'">Redakte</button>
		<button type="submit" name="delete" class="btn btn-danger btn-sm">Delete</button>
		<button type="submit" name="block" class="btn btn-warning btn-sm">Block</button>

		</td>';}

		echo'</form>';
	echo'</tr>';
}
echo'</tbody></table></div>';
}




if(isset($_GET['products']))
{

	if(isset($_POST['edit_id']))
	{
		$sec=mysqli_query($con, "SELECT * FROM trade WHERE id='".$_POST['edit_id']."' ");
		$info=mysqli_fetch_array($sec);

		echo'
			<form method="post" id="updateForm">
			Brand:<br>
			<select name="brand_id" class="form-control">
			<option value="">Brend seçin</option>';

		$bsec=mysqli_query($con,"SELECT * FROM brand ORDER BY ad ASC ");
				while($binfo=mysqli_fetch_array($bsec))
		{
			if($info['brand_id']==$binfo['id']){$x='selected';} else{$x='';}

			echo'<option '.$x.' value="'.$binfo['id'].'">'.$binfo['ad'].'</option>';
		}
		echo'
		</select>
		Məhsulun adı:<br>
		<input type="text" name="name" value="'.$info['name'].'" class="form-control">
		Alış qiyməti:<br>
		<input type="number" name="purchase" value="'.$info['purchase'].'" class="form-control">
		Satış qiyməti:<br>
		<input type="number" name="sale" value="'.$info['sale'].'" class="form-control">
		Miqdar:<br>
		<input type="number" name="amount" value="'.$info['amount'].'" class="form-control"><br>
		<input type="hidden" name="update">
		<button type="button" name="update" class="btn btn-primary update"><b>Update</b></button>
		<input type="hidden" name="id" value="'.$info['id'].'">
		</form>';
	}
	if(isset($_POST['update']))
	{	
	$name=trim($_POST['name']);
	$name=htmlspecialchars($name);
	$name=strip_tags($name);
	$name=mysqli_real_escape_string($con,$name);

	$purchase=trim($_POST['purchase']);
	$purchase=htmlspecialchars($purchase);
	$purchase=strip_tags($purchase);
	$purchase=mysqli_real_escape_string($con,$purchase);

	$sale=trim($_POST['sale']);
	$sale=htmlspecialchars($sale);
	$sale=strip_tags($sale);
	$sale=mysqli_real_escape_string($con,$sale);

	$amount=trim($_POST['amount']);
	$amount=htmlspecialchars($amount);
	$amount=strip_tags($amount);
	$amount=mysqli_real_escape_string($con,$amount);

	$brand_id=trim($_POST['brand_id']);
	$brand_id=htmlspecialchars($brand_id);
	$brand_id=strip_tags($brand_id);
	$brand_id=mysqli_real_escape_string($con,$brand_id);

	if(!empty($name) && !empty($purchase) && !empty($sale) && !empty($amount) && !empty($brand_id))
		{

		$update=mysqli_query($con,"UPDATE trade SET 
			name='".$name."',
			purchase='".$purchase."',
			sale='".$sale."',
			amount='".$amount."',
			brand_id='".$brand_id."'
			WHERE id='".$_POST['id']."' ");
			
			if($update==true)
				{echo'<div class="text-center">
							<div class="alert alert-primary" role="alert" style="font-size:18px">
								<b>Yeniləndi</b><i class="fas fa-sync"></i>
							</div>
						</div>';}
			else
				{echo'<div class="text-center">
							<div class="alert alert-danger" role="alert" style="font-size:18px">
								<b>Yenilənə bilmədi</b><i class="fas fa-times"></i>
							</div>
					</div>';}
		}
		else
			{echo'<div class="text-center">
						<div class="alert alert-warning" role="alert" style="font-size:18px">
							<b>Sətirləri doldurun</b><i class="fas fa-exclamation-circle"></i>
					</div>
				</div>';}
	}






if(isset($_POST['add']))
{
$name=trim($_POST['name']);
$name=htmlspecialchars($name);
$name=strip_tags($name);
$name=mysqli_real_escape_string($con,$name);

$purchase=trim($_POST['purchase']);
$purchase=htmlspecialchars($purchase);
$purchase=strip_tags($purchase);
$purchase=mysqli_real_escape_string($con,$purchase);

$sale=trim($_POST['sale']);
$sale=htmlspecialchars($sale);
$sale=strip_tags($sale);
$sale=mysqli_real_escape_string($con,$sale);

$amount=trim($_POST['amount']);
$amount=htmlspecialchars($amount);
$amount=strip_tags($amount);
$amount=mysqli_real_escape_string($con,$amount);

$brand_id=trim($_POST['brand_id']);
$brand_id=htmlspecialchars($brand_id);
$brand_id=strip_tags($brand_id);
$brand_id=mysqli_real_escape_string($con,$brand_id);

if(!empty($name) && !empty($purchase) && !empty($sale) && !empty($amount) && !empty($brand_id))
	{
		$add=mysqli_query($con, " INSERT INTO trade(userid,name,purchase,sale,amount,date1,brand_id) 
			VALUES('".$_SESSION['userid']."','".$name."','".$purchase."','".$sale."','".$amount."','".$tarix."','".$brand_id."') ");
			if($add==true)
				{echo'
					<div class="text-center">
							<div class="alert alert-success" role="alert" style="font-size:18px"><i class="fas fa-check-circle"></i>
								<b>Əlavə olundu!</b>
							</div>
						</div>';}
			else
				{echo'<div class="text-center">
									<div class="alert alert-danger" role="alert" style="font-size:18px"><i class="fas fa-times"></i>
									<b>Əlavə oluna bilmədi!</b>
								</div>
							</div>';}
	}
	else
		{echo'<div class="text-center">
						<div class="alert alert-warning" role="alert" style="font-size:20px"><i class="fas fa-exclamation-circle"></i>
							<b>Məlumatları tam doldurun!</b>
					</div>
				</div>';}
}

if(!isset($_POST['edit_id'])) 
{
		echo'
		<div class="alert alert-info" role="alert">
		<form method="post" id="insertForm">
		<b>Brand:</b><br>
		<select name="brand_id" class="form-control">
		<option value="">Brend seçin</option>';
	

$bsec=mysqli_query($con, "SELECT * FROM brand WHERE userid='".$_SESSION['userid']."' ORDER BY ad ASC");

	while($binfo=mysqli_fetch_array($bsec))

		{echo'<option value="'.$binfo['id'].'">'.$binfo['ad'].'</option>';}
		
		echo'
		</select>
		<b>Ad:</b><br>
		<input type="text" name="name" class="form-control">
		<b>Alış qiyməti:</b><br>
		<input type="number" name="purchase" class="form-control">
		<b>Satış qiyməti:</b><br>
		<input type="number" name="sale" class="form-control">
		<b>Miqdar:</b><br>
		<input type="number" name="amount" class="form-control"><br>
		<input type="hidden" name="add">
		<button type="button" name="add" class="btn btn-success add"><b>Add</b></button>
		</form>
		</div>';
		
}


//-----------------------------PRODUCT DELETE START---------------------------------

	if(isset($_POST['del_id']))
	{
			$check=mysqli_query($con, "SELECT productid FROM orders WHERE productid='".$_POST['del_id']."' ");
				$a=mysqli_num_rows($check);
				if($a>0)
					{echo'<div class="text-center">
							<div class="alert alert-warning" role="alert" style="font-size:18px">
								<b>Məhsul sifariş edilib!</b>
							</div>
						</div>';}
				else
					{$delete=mysqli_query($con,"DELETE FROM trade WHERE id='".$_POST['del_id']."' ");
						if($delete==true)
							{echo'<div class="text-center">
										<div class="alert alert-success" role="alert" style="font-size:18px"><i class="fas fa-cut"></i>
										<b>Silindi!</b>
									</div>
								</div>';}
						else
							{echo'<div class="text-center">
										<div class="alert alert-danger" role="alert" style="font-size:18px"><i class="fas fa-times"></i>
											<b>Silinə bilmədi!</b>
									</div>
								</div>';}
				}
	

	
	}
//------------------------PRODUCT DELETE END ---------------------------

	if($_GET['f1']=='ASC')
	{$order='ORDER BY ad ASC';
	$f1='<a href="?f1=DESC#cedvel"><i class="bi bi-sort-alpha-down-alt"></i></a>';}

	elseif($_GET['f1']== 'DESC')
	{
		$order='ORDER BY ad DESC';
		$f1='<a href="?f1=ASC#cedvel"><i class="bi bi-sort-alpha-down"></i></a> ';
	}

	else
		{$f1='<a href="?f1=DESC#cedvel"><i class="bi bi-sort-alpha-down"></i></a> ';}


	if($_GET['f2']=='ASC')

	{$order='ORDER BY name ASC';
	$f2='<a href="?f2=DESC#cedvel"><i class="bi bi-sort-alpha-down-alt"></i></a>';}

	elseif($_GET['f2']== 'DESC')
	{
		$order='ORDER BY name DESC';
		$f2='<a href="?f2=ASC#cedvel"><i class="bi bi-sort-alpha-down"></i></a> ';
	}

	else
		{$f2='<a href="?f2=DESC#cedvel"><i class="bi bi-sort-alpha-down"></i></a> ';}


	if($_GET['f3']=='ASC')
	{$order='ORDER BY date1 ASC';
	$f3='<a href="?f3=DESC#cedvel"><i class="bi bi-sort-alpha-down-alt"></i></a>';}

	elseif($_GET['f3']== 'DESC')
	{
		$order='ORDER BY date1 DESC';
		$f3='<a href="?f3=ASC#cedvel"><i class="bi bi-sort-alpha-down"></i></a> ';
	}

	else
		{$f3='<a href="?f3=DESC#cedvel"><i class="bi bi-sort-alpha-down"></i></a> ';}

	if(!isset($_GET['f1']) && !isset($_GET['f2']) && !isset($_GET['f3']))
	{$order = ' ORDER BY id DESC ';}


	$sec=mysqli_query($con,"SELECT 
								trade.id,
								trade.name ,
								trade.purchase,
								trade.sale,
								trade.amount,
								trade.date1,
								brand.ad 
								FROM brand,trade WHERE brand.id=trade.brand_id AND trade.userid='".$_SESSION['userid']."' 
								".$axtar.$order);


	$say=mysqli_num_rows($sec);

	if($say==0)
				{echo'<div class="text-center">
						<div class="alert alert-warning" role="alert">
							<b>Məlumat tapılmadı</b>
						</div>
					</div>';}


	echo'<b>Overall: '.$say.'</b><br>';
		
		$i=0;
		echo'<div class="table-striped" id="cedvel">
			<form method="post">
				<table class="table table-sm" id="cedvel">
				<thead class="thead-dark">
					<th>#</th>
					<th>Brend'.$f1.'</th>
					<th>Ad'.$f2.'</th>
					<th>Alış</th>
					<th>Satış</th>
					<th>Miqdar</th>
					<th>Tarix'.$f3.'</th>
					<th><button type="submit" name="secsil" class="btn btn-danger btn-sm">Seçilənləri sil</button> </th>
				</thead></form>
				<tbody>';

		while($info=mysqli_fetch_array($sec))
		{
			$i++;
			echo'<tr>';
			echo'<td><input type="checkbox" name="secilmis[]" value="'.$info['id'].'"> <b>'.$i.'</b></td>';
			echo'<td>'.$info['ad'].'</td>';
			echo'<td>'.$info['name'].'</td>';
			echo'<td>'.$info['purchase'].'</td>';
			echo'<td>'.$info['sale'].'</td>';
			echo'<td>'.$info['amount'].'</td>';
			echo'<td>'.$info['date1'].'</td>';
			echo'
			<form method="post">
			<td>
			<input type="hidden" name="id" value="'.$info['id'].'">
			<input type="hidden" name="ad" value="'.$info['ad'].'">
			<button type="button" name="edit" class="btn btn-outline-info btn-sm edit" id="'.$info['id'].'"><i class="fas fa-edit" style="font-size:19px"></i></button>
			<button type="button" name="delete" class="btn btn-outline-danger btn-sm sil" id="'.$info['id'].'"><i class="far fa-trash-alt" style="font-size:19px"></i></button>
			</td></form>';
			echo'</tr>';
		}

	{echo'</tbody></table>
		</div>
		</div>';}
}

if(isset($_GET['orders'])){


//=====================================ORDERS INSERT START=============================
if(isset($_POST['add']))
 {
 $miqdar=trim($_POST['miqdar']);
 $miqdar=htmlspecialchars($miqdar);
 $miqdar=strip_tags($miqdar);
 $miqdar=mysqli_escape_string($con, $miqdar);

 $pid=trim($_POST['pid']);
 $pid=htmlspecialchars($pid);
 $pid=strip_tags($pid);
 $pid=mysqli_escape_string($con, $pid);

 $cid=trim($_POST['cid']);
 $cid=htmlspecialchars($cid);
 $cid=strip_tags($cid);
 $cid=mysqli_escape_string($con, $cid);

 	if(!empty($miqdar))
 	{
 		$add=mysqli_query($con, "INSERT INTO orders(userid,clientid,productid,miqdar,tarix) 
			VALUES('".$_SESSION['userid']."','".$cid."','".$pid."','".$miqdar."','".$tarix."') ");
 			if($add==true)
 			{
 				echo'<div class="text-center">
							<div class="alert alert-success" role="alert" style="font-size:18px"><i class="fas fa-check-circle"></i>
								<b>Əlavə olundu!</b>
							</div>
						</div>';
 			}
 			else
 				{echo'<div class="text-center">
									<div class="alert alert-danger" role="alert" style="font-size:18px"><i class="fas fa-times"></i>
									<b>Əlave oluna bilmədi!</b>
								</div>
							</div>';}
 	}
 	else
 		{echo'<div class="text-center">
						<div class="alert alert-warning" role="alert" style="font-size:18px"><i class="fas fa-exclamation-circle"></i>
							<b>Məlumatları tam doldurun!</b>
					</div>
				</div>';}
 }


if(!isset($_POST['edit']))
{
echo'<div class="alert alert-info">
<form method="post" id="insertForm">
<b>Müştəri:</b><br>
<select name="cid" class="form-control">
<option value="">Müştəri seçin</option><br>';

$csec=mysqli_query($con,"SELECT * FROM clients WHERE userid='".$_SESSION['userid']."' ".$axtar." ORDER BY name ASC");

	while($cinfo=mysqli_fetch_array($csec))
	{
		echo'<option value="'.$cinfo['id'].'">'.$cinfo['name'].' '.$cinfo['surname'].'</option>';
	}

$csay=mysqli_num_rows($csec);

{echo'
</select>
<b>Məhsul:</b><br>
<select name="pid" class="form-control">
<option value="">Məhsul seçin</option><br>';}

$psec=mysqli_query($con,"SELECT 
							brand.ad,
							trade.name,
							trade.amount,
							trade.brand_id,
							trade.id
							FROM trade,brand WHERE 
													brand.id=trade.brand_id AND
													trade.userid='".$_SESSION['userid']."' ORDER BY trade.id DESC");

	while($pinfo=mysqli_fetch_array($psec))
	{
		echo'<option value="'.$pinfo['id'].'">'.$pinfo['ad'].'/'.$pinfo['name'].'-'.$pinfo['amount'].'</option>';
	}
	{echo'
	</select>
 	<b>Miqdar:</b><br>
 	<input type="text" name="miqdar" class="form-control"><br>
 	<input type="hidden" name="add">
 	<button type="submit" name="add" class="btn btn-success add"><b>Əlavə et</b></button>
 </form>
 </div>';}
}

//=====================================ORDERS INSERT END===============================






//-----------------------------ORDERS DELETE START-----------------------------

	if(isset($_POST['del_id']))
		{
			$delete=mysqli_query($con," DELETE FROM orders WHERE id='".$_POST['del_id']."' ");
			
			if($delete==true)
			{
				echo'<div class="text-center">
								<div class="alert alert-success" role="alert" style="font-size:18px"><i class="fas fa-cut"></i>
								<b>Silindi!</b>
							</div>
						</div>';
			}
			else
				{echo'<div class="text-center">
								<div class="alert alert-danger" role="alert" style="font-size:18px"><i class="fas fa-times"></i>
									<b>Silinə bilmədi!</b>
							</div>
						</div>';}
		}

		
//--------------------------------ORDERS DELETE END-------------------------------


	$bsec=mysqli_query($con, "SELECT * FROM brand WHERE userid='".$_SESSION['userid']."' ORDER BY ad ASC");

	$bsay=mysqli_num_rows($bsec);

	$osec=mysqli_query($con,"SELECT * FROM orders WHERE userid='".$_SESSION['userid']."' ORDER BY id DESC" );

	$osay=mysqli_num_rows($osec);


	//Toplam xerc
	$xsec = mysqli_query($con,"SELECT SUM(sum) AS txerc FROM expense WHERE userid='".$_SESSION['userid']."'");

	$xinfo = mysqli_fetch_array($xsec);

	if($_GET['f1']=='ASC')
	{
		$order='ORDER BY tarix ASC';

		$f1='<a href="?f1=DESC#cedvel"><i class="bi bi-sort-alpha-down-alt"></i></a>';
	}

	elseif($_GET['f1']=='DESC')
	{
		$order='ORDER BY tarix DESC';
		$f1='<a href="?f1=ASC#cedvel"><i class="bi-sort-alpha-down"></i></a> ';
	}

	else
	{
		$f1='<a href="?f1=ASC#cedvel"><i class="bi-sort-alpha-down"></i></a> ';
	}

	if($_GET['f2']=='ASC')
	{
		$order='ORDER BY ad ASC';

		$f2='<a href="?f2=DESC#cedvel"><i class="bi bi-sort-alpha-down-alt"></i></a>';
	}

	elseif($_GET['f2']=='DESC')
	{
		$order='ORDER BY ad DESC';
		$f2='<a href="?f2=ASC#cedvel"><i class="bi-sort-alpha-down"></i></a> ';
	}

	else
	{
		$f2='<a href="?f2=ASC#cedvel"><i class="bi-sort-alpha-down"></i></a> ';
	}


	if($_GET['f3']=='ASC')

	{$order='ORDER BY imya ASC';
	$f3='<a href="?f3=DESC#cedvel"><i class="bi bi-sort-alpha-down-alt"></i></a>';}

	elseif($_GET['f3']== 'DESC')
	{
		$order='ORDER BY imya DESC';
		$f3='<a href="?f3=ASC#cedvel"><i class="bi bi-sort-alpha-down"></i></a> ';
	}

	else
		{$f3='<a href="?f3=DESC#cedvel"><i class="bi bi-sort-alpha-down"></i></a> ';}

	if(!isset($_GET['f1']) && !isset($_GET['f2']) && !isset($_GET['f3']))
	{
		$order= 'ORDER BY id DESC';
	}


	$sec=mysqli_query($con, " SELECT
								clients.name AS ad1,
								clients.surname,
								brand.ad, 
								trade.name AS imya,
								trade.purchase,
								trade.sale,
								trade.amount,
								orders.id,
								orders.miqdar, 
								orders.tarix,
								orders.productid,
								orders.tesdiq,
								trade.name AS isim 
								FROM orders,clients,trade,brand WHERE
								orders.userid= '".$_SESSION['userid']."' AND
								clients.id=orders.clientid AND 
								brand.id=trade.brand_id AND
								trade.id=orders.productid 
								 ".$order);




	$tcsec=mysqli_query($con, "SELECT 
										trade.sale,
										trade.purchase,
										orders.tesdiq,
										orders.miqdar
										FROM trade,orders WHERE trade.id=orders.productid AND orders.tesdiq=1 ");

	while($tcinfo=mysqli_fetch_array($tcsec))
	{
		$tcalis=$tcinfo['purchase']*$tcinfo['miqdar']+ $tcalis;
		$tcsatis=$tcinfo['sale']*$tcinfo['miqdar'] + $tcsatis;

	}
	$tcqazanc=$tcsatis-$tcalis;



	$psec = mysqli_query($con, "SELECT * FROM trade WHERE userid='".$_SESSION['userid']."' ");

	$i = 0;
	while($info=mysqli_fetch_array($psec))
	{
		$i++;
		$talish = ($info['purchase'] * $info['amount']) + $talish;
		$tsatish = ($info['sale'] * $info['amount']) + $tsatish;
		$tmehsul = $info['amount'] + $tmehsul;
		$tqazanc = (($info['sale'] - $info['purchase']) * $info['amount']) + $tqazanc;
	}

		{echo'<div class="alert alert-info" role="alert" style="font-size:16px"> 
				<b>Məhsul: </b> '.$tmehsul.' &nbsp |
				<b>Alış: </b> '.$talish.'  &nbsp |
				<b>Satış: </b> '.$tsatish.' &nbsp |
				<b>Toplam qazanc: </b> '.$tqazanc.' &nbsp |
				<b>Cari qazanc:</b> '.$tcqazanc.' &nbsp |
				<b>Müştəri sayı:</b> '.$csay.' &nbsp |
				<b>Brend sayı:</b> '.$bsay.' &nbsp |
				<b>Sifariş sayı:</b> '.$osay.'  &nbsp |	
				<b>Xərc:</b> '.$xinfo['txerc'].'
				</div>';}

	$i=0;

	echo'<div class="table-hover">
		<form method="post">
		<table class="table table-sm" id="cedvel">
		<thead class="thead-dark">
		<th>#</th>
		<th>Müştəri</th>
		<th>Brend'.$f2.'</th>
		<th>Məhsul'.$f3.'</th>
		<th>Alış</th>
		<th>Satış</th>
		<th>Məhsulun miqdarı</th>
		<th>Sifariş sayı</th>
		<th>Qazanc</th>
		<th>Tarix'.$f1.'</th>
		<th><button type="submit" name="secsil" class="btn btn-danger btn-sm">Seçilənləri sil</button></th>
		
		</thead></form>
		<tbody>';

	while($info=mysqli_fetch_array($sec))
	{
		$qazanc=($info['sale']-$info['purchase'])*$info['miqdar'];
		$i++;
		
		echo'<tr>';
		echo'<td><input type="checkbox" name="secilmis[]" value="'.$info['id'].'">  <b>'.$i.'</b></td>';
		echo'<td>'.$info['ad1'].' '.$info['surname']. '</td>';
		echo'<td>'.$info['ad'].'</td>';
		echo'<td>'.$info['imya'].'</td>';
		echo'<td>'.$info['purchase'].'</td>';
		echo'<td>'.$info['sale'].'</td>';
		echo'<td>'.$info['amount'].'</td>';
		echo'<td>'.$info['miqdar'].'</td>';
		echo'<td>'.$qazanc.'</td>';
		echo'<td>'.$info['tarix'].'</td>';
		echo'<form method="post"><td>
		
		<input type="hidden" name="bad" value="'.$info['ad'].'">
		<input type="hidden" name="id" value="'.$info['id'].'">
		<input type="hidden" name="pid" value="'.$info['productid'].'">
		<input type="hidden" name="smiq" value="'.$info['miqdar'].'">
		<input type="hidden" name="pmiq" value="'.$info['amount'].'">';

		if($info['tesdiq']==0)
			{echo'

		<button type="submit" name="edit" class="btn btn-outline-info" title="Redaktə et"><i class="fas fa-edit" style="font-size:16px"></i></button>
		<button type="button" name="delete" class="btn btn-outline-danger sil" id="'.$info['id'].'" title="Sil" ><i class="far fa-trash-alt" style="font-size:16px"></i></button>
		<button type="submit" name="confirm" class="btn btn-outline-success" title="Təsdiqlə"><i class="fas fa-check" style="font-size:16px"></i></button>';}
		
		else
			{echo'<button type="submit" name="cancel" class="btn btn-outline-danger" title="Cancel"><i class="fas fa-times" style="font-size:16px"></i></button>';}

	echo'</td></form>';
	echo'</tr>';
	}

	echo'</tbody></table></div>';
}
if(isset($_GET['xerc'])){


if(isset($_POST['edit_id']))
{
	$sec=mysqli_query($con, "SELECT * FROM expense WHERE id='".$_POST['edit_id']."' ");
	$info=mysqli_fetch_array($sec);
	echo'
	<form method="post" id="updateForm">
	Təyinat:<br>
	<input type="text" name="teyinat" class="form-control" value="'.$info['teyinat'].'"><br>
	Məbləğ:<br>
	<input type="text" name="sum" class="form-control" value="'.$info['sum'].'"><br>
	<input type="hidden" name="update">
	<button type="button" name="update" class="btn btn-primary btn-sm update">Update</button>
	<input type="hidden" name="id" value="'.$info['id'].'">
	</form>';

}
if(isset($_POST['update']))
{
$teyinat=trim($_POST['teyinat']);
$teyinat=htmlspecialchars($teyinat);
$teyinat=strip_tags($teyinat);
$teyinat=mysqli_real_escape_string($con,$teyinat);

$sum=trim($_POST['sum']);
$sum=htmlspecialchars($sum);
$sum=strip_tags($sum);
$sum=mysqli_real_escape_string($con,$sum);

	if(!empty($teyinat) && !empty($sum))
	{
		$update=mysqli_query($con,"UPDATE expense SET 
			teyinat='".$_POST['teyinat']."',
			sum='".$_POST['sum']."'
			WHERE id='".$_POST['id']."' ");
	
	if($update==true)
		{echo'<div class="text-center">
						<div class="alert alert-primary" role="alert" style="font-size:18px"><i class="fas fa-sync"></i>
							<b>Yeniləndi!</b>
					</div>
				</div>';}
	else
		{echo'<div class="text-center">
						<div class="alert alert-danger" role="alert" style="font-size:18px"><i class="fas fa-exclamation-circle"></i>
							<b>Yenilənə bilmədi!</b>
					</div>
				</div>';}
	}
	else
		{echo'<div class="text-center">
					<div class="alert alert-warning" role="alert" style="font-size:18px"><i class="fas fa-exclamation-circle"></i>
						<b>Məlumatları tam doldurun!</b>
				</div>
			</div>';}
}





if(isset($_POST['add']))
{
$teyinat=trim($_POST['teyinat']);
$teyinat=htmlspecialchars($teyinat);
$teyinat=strip_tags($teyinat);
$teyinat=mysqli_real_escape_string($con,$teyinat);

$sum=trim($_POST['sum']);
$sum=htmlspecialchars($sum);
$sum=strip_tags($sum);
$sum=mysqli_real_escape_string($con,$sum);

	if(!empty($teyinat) && !empty($sum))
	{
		$add=mysqli_query($con, "INSERT INTO expense(userid,teyinat,sum,date1) 
			VALUES('".$_SESSION['userid']."','".$teyinat."','".$sum."','".$tarix."') ");
			if($add==true)
				{echo'<div class="text-center">
							<div class="alert alert-success" role="alert" style="font-size:18x"><i class="fas fa-check-circle"></i>
								<b>Əlave olundu!</b>
							</div
						</div>';}
			
			else
				{echo'<div class="text-center">
								<div class="alert alert-danger" role="alert" style="font-size:18px"><i class="fas fa-times"></i>
									<b>Əlavə oluna bilmədi!</b>
								</div
							</div>';}
	}
	else
		{echo'<div class="text-center">
						<div class="alert alert-warning" role="alert" style="font-size:18px"><i class="fas fa-exclamation-circle"></i>
						<b>Məlumatları tam doldurun!</b>
					</div>
				</div>';}
}

if(!isset($_POST['edit_id']))
{
	echo'<div class="alert alert-info" role="alert">
	<form method="post" id="insertForm">
	 	<b>Təyinat:</b><br>
	 	<input type="text" name="teyinat" class="form-control">
	 	<b>Məbləğ:</b><br>
	 	<input type="number" name="sum" class="form-control"><br>
	 	<input type="hidden" name="add">
	 	<button type="button" name="add" class="btn btn-success btn add"><b>Əlavə et</b></button><br>
	 </form></div>';
}





//-------------------------XERC DELETE START-------------------------------


	if(isset($_POST['del_id']))
	{
		$delete=mysqli_query($con,"DELETE FROM expense WHERE id='".$_POST['del_id']."' ");

		if($delete=true)
			{echo'<div class="text-center">
							<div class="alert alert-success" role="alert" style="font-size:18px><i class="fas fa-cut"></i>
							<b>Silindi!</b>
						</div>
					</div>';}
		else
			{echo'<div class="text-center">
							<div class="alert alert-danger" role="alert" style="font-size:18px"><i class="fas fa-times"></i>
								<b>Silinə bilmədi!</b>
						</div>
					</div>';}
	}
	

	if($_GET['f1']=='ASC')
	{
		$order='ORDER BY date1 ASC ';

		$f1='<a href="?f1=DESC#cedvel" class="filter"><i class="bi bi-sort-alpha-down-alt"></i></a>';
	}

	elseif($_GET['f1']=='DESC')
	{
		$order='ORDER BY date1 DESC';

		$f1='<a href="?f1=ASC#cedvel" ><i class="bi bi-sort-alpha-down"></i></a> ';
	}

	else
		{$f1='<a href="?f1=DESC#cedvel" ><i class="bi bi-sort-alpha-down"></i></a> ';}

	if($_GET['f2']=='ASC')
	{
		$order='ORDER BY teyinat ASC';
		$f2='<a href="?f2=DESC#cedvel"><i class="bi bi-sort-alpha-down-alt"></i></a> ';
	}

	elseif($_GET['f2']=='DESC')
	{
		$order='ORDER BY teyinat DESC';
		$f2='<a href="?f2=ASC#cedvel"> <i class="bi bi-sort-alpha-down"></i></a>';
	}

	else
	{
		$f2='<a href="?f2=DESC#cedvel"><i class="bi bi-sort-alpha-down"></i></a>  ';
	}

	if(!isset($_GET['f1']) && !isset($_GET['f2']))
	{
		$order='ORDER BY id DESC';
	}

	$sec=mysqli_query($con, "SELECT * FROM expense WHERE userid='".$_SESSION['userid']."' ".$axtar.$order);
	$say=mysqli_num_rows($sec);
	{echo'Overall: '.$say;}
	
	$i=0;
	echo'<div class="table-striped">
			<form method="post">
			<table class="table table-sm" id="cedvel">
				<thead class="thead-dark">
					<th>#</th>
					<th>Təyinat'.$f2.'</th>
					<th>Məbləğ</th>
					<th>Tarix'.$f1.'</th>
					<th><button type="submit" name="secsil" class="btn btn-danger btn-sm">Seçilənləri sil</button></th>
					
				</thead>
				<tbody></form>';

	while($info=mysqli_fetch_array($sec))
	{
		$i++;
		echo'<tr>';
		echo'<td><input type="checkbox" name="secilmis[]" value="'.$info['id'].'"> <b>'.$i.'</b></td>';
		echo'<td>'.$info['teyinat'].'</td>';
		echo'<td>'.$info['sum'].'</td>';
		echo'<td>'.$info['date1'].'</td>';
		echo'
		<form method="post"><td>
		<input type="hidden" name="id" value="'.$info['id'].'">
		<button type="button" name="edit" class="btn btn-outline-info btn-sm edit" id="'.$info['id'].'"><i class="fas fa-edit" style="font-size:19px"></i></button>
		<button type="button" name="delete" class="btn btn-outline-danger btn-sm sil" id="'.$info['id'].'"><i class="far fa-trash-alt" style="font-size:19px"></i></button>
			</td></form>';
		echo'</tr>';
	}

	echo'</tbody>
	</table>
	</div>';
}
?>

