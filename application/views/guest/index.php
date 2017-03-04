<!DOCTYPE HTML>
<html>
<?php
function remove_rest_from_number($phone_number){
  return preg_replace("/[^0-9]/","",$phone_number);	
}
?>

<head>
<title>Congressional Birthdays</title>



<meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=yes" />

<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery.mobile-1.4.5.min.css" />
<script src="<?php echo base_url(); ?>js/jquery-1.11.1.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.mobile-1.4.5.min.js"></script>



<script>


	$( document ).on( "pageinit", "#results_page", function( event ) {
		// document.ready
		
		$('#getloc').click(function(){
         
		 // alert('loc');
		 getLoc();
		 
		 
       })
		
		
		// title page title for displayed title
		$(":jqmData(role='page')").attr("data-title", document.title);
		
	});
	
	
	
	
	

</script>
<style type="text/css">

#error {
  color: red;
}

#holder {
 margin-left: 3%;
 font-family: arial,helvetica,sans-serif;

}

.itcm_textarea {
  width: 90%;
  max-width: 500px;
}


#search_page_content {
 max-width: 800px;	
}

#loc_text_holder {
  text-align: left !important;	
}

#loc_text_copy {
  margin-top: 18px;	
  font-size: 1.3em;
}


#dc_page_content h1 {

 padding-bottom: 0em;	
 margin-bottom: 0;
 font-size: 1.5em;
 letter-spacing: .2em;
 padding-bottom: 3px;
 border-bottom: 1px solid #aaa;
 font-weight: normal;
 font-family: "Times New Roman",times,serif;
 text-transform: uppercase;
}


#dc_page_content h2 {

 padding-bottom: 0em;	
 margin: 0;
 
}

#dc_page_content p.subtitle {
  margin: 0;
  padding: 0;  
	
}

#dc_page_content #fridge {
	max-width: 100px;
	
}

#cake_image {
  max-width: 60px;	
}


.bday_holder {
 float: left;
 margin-right: 4%; 
	
}





</style>
</head>
<body>


<div data-role="page" id="results_page">

	<div data-role="header" data-tap-toggle="false" id="our_header">
		<h1>Congressional Birthdays</h1>
	</div><!-- /header -->

	<div data-role="content" id="dc_page_content">	

	
	<h1>Congressional Birthdays Today</h1>
	<br>
	
	<?php
	 foreach ($people_with_birthdays as $row){
		 
		?>
		<div class="bday_holder">
		
		<?php
	  $bioguide_id = $row['bioguide_id'];
	  $type = $row['type'];
	  $district = $row['district'];
	  $state = get_state_name_view($row['state']);
	  
	  if ($type == 'rep'){
		  $type_copy = "Representative";
	  }
	  else if ($type == 'sen') {
		  $type_copy = "Senator";
	  }
	  
	  
if ($district == 1){
	$district_with_copy = '1st';
}
else if ($district == 2) {
	$district_with_copy = '2nd';
}
else if ($district == 3) {
	$district_with_copy = '3rd';
}
else {
	$district_with_copy = $district.'th';
}



	  
	  $first_letter = substr($bioguide_id, 0,1);
 
      $image_url = 'http://bioguide.congress.gov/bioguide/photo/'.$first_letter.'/'.$bioguide_id.'.jpg';
	  
	  
	  echo "<img src=".$image_url." onerror=\"this.onerror=null;this.src='".base_url()."images/no_image.jpg';\">";
	  echo "<br>";
	  echo "<p class=\"subtitle\"><b>".$row['first_name']." ".$row['last_name']."</b> - ".$row['party']."</p>";
	  
	  
	  if ($type == 'rep'){
	    echo "<p class=\"subtitle\">".$type_copy." of the ".$district_with_copy." district of ".$state."</p>";
	  }
	  else {
	    echo "<p class=\"subtitle\">".$type_copy." of ".$state."</p>";
	  }
	  
	  
	  echo "<br>";
	?>
	
	
	</div>
	
	<?php
	
	 }
	 
	?>
	
	<!--
	 
	 <h1>Representative</h1>
  <h2>Eleanor Norton</h2>
  <p class="subtitle">Democrat</p>
  <p class="phone"><a href="tel:2022258050">(202) 225-8050</a></p>
    
	-->
	
	 
	 <!--
	 You have no represantation but you can pay the people representing everyone else a visit as much as you would like.
	 -->
	 
	 <br style="clear: both;">
	 
	 <br>
<a href="<?php echo base_url(); ?>look_up" data-role="button" data-ajax="false" data-icon="home" id="home">Look Up Your Congress People</a>	


</div><!-- /content -->

<div data-role="footer">
<a href="<?php echo base_url(); ?>" data-role="button" data-ajax="false" data-icon="home" id="home">Home</a>	 

</div>
</div>
		
<!-- page end -->
</div>
	
</body>
</html>
<?php

// not good form
	function get_state_name_view($state_twoletter){
		
		$state_twoletter = strtoupper($state_twoletter);
		
	$states = Array (
'AL' => 'Alabama',
'AK' => 'Alaska',
'AZ' => 'Arizona',
'AR' => 'Arkansas',
'CA' => 'California',
'CO' => 'Colorado',
'CT' => 'Connecticut',
'DE' => 'Delaware',
'FL' => 'Florida',
'GA' => 'Georgia',
'HI' => 'Hawaii',
'ID' => 'Idaho',
'IL' => 'Illinois',
'IN' => 'Indiana',
'IA' => 'Iowa',
'KS' => 'Kansas',
'KY' => 'Kentucky',
'LA' => 'Louisiana',
'ME' => 'Maine',
'MD' => 'Maryland',
'MA' => 'Massachusetts',
'MI' => 'Michigan',
'MN' => 'Minnesota',
'MS' => 'Mississippi',
'MO' => 'Missouri',
'MT' => 'Montana',
'NE' => 'Nebraska',
'NV' => 'Nevada',
'NH' => 'New Hampshire',
'NJ' => 'New Jersey',
'NM' => 'New Mexico',
'NY' => 'New York',
'NC' => 'North Carolina',
'ND' => 'North Dakota',
'OH' => 'Ohio',
'OK' => 'Oklahoma',
'OR' => 'Oregon',
'PA' => 'Pennsylvania',
'RI' => 'Rhode Island',
'SC' => 'South Carolina',
'SD' => 'South Dakota',
'TN' => 'Tennessee',
'TX' => 'Texas',
'UT' => 'Utah',
'VT' => 'Vermont',
'VA' => 'Virginia',
'WA' => 'Washington',
'WV' => 'West Virginia',
'WI' => 'Wisconsin',
'WY' => 'Wyoming',
'DC' => 'District of Columbia',
'AS' => 'American Samoa',
'GU' => 'Guam',
'MP' => 'Northern Mariana Islands',
'PR' => 'Puerto Rico',
'UM' => 'United States Minor Outlying Islands',
'VI' => 'Virgin Islands, U.S.');

	
	if (array_key_exists ( $state_twoletter , $states)){
		
		return $states[$state_twoletter];
		
	}
	else {
	  return false;	
		
	}
	
		
	}
	
?>