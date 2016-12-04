<?php
	
   function crude_rest_post($remote_url,$fields){

   // fields being false has us doing a get
    

   $ch = curl_init();
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

if ($fields){
  curl_setopt($ch, CURLOPT_POST, true);
}

// curl_setopt($ch, CURLOPT_HEADER, true);  // H3EDAERS SH0W
curl_setopt($ch, CURLOPT_VERBOSE, true);
curl_setopt($ch, CURLOPT_URL, $remote_url);
// curl_setopt($ch, CURLOPT_HTTPHEADER,array('Content-Type: application/xml'));
curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0); 
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.8.1.6) Gecko/20070725 Firefox/2.0.0.6"); // set browser/user agent    
// curl_setopt($ch, CURLOPT_HEADERFUNCTION, 'read_header'); // get header

  if ($fields){
    $data = $fields;
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($data));
  }
  $result=curl_exec($ch);
$string_o_things = $result;
return $string_o_things;


/*
	
	// $userAgent = $_SERVER['HTTP_USER_AGENT'];



$fields_string = '';
//url-ify the data for the POST
foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }
rtrim($fields_string, '&');


    $ch = curl_init();
    $timeout = 5; // set to zero for no timeout
    // curl_setopt($ch, CURLOPT_POSTFIELDS ,POSTVARS);
    curl_setopt ($ch, CURLOPT_URL, $remote_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/x-www-form-urlencoded'));

	curl_setopt($ch,CURLOPT_POST, count($fields));
    curl_setopt($ch,CURLOPT_POSTFIELDS, $fields_string);


  //  curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	
	curl_setopt($ch, CURLOPT_HEADER, true); 
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
    $file_contents = curl_exec($ch);
    curl_close($ch);

	*/
	
	
   // echo $file_contents;
	

   }
   
?>