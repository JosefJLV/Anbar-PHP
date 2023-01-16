<?php 
include'header.php';
echo'<div class=container>';



if(isset($_POST['confirm']))
{
	if($_POST['smiq']<=$_POST['pmiq'])
	{
		$pupdate= mysqli_query($con, "UPDATE trade SET amount= amount-".$_POST['smiq']." WHERE id='".$_POST['pid']."' ");

		if($pupdate==true)
		{
			$supdate= mysqli_query($con, "UPDATE orders SET tesdiq=1  WHERE id='".$_POST['id']."' ");
		}
		if($supdate==true)
			{echo'<div class="text-center">
					<div class="alert alert-success" role="alert" style="font-size:18px">
						<b>Sifariş təsdiq olundu</b> <i class="fas fa-check-circle"></i>
					</div>
				</div>';}

		else
		{
			$pupdate= mysqli_query($con, "UPDATE trade SET amount= amount+".$_POST['smiq']." WHERE id='".$_POST['productid']."' ");
			
			echo'<div class="text-center">
					<div class="alert alert-danger" role="alert" style="font-size:18px">
						<b>Sifarişi təsdiq etmək mümkün olmadı</b> <i class="fas fa-times"></i>
					</div>
				</div>';
		}
	}
	else
		{echo'<div class="text-center">
				<div class="alert alert-warning" role="alert" style="font-size:18px">
					<b>Kifayət qədər məhsul yoxdur</b> <i class="fas fa-exclamation-circle"></i>
				</div>
			</div>';}
}

 if(isset($_POST['cancel']))
 {
 	$pupdate= mysqli_query($con, "UPDATE trade SET amount= amount+".$_POST['smiq']." WHERE id='".$_POST['pid']."' ");

 	if($pupdate==true)

 	{
 		$supdate= mysqli_query($con, "UPDATE orders SET tesdiq=0  WHERE id='".$_POST['id']."' ");

 	if($supdate==true)
 		{echo'<div class="text-center">
 				<div class="alert alert-warning" role="alert" style="font-size:18px">
 					<b>Sifariş ləğv olundu</b> <i class="fas fa-exclamation-circle"></i>
 				</div>
 			</div> ';}
	}
 	else
 		{echo'<div class="text-center">
 				<div class="alert alert-warning" role="alert" style="font-size:18px">
 					<b>Sifariş ləğv oluna bilmədi</b> <i class="fas fa-exclamation-circle"></i>
 				</div>
 			</div>';}
 	
 }

if(isset($_POST['edit']))
{
	$sec=mysqli_query($con,"SELECT * FROM orders WHERE id='".$_POST['id']."'  ");

	$info=mysqli_fetch_array($sec);
	
	echo'<form method="post">
	Mushteri:<br>
	<select name="cid" class="form-control">
	<option value="">Müştəri seçin</option><br>';

	$csec=mysqli_query($con,"SELECT * FROM clients ORDER BY name ASC");

	while($cinfo=mysqli_fetch_array($csec))
	{
		if($info['clientid']==$cinfo['id']) {$x='selected';} else{$x='';}

		{echo'<option '.$x.' value="'.$cinfo['id'].'">'.$cinfo['name'].' '.$cinfo['surname'].'</option>';}
	}

	echo'</select>
		Mehsul:<br>
		<select name="pid" class="form-control">
		<option value="">Məhsul seçin</option><br>';


	$psec=mysqli_query($con, "SELECT * FROM trade ORDER BY name ASC");

	while($pinfo=mysqli_fetch_array($psec))
	{
		if($info['productid']==$pinfo['id']) {$x='selected';} else{$x='';}

		echo'<option '.$x.' value="'.$pinfo['id'].'">'.$pinfo['name'].'</option>';
	}

	echo'</select>
	<b>Miqdar:</b><br>
 	<input type="text" name="miqdar" value="'.$info['miqdar'].'" class="form-control"><br>
	<button type="submit" name="update" class="btn btn-primary"><b>Update</b></button>
	<input type="hidden" name="id" value="'.$info['id'].'">
	</form>';
}

if(isset($_POST['update']))
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
 
	$update=mysqli_query($con, " UPDATE orders SET 
									clientid='".$cid."',
									productid='".$pid."',
									miqdar='".$miqdar."'
									WHERE id='".$_POST['id']."' ");
		if($update==true)
			{echo'<div class="text-center">
					<div class="alert alert-primary" role="alert" style="font-size:18px">
							<b>Redaktə edildi</b><i class="fas fa-sync"></i>
						</div>
					</div>	';}

		else
			{echo'<div class="text-center">
						<div class="alert alert-danger" role="alert" style="font-size:18px">
							<b>Redaktə edilə bilmədi</b><i class="fas fa-times"></i>
						</div>
				</div>';}
}






if(isset($_POST['axtar']) && !empty($_POST['query']))
{
	$axtar=" AND (miqdar LIKE '%".$_POST['query']."%') ";

	$yoxlama=mysqli_query($con, "SELECT * FROM orders WHERE miqdar='".$_POST['query']."' ");

	$say=mysqli_num_rows($yoxlama);

		if($say==0)
			{echo'<div class="text-center">
					<div class="alert alert-warning" role="alert">
						<b>Məlumat tapılmadı</b>
					</div>
				</div>';}
}

//Secilmisleri sil

if(isset($_POST['secilmis']) && isset($_POST['secsil']))
{
	for($i=0;$i<count($_POST['secilmis']); $i++){

		$sil=mysqli_query($con, "DELETE FROM orders WHERE id='".$_POST['secilmis'][$i]."' ");
	}
	if($sil==true)
	{
		echo'<div class="text-center">
				<div class="alert alert-info" role="alert" style="font-size:16px">
					<b>Seçilmiş sifarişlər silindi!</b>
				</div>
			</div>';
	}
}



?>


<div id="result"><img style="width:50px; height:50px;" class="rounded mx-auto d-block" src="https://cutewallpaper.org/21/loading-gif-transparent-background/Bee-Hollow-Farm-beekeeping-classes-and-events-near-Schodack-.gif"></div>

<?php
echo'</div>';
 ?>
 <script>
 	$(document).on('click','.add',function(event){
 		event.preventDefault()

 		let form = $('#insertForm')[0]
 		let data = new FormData(form)

 		$.ajax({
 			type :'POST',
 			enctype: 'multipart/form-data',
 			url: 'loader.php?orders',
 			data: data,
 			processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            beforeSend: function(){
								$('#result').html('<img style="width:50px; height:50px;" class="rounded mx-auto d-block" src="https://cutewallpaper.org/21/loading-gif-transparent-background/Bee-Hollow-Farm-beekeeping-classes-and-events-near-Schodack-.gif">')
            },
            success: function (response) {
								$('#result').html(response)
            }
 		})
 	})


 	$(document).on('click','.sil',function(){

 		let id = $(this).attr('id')

 		if(confirm('Sifaris silinsinmi?'))
 		{
 			$.ajax({
 				type: 'POST',
 				url: 'loader.php?orders',
 				data:{del_id:id},
 				success: function(response){

 					$('#result').html('')
 					$('#result').html(response)
 				}
 			})
 		}
 	})

 	$(document).ready(function(){
 		$.ajax({
 			type: 'GET',
 			url: 'loader.php?orders',
 			dataType: 'html',
 			success: function(response){
 			$('#result').html(response)
 			}
 		})
 	})

 </script>