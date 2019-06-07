<?php

//fetch_data.php

include('database_connection.php');

if(isset($_POST["action"]))
{
	$query = "
		SELECT * FROM voice_bank_data WHERE voice_status = '1'
	";

	// if(isset($_POST["minimum_price"], $_POST["maximum_price"]) && !empty($_POST["minimum_price"]) && !empty($_POST["maximum_price"]))
	// {
	// 	$query .= "
	// 	 AND product_price BETWEEN '".$_POST["minimum_price"]."' AND '".$_POST["maximum_price"]."'
	// 	";
	// }

	// Gender
	if(isset($_POST["gender"]))
	{
		$gender_filter = implode("','", $_POST["gender"]);
		$query .= "
		 AND voice_gender IN('".$gender_filter."')
		";
	}

	// Genres
	if(isset($_POST["genres"]))
	{
		$genres_filter = implode("','", $_POST["genres"]);
		$query .= "
		 AND voice_genres IN('".$genres_filter."')
		";
	}

	// Voice Modulation
	if(isset($_POST["voice_modulation"]))
	{
		$voice_modulation_filter = implode("','", $_POST["voice_modulation"]);
		$query .= "
		 AND voice_voice_modulation IN('".$voice_modulation_filter."')
		";
	}


	// Languages
	if(isset($_POST["languages"]))
	{
		$languages_filter = implode("','", $_POST["languages"]);
		$query .= "
		 AND voice_languages IN('".$languages_filter."')
		";
	}

	// Jingle Moods
	if(isset($_POST["jingle_moods"]))
	{
		$jingle_moods_filter = implode("','", $_POST["jingle_moods"]);
		$query .= "
		 AND voice_jingle_moods IN('".$jingle_moods_filter."')
		";
	}

	// IVR
	if(isset($_POST["ivr"]))
	{
		$ivr_filter = implode("','", $_POST["ivr"]);
		$query .= "
		 AND voice_ivr IN('".$ivr_filter."')
		";
	}

	$statement = $connect->prepare($query);
	$statement->execute();
	$result = $statement->fetchAll();
	$total_row = $statement->rowCount();
	$output = '';
	if($total_row > 0)
	{
		foreach($result as $row)
		{
			$output .= '
			<div class="col-sm-3 col-lg-4 col-md-3">
				<div style="border:1px solid #ccc; border-radius:5px; padding:10px; margin-bottom:16px; height:300px;">
					<audio controls controlsList="nodownload" style="padding: 10px 10px 10px 10px;margin-left: -21px;">
						<source src="audio_sample/'. $row['voice_audio_file'] .'" alt="" class="img-responsive">
					</audio>
					<p align="center"><strong> '. $row['voice_name'] .'</strong></p>

					<p style="font-size: 12px;">
					Gender		      : '. $row['voice_gender'].' <br />
					Genres 			  : '. $row['voice_genres'].' <br />
					Voice Modulation  : '. $row['voice_voice_modulation'].' <br />
					Languages		  : '. $row['voice_languages'].' <br />
					Jingle Moods	  : '. $row['voice_jingle_moods'].' <br />
					Ivr 			  : '. $row['voice_ivr'].' <br /> </p>
					<button class="btn btn-primary" type="submit" style="padding: 5px 83px 5px 83px;"> Add to PlayList </button>
				</div>
				
			</div>
			';
		} 
	}
	else 
	{
		$output = '<h3>No Data Found</h3>';
	}
	echo $output;
}
?>