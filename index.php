<?php 

//index.php

include('database_connection.php');

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Voice Repository</title>

    <script src="js/jquery-1.10.2.min.js"></script>
    <script src="js/jquery-ui.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link href = "css/jquery-ui.css" rel = "stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
        	<br />
        	<h2 align="center">Voice Repository Bank</h2>
        	<br />
            <div class="col-md-3">

                <!-- Price -->
				<!-- <div class="list-group">
					<h3>Price</h3>
					<input type="hidden" id="hidden_minimum_price" value="0" />
                    <input type="hidden" id="hidden_maximum_price" value="65000" />
                    <p id="price_show">1000 - 65000</p>
                    <div id="price_range"></div>
                </div> -->

                <!-- Languages  -->
                <div class="list-group">
					<h3>Languages</h3>
					<?php
                    $query = "
                    SELECT DISTINCT(voice_languages) FROM voice_bank_data WHERE voice_status = '1' ORDER BY voice_languages DESC
                    ";
                    $statement = $connect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll();
                    foreach($result as $row)
                    {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector languages" value="<?php echo $row['voice_languages']; ?>"  > <?php echo $row['voice_languages']; ?> </label>
                    </div>
                    <?php
                    }
                    ?>	
                </div>

                <!-- Genres  -->
				<div class="list-group">
					<h3>Genres</h3>
                    <?php

                    $query = "
                    SELECT DISTINCT(voice_genres) FROM voice_bank_data WHERE voice_status = '1' ORDER BY voice_genres DESC
                    ";
                    $statement = $connect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll();
                    foreach($result as $row)
                    {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector genres" value="<?php echo $row['voice_genres']; ?>" > <?php echo $row['voice_genres']; ?> </label>
                    </div>
                    <?php    
                    }

                    ?>
                </div>
				
                <!-- Voice Modulation -->
				<div class="list-group">
					<h3>Voice Modulation</h3>
					<?php
                    $query = "
                    SELECT DISTINCT(voice_voice_modulation) FROM voice_bank_data WHERE voice_status = '1' ORDER BY voice_voice_modulation DESC
                    ";
                    $statement = $connect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll();
                    foreach($result as $row)
                    {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector voice_modulation" value="<?php echo $row['voice_voice_modulation']; ?>"  > <?php echo $row['voice_voice_modulation']; ?> </label>
                    </div>
                    <?php
                    }
                    ?>	
                </div> 
                <!-- Gender  -->

                <div class="list-group">
					<h3>Gender</h3>
                    <div style="height: 180px; overflow-y: auto; overflow-x: hidden;">
					<?php

                    $query = "SELECT DISTINCT(voice_gender) FROM voice_bank_data WHERE voice_status = '1' ORDER BY voice_id DESC";
                    $statement = $connect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll();
                    foreach($result as $row)
                    {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector gender" value="<?php echo $row['voice_gender']; ?>"  > <?php echo $row['voice_gender']; ?></label>
                    </div>
                    <?php
                    }

                    ?>
                    </div>
                </div>

                <!-- Jingle Moods -->
                <div class="list-group">
					<h3>Jingle Moods</h3>
					<?php
                    $query = "
                    SELECT DISTINCT(voice_jingle_moods) FROM voice_bank_data WHERE voice_status = '1' ORDER BY voice_jingle_moods DESC
                    ";
                    $statement = $connect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll();
                    foreach($result as $row)
                    {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector jingle_moods" value="<?php echo $row['voice_jingle_moods']; ?>"  > <?php echo $row['voice_jingle_moods']; ?> </label>
                    </div>
                    <?php
                    }
                    ?>	
                </div>

                <!-- IVR -->
                <div class="list-group">
					<h3>Ivr</h3>
					<?php
                    $query = "
                    SELECT DISTINCT(voice_ivr) FROM voice_bank_data WHERE voice_status = '1' ORDER BY voice_ivr DESC
                    ";
                    $statement = $connect->prepare($query);
                    $statement->execute();
                    $result = $statement->fetchAll();
                    foreach($result as $row)
                    {
                    ?>
                    <div class="list-group-item checkbox">
                        <label><input type="checkbox" class="common_selector ivr" value="<?php echo $row['voice_ivr']; ?>"  > <?php echo $row['voice_ivr']; ?> </label>
                    </div>
                    <?php
                    }
                    ?>	
                </div>
            </div>

            <div class="col-md-9">
            	<!-- <br /> -->
        
		        <div class="col-md-12 text-center">	
					<div class="row filter_data">

					</div>
				</div>
			</div>
        </div>
    </div>
<style>
#loading
{
	text-align:center; 
	background: url('loader.gif') no-repeat center; 
	height: 150px;
}
</style>

<script>
$(document).ready(function(){

    filter_data();

    function filter_data()
    {
        $('.filter_data').html('<div id="loading" style="" ></div>');
        var action = 'fetch_data';

        // var minimum_price = $('#hidden_minimum_price').val();
        // var maximum_price = $('#hidden_maximum_price').val();

        var gender = get_filter('gender');
        var genres = get_filter('genres');
        var voice_modulation = get_filter('voice_modulation');
        var languages = get_filter('languages');
        var jingle_moods = get_filter('jingle_moods');
        var ivr = get_filter('ivr');
        $.ajax({
            url:"fetch_data.php",
            method:"POST",
            data:
            {
                action:action, 
                // minimum_price:minimum_price, 
                // maximum_price:maximum_price,
                gender:gender,
                genres:genres, 
                voice_modulation:voice_modulation,
                languages:languages,
                jingle_moods:jingle_moods,
                ivr:ivr
            },
                success:function(data)
                {
                $('.filter_data').html(data);
                }
        });
    }

    function get_filter(class_name)
    {
        var filter = [];
        $('.'+class_name+':checked').each(function(){
            filter.push($(this).val());
        });
        return filter;
    }

    $('.common_selector').click(function(){
        filter_data();
    });

    // $('#price_range').slider({
    //     range:true,
    //     min:1000,
    //     max:65000,
    //     values:[1000, 65000],
    //     step:500,
    //     stop:function(event, ui)
    //     {
    //         $('#price_show').html(ui.values[0] + ' - ' + ui.values[1]);
    //         $('#hidden_minimum_price').val(ui.values[0]);
    //         $('#hidden_maximum_price').val(ui.values[1]);
    //         filter_data();
    //     }
    // });

});
</script>
</body>
</html>