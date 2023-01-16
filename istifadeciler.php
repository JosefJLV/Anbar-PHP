<?php 
include "header.php";
echo'<div class="container">';


if(isset($_POST['delete']))
{
	echo'<form method="post">
	<div class= "alert alert-danger">
	İstifadəçi silinsin mi?<br>
	<button type="submit" name="yes" class="btn btn-danger btn-sm">Bəli</button>
	<button type="submit" name="no" class="btn btn-success btn-sm">Xeyr</button>
	<input type="hidden" name="id" value="'.$_POST['id'].'">
	</form>
	</div>';
}

	if(isset($_POST['yes']))
		{$sil = mysqli_query($con, "DELETE FROM users WHERE id='".$_POST['id']."' ");

	if($sil == true)

		{echo'Silindi';}

}

if(isset($_POST['block']))
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

	$block=mysqli_query($con, "UPDATE users SET block=1 WHERE id='".$_POST['id']."' ");
	if($block==true)
	{
		echo'Blocklandi';
	}

}

if(isset($_POST['cancel']))
{
	$cancel=mysqli_query($con, "UPDATE users SET block=0 WHERE id='".$_POST['id']."' ");
	if($cancel==true)
	{
		echo'Blockdan cixarildi';
	}
}

?>
<div id="result"><img style="width:50px; height:50px;" class="rounded mx-auto d-block" src="https://cutewallpaper.org/21/loading-gif-transparent-background/Bee-Hollow-Farm-beekeeping-classes-and-events-near-Schodack-.gif"></div>


<?php
echo'</div>';
?>


<script>
	$(document).on('click','.update',function(event){
		event.preventDefault()

		let form = $('#updateForm')[0]
		let data = new FormData(form)

		$.ajax({
			type: 'POST',
			enctype:'multipart/form-data',
			url: 'loader.php?istifadeciler',
			data : data,
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

	$(document).on('click','.edit',function(){
		let id = $(this).attr('id')

		if(confirm('Edit etmek isteyirsinizmi?')){
		
				$.ajax({
					type: 'POST',
					url: 'loader.php?istifadeciler',
					data:{edit_id:id},
					success: function(response){
										$('#result').html('')
										$('#result').html(response)}
				})
			}
	})

	$(document).on('click','.daxilet',function(event){
		event.preventDefault()

		let form = $('#insertForm')[0]
		let data = new FormData(form)

		$.ajax({
			type: 'POST',
			enctype:'multipart/form-data',
			url: 'loader.php?istifadeciler',
			data : data,
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

	$(document).ready(function(){
		$.ajax({
			type:'GET',
			url:'loader.php?istifadeciler',
			dataType: 'html',
			success: function(response){
				$('#result').html(response)
			}

		})
	})
</script>