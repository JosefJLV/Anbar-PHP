<?php
include'header.php';
 echo'<div class="container">';
$tarix=date('Y-m-d H:i:s');





if(isset($_POST['axtar']) && !empty($_POST['query']))
{
	$axtar="WHERE(teyinat LIKE'%".$_POST['query']."%')";
}
	

if(isset($_POST['secsil']) && isset($_POST['secilmis']))
{
	for($i=0;$i<count($_POST['secilmis']);$i++){
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
			$sil1=mysqli_query($con, "DELETE FROM expense WHERE id='".$_POST['secilmis'][$i]."' ");
				if($sil1==true)
					{echo'<div class="text-center">
						<div class="alert alert-info" role="alert" style="font-size:16px">
							<b>Seçilənlər silindi!</b>
						</div>
					</div> ';}
		}
		

?>
<div id="result"><img style="width:50px; height:50px;" class="rounded mx-auto d-block" src="https://cutewallpaper.org/21/loading-gif-transparent-background/Bee-Hollow-Farm-beekeeping-classes-and-events-near-Schodack-.gif"></div>

<?php
echo'</div>';
?>
<script>

	$(document).on('click','.filter',function(){

		$.ajax({
			type: 'GET',
			url: 'loader.php?xerc?f1',
			dataType: 'html',
			success: function(response){
				$('#result').html(response)

			}
		})
	})


	$(document).on('click','.update',function(event) {
        event.preventDefault();
        let form = $('#updateForm')[0];
        let data = new FormData(form);
        

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "loader.php?xerc",
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

    $(document).on('click','.edit',function() {

		let id = $(this).attr('id')

		if(confirm('Edit etmek isteyirsinizmi?')){

			$.ajax({
				type: 'POST',
				url:'loader.php?xerc',
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
            url: "loader.php?xerc",
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

	$(document).on('click','.sil',function() {

		let id = $(this).attr('id')

		if(confirm('Silmek isteyirsinizmi?')){

			$.ajax({
				type: 'POST',
				url:'loader.php?xerc',
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
			url: 'loader.php?xerc',
			dataType: 'html',
			success : function(response){
				$('#result').html(response)
			}
		})
	})
</script>
 