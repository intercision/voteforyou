<!DOCTYPE HTML>
<html>
<?php
function remove_rest_from_number($phone_number){
  return preg_replace("/[^0-9]/","",$phone_number);	
}
?>

<head>
<title>Washington D.C. - Look Up Your Congress People!</title>



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






</style>
</head>
<body>


<div data-role="page" id="results_page">

	<div data-role="header" data-tap-toggle="false" id="our_header">
		<h1>Congress Lookup</h1>
	</div><!-- /header -->

	<div data-role="content" id="dc_page_content">	

	
	 
	 <h1>Representative</h1>
  <h2>Eleanor Norton</h2>
  <p class="subtitle">Democrat</p>
  <p class="phone"><a href="tel:2022258050">(202) 225-8050</a></p>
    
	
	
	 
	 <!--
	 You have no represantation but you can pay the people representing everyone else a visit as much as you would like.
	 -->
	 
</div><!-- /content -->

<div data-role="footer">
<a href="<?php echo base_url(); ?>" data-role="button" data-ajax="false" data-icon="home" id="home">Home - Look Up Your Congress People</a>	 

</div>
</div>
		
<!-- page end -->
</div>
	
</body>
</html>