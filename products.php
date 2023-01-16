<?php
include'header.php';
echo'<div class="container">';




$sec=mysqli_query($con, "SELECT * FROM trade ".$axtar." ORDER BY id DESC ");

$say=mysqli_num_rows($sec);






//Secilmislerin silinmesi

if(isset($_POST['secsil']) && isset($_POST['secilmis']))
{
	for($i=0; $i<count($_POST['secilmis']); $i++)
	{
		$check=mysqli_query($con, "SELECT productid FROM orders WHERE productid='".$_POST['id']."' ");
			$a=mysqli_num_rows($check);
		if($a>0)
		{
			echo' <div class="text-center">
					<div class="alert alert-warning">
							<b>Məhsul sifariş edilib!</b><i class="bi bi-exclamation-triangle"></i>
					</div>
				</div>';
		}
		else
			{echo'<div class="alert alert-danger" role="alert">
								<form method="post">
								<b>Məhsulu silmək istəyirsiniz mi?</b><br>
								<input type="hidden" name="id" value="'.$_POST['id'].'">
								<button type="submit" name="yes" class="btn btn-danger btn-sm">Bəli</button>
								<button type="submit" name="no" class="btn btn-primary btn-sm">Xeyr</button>
								</form> </div>';}
	}
}	
if(isset($_POST['yes']))
{
	$sil=mysqli_query($con, "DELETE FROM trade WHERE id='".$_POST['secilmis'][$i]."' ");
	
	if($sil==true)
		{echo'<div class="text-center">
						<div class="alert alert-success" role="alert" style="font-size:18px"><i class="fas fa-cut"></i>
						<b>Silindi!</b>
					</div>
				</div>';}
}




if(isset($_POST['axtar']) && !empty($_POST['query']))
{
	$axtar=" AND (trade.name LIKE'%".$_POST['query']."%') ";

	$yoxlama=mysqli_query($con,"SELECT name FROM trade WHERE name='".$_POST['query']."' ");

	$limit=mysqli_num_rows($yoxlama);
	if($limit==0)
	{
		echo'Melumat tapilmadi';
	}

}


?>
<div id="result"><img style="width:50px; height:50px;" class="rounded mx-auto d-block" src="https://cutewallpaper.org/21/loading-gif-transparent-background/Bee-Hollow-Farm-beekeeping-classes-and-events-near-Schodack-.gif"></div>

<?php
{echo'</div>';}
 ?>
 

 <script>
 	$(document).on('click','.update',function(event){
 		event.preventDefault()

 		let form = $('#updateForm')[0]
 		let data = new FormData(form)

 		$.ajax({
 			type: 'POST',
 			url: 'loader.php?products',
 			data: data,
 			processData: false,
            contentType: false,
            cache: false,
            timeout: 600000,
            beforeSend: function(){
								$('#result').html('<img style="width:50px; height:50px;" class="rounded mx-auto d-block" src="https://cutewallpaper.org/21/loading-gif-transparent-background/Bee-Hollow-Farm-beekeeping-classes-and-events-near-Schodack-.gif">')
            },
            success: function (response){
								$('#result').html(response)
            }

 		})
 	})

 	$(document).on('click','.edit',function(){
 		let id = $(this).attr('id')

 		if(confirm('Edit etmek isteyirsinizmi?')){

 			$.ajax({
 				type: 'POST',
 				url: 'loader.php?products',
 				data: {edit_id:id},
 				success: function(response){
 					$('#result').html('')
 					$('#result').html(response)
 				}
 			})
 		}
 	})


 	$(document).on('click','.add',function(event) {
        event.preventDefault();
        let form = $('#insertForm')[0];
        let data = new FormData(form);
        

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "loader.php?products",
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
            },
        });
    });


 	$(document).on('click','.sil',function(){
 		let id = $(this).attr('id')

 		if(confirm('Mehsulu silmek isteyrisinizmi?')){
 			$.ajax({
 				type:'POST',
 				url:'loader.php?products',
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
			type:'GET',
			url: 'loader.php?products',
			dataType: 'html',
			success: function(response){

				$('#result').html(response)

			}
		})

	})
 </script>