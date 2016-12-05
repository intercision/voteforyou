<!DOCTYPE HTML>
<html>
<?php
function remove_rest_from_number($phone_number){
  return preg_replace("/[^0-9]/","",$phone_number);	
}
?>
<head>
<title>Look Up Your Congress People!</title>


<?php
  echo $recap_script;
?>

<meta name="viewport" content="width=device-width, initial-scale=1.0 user-scalable=yes" />

<!--

<link rel="stylesheet" href="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.css" />
<script src="http://code.jquery.com/jquery-1.11.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.4.5/jquery.mobile-1.4.5.min.js"></script>
-->


<link rel="stylesheet" href="<?php echo base_url(); ?>js/jquery.mobile-1.4.5.min.css" />
<script src="<?php echo base_url(); ?>js/jquery-1.11.1.min.js"></script>
<script src="<?php echo base_url(); ?>js/jquery.mobile-1.4.5.min.js"></script>


<script>


	$( document ).on( "pageinit", "#search_page", function( event ) {
		// document.ready
		
		$('#getloc').click(function(){
         
		 // alert('loc');
		 getLoc();
		 
		 

		 
       });
	   
	   
	   $('#getpostal').click(function(){
         
		$('#postal_address').show('medium');
		 
		 
       });
	   
	   
	   // error form post save location
	if (document.getElementById("lat").value != ''){
       $('#getloc').css('background','#dfd');
       $('#getloc').html('&nbsp;&nbsp;&nbsp;&nbsp;Location Found&nbsp;&nbsp;&nbsp;&nbsp;');
       $('#getpostal').css('color','#aaa');
	}
   
		// error form post save location
	if (document.getElementById("postal_address_field").value != ''){
       $('#postal_address').show('fast');
	}
   
   // title for <title>
   $(":jqmData(role='page')").attr("data-title", document.title);
		
		
	});
	
	
	
	
	
	
function getLoc(){
	
	$('#getloc').html('&nbsp;&nbsp;&nbsp;&nbsp;Getting Location...&nbsp;&nbsp;&nbsp;&nbsp;');

	
if (navigator.geolocation) {
  var timeoutVal = 10 * 1000 * 1000;
  navigator.geolocation.getCurrentPosition(
    submitPosition, 
    displayError,
    { enableHighAccuracy: true, timeout: timeoutVal, maximumAge: 0 }
  );
}
else {
  // alert("Geolocation is not supported by this browser");
}

}



function submitPosition(position) {
	
  // must LIGHT UP button green
  
  
  // alert("Latitude: " + position.coords.latitude + ", Longitude: " + position.coords.longitude);
  
  lat = position.coords.latitude.toFixed(8);
  lng = position.coords.longitude.toFixed(8);
  
  
  document.getElementById("lat").value=lat;
  document.getElementById("lng").value=lng;
 
  /*
  $("#lat").val = lat;
  $("#lng").val = lng;
   */
  

  // turn button green  
  
   $('#getloc').css('background','#dfd');

    $('#getloc').html('&nbsp;&nbsp;&nbsp;&nbsp;Location Found&nbsp;&nbsp;&nbsp;&nbsp;');

   $('#getpostal').css('color','#aaa');
  
  
}


function displayError(error) {
  var errors = { 
    1: 'Permission denied',
    2: 'Position unavailable',
    3: 'Request timeout'
  };
  console.log("Error: " + errors[error.code]);
  
  $('#getloc').css('background','#fdd');
  	$('#getloc').html('Error Getting Location');

	
}


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

#postal_address {
  display: none;	
}


.top_button {
	
  margin-bottom: .6em !important;
  
}




</style>
</head>
<body>



<div data-role="page" id="search_page">

	<div data-role="header" data-tap-toggle="false" id="our_header">
		<h3>Congress Lookup</h3>
		  
		  
		  <!--
 <div class="ui-grid-a">
      <div class="ui-block-a">
            <fieldset data-role="controlgroup" data-type="horizontal" class="top-group">
                <a href="#" data-role="button" data-icon="arrow-l" id="previous" class="nudge_down_buttons">Prev</a>
	            <a href="#" data-role="button" data-icon="arrow-r" id="next" class="nudge_down_buttons">Next</a>	   
		     </fieldset>
      </div>
      <div class="ui-block-b">
	         <div id="speed_view_holder">
               <label>
                <input type = "checkbox" name="speed_view" id="speed_view">Speed View
               </label>
		     </div>
      </div>
    </div>
	
	  -->

	
	
		
	</div><!-- /header -->

	<div data-role="content" id="search_page_content">	


<?php
 if (validation_errors()){
?>
<div id="error">
  <span id="complaint_form"><?php echo validation_errors(); ?></span>
</div>
<?php
 }
?>

  <?php echo form_open(base_url().'look_up','data-ajax="false"'); ?>

<!--



<input type="button" value="Use Current Location" onClick="getLoc()">
-->

   <fieldset data-role="controlgroup" data-type="vertical" class="top-group"> 

		     
<a href="#" data-role="button" data-icon="location" id="getloc" class="top_button">Use Current Location</a>   
<a href="#" data-role="button" data-icon="mail" id="getpostal" class="top_button">Enter Postal Address</a> 
</fieldset>
			 
<!--
<div class="ui-grid-a">
      <div class="ui-block-a">
         
      </div>
      <div class="ui-block-b" id="loc_text_holder">
	       <div id="loc_text_copy"> </div>
      </div>
    </div>
	-->
	
<input type="hidden" name="lat" size=12 id="lat" value="<?php echo set_value('lat',$this->input->post('lat') ); ?>"> 
<input type="hidden" name="lng" size=12 id="lng" value="<?php echo set_value('lng',$this->input->post('lng') ); ?>">


<div id="postal_address">
Enter Postal Address:  <input type="text" id="postal_address_field" name="address" size=39 value="<?php echo set_value('address', $this->input->post('address')); ?>">
<br>
</div>


<?php
  echo $recap_widget;
?>


<!--
Capcha: <input type="text" name="security_code" size=5 value="<?php echo set_value('cap'); ?>"> Type the code <b>YES</b> in the box<br>
-->


<br>

<input type="Submit" value="Look Them Up!" data-theme="b" id="look_them_up_button">
  
  </form>
  <br>
  Remember your legislators are determined by your residency so the closer you are to home the more accurate this will be.
<br><br>
<a href="https://github.com/intercision/voteforyou" data-ajax="false">Get The Source Code</a>
  
  
</div><!-- /content -->

<div data-role="footer">
<a href="<?php echo FEEDBACK_LINK; ?>" data-ajax="false">Feedback</a>

</div>
</div>
		
<!-- page end -->
</div>
	
<script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-88348216-1', 'auto');
  ga('send', 'pageview');

</script>
</body>
</html>