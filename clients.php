<?php 
include'header.php';
echo'<div class=container>';


$tarix=date('Y-m-d H:i:s');



if(isset($_POST['axtar']) && !empty($_POST['query']))
{
	$axtar="WHERE(name LIKE'%".$_POST['query']."%' OR surname LIKE '%".$_POST['query']."%' OR phone LIKE '%".$_POST['query']."%' or company LIKE '%".$_POST['query']."%')";

	$yoxlama=mysqli_query($con, "SELECT * FROM clients WHERE name='".$_POST['query']."' OR surname='".$_POST['query']."' 
		OR phone='".$_POST['query']."' OR company='".$_POST['query']."' ");

		$say=mysqli_num_rows($yoxlama);
		if($say==0)
			{echo'<div class="text-center">
					<div class="alert alert-warning" style="font-size:18px" role="alert">
							<b>Məlumat tapılmadı!</b>
					</div>
				</div>';}
}


//SEcilmislerin silinmesi

if(isset($_POST['secsil']) && isset($_POST['secilmis']))
{
	for($i=0; $i<count($_POST['secilmis']); $i++){

		$check1=mysqli_query($con,"SELECT clientid FROM orders WHERE clientid='".$_POST['id']."' ");

		$b=mysqli_num_rows($check1);
		if($b>0){
			echo'<div class="text-center">
					<div class="alert alert-warning" role="alert" style="font-size:18p"> 
						<b>Müştərinin sifarişi var!</b>
					</div>
				</div>';}
		else
			echo'<div class="alert alert-danger" role="alert">
								<form method="post">
								<b>Silmək istəyirsiniz mi?</b><br>
								<input type="hidden" name="id" value="'.$_POST['id'].'">
								<button type="submit" name="beli" class="btn btn-danger btn-sm">Bəli</button>
								<button type="submit" name="xeyr" class="btn btn-primary btn-sm">Xeyr</button>
				</form> </div>';
	}

}
if(isset($_POST['beli']))
{
	$sil=mysqli_query($con,"DELETE FROM clients WHERE id='".$_POST['secilmis'][$i]."' ");
	if($sil==true)
	{
		echo'<div class="text-center">
				<div class="alert alert-info" role="alert" style="font-size:18px">
					<b>Silindi!</b>
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
	$(document).on('click','.update',function(event){
		event.preventDefault()
		let form = $('#updateForm')[0]
		let data = new FormData(form)

		$.ajax({
			type: 'POST',
			url: 'loader.php?clients',
			data : data,
			enctype: 'multipart/form-data',
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
		if(confirm('Edit etmek isteyirsinizmi>'))
		{
			$.ajax({
					type:'POST',
					url:'loader.php?clients',
					data: {edit_id:id},
					success: function(response){
						$('#result').html('')
						$('#result').html(response)
					}
				})
		}		
	})




	$(document).on('click','.add',function(event){
		event.preventDefault();

		let form = $('#insertForm')[0];
		let data = new FormData(form);

		$.ajax({
			type: 'POST',
			enctype:'multipart/form-data',
			url:'loader.php?clients',
			data:data,
			processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            beforeSend: function(){
								$('#result').html('<img style="width:50px; height:50px;" class="rounded mx-auto d-block" src="https://cutewallpaper.org/21/loading-gif-transparent-background/Bee-Hollow-Farm-beekeeping-classes-and-events-near-Schodack-.gif">')
            },
            success: function (response) {
								$('#result').html(response)
            },
		});

	});


	$(document).on('click','.sil',function(){
		let id = $(this).attr('id')

		if(confirm('Musterini silmek isteyirsiniz mi?'))
		{
			$.ajax({
				type: 'POST',
				url : 'loader.php?clients',
				data: {del_id:id},
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
			url: 'loader.php?clients',
			dataType: 'html',
			success: function(response){
				$('#result').html(response)
			}
		})
	})
</script>
