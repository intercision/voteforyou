<!DOCTYPE HTML>
<html>
<?php
function remove_rest_from_number($phone_number){
  return preg_replace("/[^0-9]/","",$phone_number);	
}

function check_bday($bday){
	
 $today = date('m-d');  //2004-
 
 $bday_no_year = substr($bday,5);
 

 // die($today. " ".$bday_no_year);
 
 if ($today == $bday_no_year) {
   return true;	
 }
 else {
   return false;
 }

}

function check_bday_copy($bday){
	
    global $birthday_today;

	if (check_bday($bday)){
		?>
		
		<img src="<?php echo base_url(); ?>images/cake.png" id="cake_image" alt="Happy Birthday!">
		<?php
		
		$GLOBALS['birthday_today'] = true;
		// $birthday_today = true;
		return true;
	}
	else {
		return false;
	}
	
}


global $birthday_today;
$birthday_today = false;


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

?>
<head>
<title><?php echo $state_name; ?>'s <?php echo $district_with_copy; ?> Congressional District - Look Up Your Congress People!</title>



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


#results_page_content h1 {

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


#results_page_content h2 {

 padding-bottom: 0em;	
 margin: 0;
 
}

#results_page_content p.subtitle {
  margin: 0;
  padding: 0;  
	
}

#results_page_content #fridge {
	max-width: 100px;
	
}

#cake_image {
  max-width: 60px;	
}






</style>
</head>
<body>


<div data-role="page" id="results_page">

	<div data-role="header" data-tap-toggle="false" id="our_header">
		<h1>Congress Lookup</h1>
	</div><!-- /header -->

	<div data-role="content" id="results_page_content">	

	
<?php

  // echo "<h3>".$message."</h3>";
  
  $i = 1;
  foreach ($senator_results as $row){
	  
	  if ($i == 1){
		  $sen1_first_name = $row['first_name'];
		  $sen1_last_name = $row['last_name'];
		  $sen1_party = $row['party'];
		  $sen1_phone = $row['phone'];  
		  $sen1_contact_form = $row['contact_form'];  
		  $sen1_birthday_date = $row['birthday_date'];  
	  }
	  else if ($i == 2){
          $sen2_first_name = $row['first_name'];
		  $sen2_last_name = $row['last_name'];
		  $sen2_party = $row['party'];
		  $sen2_phone = $row['phone'];  
		  $sen2_contact_form = $row['contact_form'];
          $sen2_birthday_date = $row['birthday_date'];  		  
	  }
	  
	  $i++;
	  

	 // echO "<hr>";
	  
  }
  
  foreach ($house_results as $row){
	      $rep_first_name = $row['first_name'];
		  $rep_last_name = $row['last_name'];
		  $rep_party = $row['party'];
		  $rep_phone = $row['phone'];  
		  $rep_contact_form = $row['contact_form'];  
		  $rep_birthday_date = $row['birthday_date'];  
   }
   
   
    // $sen1_birthday_date = '2016-11-30';
   
  ?>
  
  <h1>Senators</h1>
  <h2><?php  echo $sen1_first_name." ".$sen1_last_name; ?>  <?php check_bday_copy($sen1_birthday_date); ?></h2>
  <p class="subtitle"><?php  echo $sen1_party; ?></p>
  <p class="phone"><a href="tel:<?php echo remove_rest_from_number($sen1_phone); ?>"><?php echo $sen1_phone ?></a></p>
    
	
  <?php  if ($sen1_contact_form) {  
   ?>
  <p class="email"><a href="<?php echo $sen1_contact_form ?>" data-ajax="false" target="_blank">E-Mail</a></p>
  <?php
  }
  ?>
  
  <h2><?php  echo $sen2_first_name." ".$sen2_last_name; ?>  <?php check_bday_copy($sen2_birthday_date); ?></h2>
  <p class="subtitle"><?php  echo $sen2_party; ?></p>
  <p class="phone"><a href="tel:<?php echo remove_rest_from_number($sen2_phone); ?>"><?php echo $sen2_phone ?></a></p>
   
	
	  <?php  if ($sen2_contact_form) {  
   ?>
  <p class="email"><a href="<?php echo $sen2_contact_form ?>" data-ajax="false" target="_blank">E-Mail</a></p>
  <?php
	  }
  ?>
  
   <h1>Representative</h1>
   
  <h2><?php  echo $rep_first_name." ".$rep_last_name; ?>  <?php check_bday_copy($rep_birthday_date); ?></h2>
  <p class="subtitle"><?php  echo $rep_party; ?></p>
  <p class="phone"><a href="tel:<?php echo remove_rest_from_number($rep_phone); ?>"><?php echo $rep_phone ?></a></p>
 
  
    <?php  if ($rep_contact_form) {  
   ?>
  <p class="email"><a href="<?php echo $rep_contact_form ?>" data-ajax="false" target="_blank">E-Mail</a></p>
  <?php
    }
  ?>
  
  <br>
  <small>Tap the phone numbers to call</small>
  
  <br>
  <br>
  <?php
  if ($birthday_today){
  ?>
    <small>One of your legislators has a brithday today (as indicated by the cupcake)!</small>
  <?php
  }
  ?>
  
  <hr>
  
  <a href="<?php echo base_url(); ?>print-for-fridge/<?php echo $state_twoletter; ?>/<?php echo $district; ?>" data-ajax="false" target="_blank"><img src="<?php echo base_url(); ?>images/fridge.png" id="fridge" alt="refrigerator"></a><br>
  <b><a href="<?php echo base_url(); ?>print-for-fridge/<?php echo $state_twoletter; ?>/<?php echo $district; ?>" data-ajax="false" target="_blank">Print for your fridge</a></b>
  
</div><!-- /content -->

<div data-role="footer">
<a href="<?php echo base_url(); ?>" data-role="button" data-ajax="false" data-icon="home" id="home">Home - Look Up Your Congress People</a>	 

</div>
</div>
		
<!-- page end -->
</div>
	
</body>
</html>