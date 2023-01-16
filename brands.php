<?php
include'header.php';

echo '<div class="container">';
echo'<h2><div class="col-sm-9"><b>Brendlər</b></div></h2>';
$tarix=date('Y-m-d H:i:s');





//Secilmislerin silinmesi




?>

<div id="result"><img style="width:50px; height:50px;" class="rounded mx-auto d-block" src="https://cutewallpaper.org/21/loading-gif-transparent-background/Bee-Hollow-Farm-beekeeping-classes-and-events-near-Schodack-.gif"></div>


</div>

<?php

//table=cedveli elan etmek ucun. acildisa mutleq baglanmalidir.
//thead= basliq setridir,acildisa baglanmalidir.
//th basliqdir,acildisa baglanmaldir
//tr=setrdir,acildisa baglanmalidir
//td=sutundu, acildisa baglanamldir
//th ile td nin sayi eyni olmaldi.
//<tbody


?>


</div>
<!DOCTYPE html>
<html>

<head>
  <style>
    body{
      margin: 0;
      padding: 0;
      background:darkseagreen;
    }
  </style>
</head>
</html>


<script>

	$(document).on('click','.axtar',function(){

		let form = $('#axtarForm')[0]
		let data =new FormData(form)

		$.ajax({
			type:'POST',
			data: data,
			url: 'loader.php?brands',
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



	$(document).on('click','.update',function(event){
		event.preventDefault()

		let form = $('#updateForm')[0]
		let data = new FormData(form)

		$.ajax({
			type:'POST',
			enctype:'multipart/form-data',
			data: data,
			url:'loader.php?brands',
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
				type:'POST',
				url:'loader.php?brands',
				data:{edit_id:id},
				success: function(response){
					$('#result').html('')
					$('#result').html(response)
				}
			})
		}
	})


$(document).on('click','.daxilet',function(event) {
        event.preventDefault();
        let form = $('#insertForm')[0];
        let data = new FormData(form);
        

        $.ajax({
            type: "POST",
            enctype: 'multipart/form-data',
            url: "loader.php?brands",
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

		if(confirm('Melumati silmek isteyinizden eminsinizmi?')){

			$.ajax({
				
				type:'POST',
				url: 'loader.php?brands',
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
			url: 'loader.php?brands',
			dataType: 'html',
			success: function(response){

			$('#result').html(response)

			}

		})

	})


</script>

