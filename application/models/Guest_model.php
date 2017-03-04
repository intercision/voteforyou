<?php
// now in UTF-8

class Guest_model extends CI_Model {


   
   
   
   
	 function sor_crude_rest_geocode_address_lookup($address){  
	 
	   // need to LOG these
	   // counts as 2  geocode + get congressional district
	 
	   $url = 'https://api.geocod.io/v1/geocode?fields=cd&api_key='.GEOCODIO_API_KEY;
	 
	 
	   $address = urlencode($address);

	 /*
	 
	    // for Anonymous users:
	 		'APIUsername' => 'HotelsEtcMembershipClub',
			'APIPassword' => 's3jfhs8733ffh',
			
	 */
	 
	 // key=TEST or IP  while we wait for an API key
	   $params = array(
		  	'q' => $address
       );
				
				
				/*
	$params = array(
						'email' => urlencode('test@test.com'),
						'first_name' => urlencode('test'),
						'last_name' => urlencode('jones')
				);
          */
		

		 // counting our API accesses
		 $todays_accesses = $this -> get_todays_api_accesses();
		 
		 if ($todays_accesses > API_ACCESS_DAILY_LIMIT){
			  return 'past_limit';
		  }
		  
		  
		  
		  
		$this->load->helper('crude_rest_post');
		
		// echo "<before token><br>";
		
		
		// get token crude-ly
		 $json_results = crude_rest_post($url,$params);
		

		if ($json_results){
			
		  $this -> increment_api_accesses(2,$todays_accesses);
		  

		  return $json_results;
		}
		else {
		  return false;
		}

	 
	 }
	 

	 
	 
   
	 function sor_crude_rest_reverse_geocode_lookup($lat,$lng){  
	 
	   // counts as 2
	 
	   $url = 'https://api.geocod.io/v1/reverse?fields=cd&api_key='.GEOCODIO_API_KEY;
	 
	 
	  $lat_lng = $lat.', '.$lng;

	   // doesn't need URL encoding?
	   
	 /*
	 
	    // for Anonymous users:
	 		'APIUsername' => 'HotelsEtcMembershipClub',
			'APIPassword' => 's3jfhs8733ffh',
			
	 */
	 
	 // key=TEST or IP  while we wait for an API key
	   $params = array(
		  	'q' => $lat_lng
       );
				
				
				/*
	$params = array(
						'email' => urlencode('test@test.com'),
						'first_name' => urlencode('test'),
						'last_name' => urlencode('jones')
				);
          */
		
		 
		 // DUPLICATE CODE
		 // counting our API accesses
		 $todays_accesses = $this -> get_todays_api_accesses();
		 
		 if ($todays_accesses > API_ACCESS_DAILY_LIMIT){
			  return 'past_limit';
		  }
		  
		  
		  
		$this->load->helper('crude_rest_post');
		
		// echo "<before token><br>";
		
		
		// get token crude-ly
		 $json_results = crude_rest_post($url,$params);
		

		if ($json_results){
			
		  $todays_accesses = $this -> increment_api_accesses(2,$todays_accesses);
		  

		  
		  
		  return $json_results;
		}
		else {
		  return false;
		}

	 
	 }
	 
	 
	 
	 
	 
   
	 function recapcha_test($g_recaptcha_response){  
	 
	   // Google service
	 
	   $url = 'https://www.google.com/recaptcha/api/siteverify';
	
	
	   $ip = $this-> get_ip();
	
	 // key=TEST or IP  while we wait for an API key
	   $params = array(
		  	'secret' => '6LddVg0UAAAAAPsWh2T8oFMA7hc6RVKz6DhHu337',
			'response' => $g_recaptcha_response,
			'remoteip' => $ip
       );
				
				
		$this->load->helper('crude_rest_post');
		
		// echo "<before token><br>";
		
		
		// get token crude-ly
		 $json_results = crude_rest_post($url,$params);
		

		if ($json_results){
			
		  
		  return $json_results;
		}
		else {
		  return false;
		}

	 
	 }
	 
	 
	 
	 
	 
    function get_todays_api_accesses(){
	
	   $today = date('Y-m-d');
		
       $this->db->where (Array('access_date' => $today) );
	   $q = $this->db->get('vforyou_api_accesses_by_day');
	   
	   if ( $q->num_rows() > 0 ) {

	     $result = $q->result_array();
	     foreach ($result as $row){
		    return $row['amount'];   
	     }
	
	   }
	   else {
		 return 0;   
	   }

	}
	
	function increment_api_accesses($api_hits_this_access = 2,$todays_accesses_from_var){  // geocode + look up congressional district
		
		
		    $today = date('Y-m-d');
			
			if ($todays_accesses_from_var == 0){
		        $access_amount = $this -> get_todays_api_accesses();
		    }
			else {
				 $access_amount = $todays_accesses_from_var;
			}
			
		    // increment update
			$access_amount_updated = $access_amount + $api_hits_this_access;
			
		    if ($access_amount == 0){
				
			 $db_insert = array(
			    'access_date' => $today,
                'amount' => $access_amount_updated		
              );
			  
			 $this->db->where('access_date', $today);
             $this->db->insert('vforyou_api_accesses_by_day', $db_insert); 
				
			}
			else {
		
		    
			  $db_update = array(
                 'amount' => $access_amount_updated		   
              );
			  
			  $this->db->where('access_date', $today);
              $this->db->update('vforyou_api_accesses_by_day', $db_update); 
			 
			}
			
			
			 return $access_amount_updated;
			 
		
		
	}
	
	
	
	
	 
    function get_senators_for_state ($state_twoletter){

       $this->db->where (Array('state' => $state_twoletter, 'type' => 'sen') );
	   $this->db->order_by("last_name", "asc"); 
	   $q = $this->db->get('govtrack_congress_member');
	   return $q->result_array();
	
	}
	
    function get_rep_for_state ($state_twoletter,$district_in_state){

       $this->db->where (Array('state' => $state_twoletter, 'district' => $district_in_state, 'type' => 'rep') );
	   $this->db->order_by("last_name", "asc"); 
	   $q = $this->db->get('govtrack_congress_member');
	   return $q->result_array();
	
	}
	
	
	
	
    function get_officials_bday ($date){

	
	$qtxt = "SELECT * FROM govtrack_congress_member WHERE MONTH(birthday_date) = MONTH(NOW()) AND DAY(birthday_date) = DAY(NOW());";
	
	// $qtxt = "SELECT * FROM govtrack_congress_member WHERE MONTH(birthday_date) = 6 AND DAY(birthday_date) = 14;";
	

	
	
       $q = $this->db->query($qtxt);
	   return $q->result_array();
	
	}
	
	
	
	
	function generate_pdf($state_twoletter='MI',$district=1){
		
		$x_offset = 0; $y_offset = 0;
		
		$senator_results = $this -> get_senators_for_state($state_twoletter);
		$house_results = $this -> get_rep_for_state($state_twoletter,$district);
		
		
		
		$this->load->library('pdf');

   	    $pdf = new PDF();

		$pdf->SetAutoPageBreak(false);
		
		$pdf->SetTitle('Congress People '.$state_twoletter.' '.$district);
		
		$pdf->AddPage('P','Letter');
		
		$this -> quarter_pdf($pdf,$x_offset,10,$senator_results,$house_results);  // top left
		$this -> quarter_pdf($pdf,110,10,$senator_results,$house_results);        // top right
		$this -> quarter_pdf($pdf,$x_offset,143,$senator_results,$house_results);  // bottom left
		$this -> quarter_pdf($pdf,110,143,$senator_results,$house_results);        // bottom right
		
	
        $pdf->Output();		
		
		
	}
	
	private function quarter_pdf($pdf,$x_offset = 0,$y_offset = 0,$senator_results,$house_results){
		
		$left_margin = 19;
		// start from fresh coords
		
		$pdf->SetY(0 + $y_offset);  // set Y  must preceed Set X
		$pdf->SetX($x_offset + $left_margin);
		
		$pdf->SetFont('Arial','U',14);
        $pdf->Cell(40,30,'Your Senators');

		
		
		
  $i = 1;
  foreach ($senator_results as $row){
	  
	  if ($i == 1){
		  $sen1_first_name = $row['first_name'];
		  $sen1_last_name = $row['last_name'];
		  $sen1_party = $row['party'];
		  $sen1_phone = $this -> format_phone_number($row['phone']);  
	  }
	  else if ($i == 2){
          $sen2_first_name = $row['first_name'];
		  $sen2_last_name = $row['last_name'];
		  $sen2_party = $row['party'];
		  $sen2_phone = $this -> format_phone_number($row['phone']);  
	  }
	  
	  $i++;
	  

  }
  
		 
		 
		 $pdf->SetY(11 + $y_offset); // y actually em's or something
		 // $pdf->SetX(40 + $x_offset);
		 $pdf->SetX($x_offset + $left_margin);

		 $pdf->SetFont('Arial','',25);
		 $pdf->Cell(50,30,$sen1_first_name." " .$sen1_last_name);

	     // $pdf->SetX(40 + $x_offset);
		 $pdf->SetY(17 + $y_offset); 
		 $pdf->SetX($x_offset + $left_margin);
		
		 $pdf->SetFont('Times','',14);
		 $pdf->Cell(40,30,$sen1_party);

	     // $pdf->SetX(40 + $x_offset);
		 $pdf->SetY(24.5 + $y_offset); 
		 $pdf->SetX($x_offset + $left_margin);
		 
	     $pdf->SetFont('Arial','',21);
		 $pdf->Cell(40,30,$sen1_phone);

		 
		 
		 $next_item_bump = 28;
		 
         $pdf->SetY(11 + $y_offset + $next_item_bump); // y actually em's or something
		 // $pdf->SetX(40 + $x_offset);
		 $pdf->SetX($x_offset + $left_margin);
		 
	     $pdf->SetFont('Arial','',25);
		 $pdf->Cell(50,30,$sen2_first_name." " .$sen2_last_name);

	     // $pdf->SetX(40 + $x_offset);
		 $pdf->SetY(17 + $y_offset + $next_item_bump); 
		 $pdf->SetX($x_offset + $left_margin);
		
		 $pdf->SetFont('Times','',14);
		 $pdf->Cell(40,30,$sen2_party);

	     // $pdf->SetX(40 + $x_offset);
		 $pdf->SetY(24.5 + $y_offset + $next_item_bump); 
		 $pdf->SetX($x_offset + $left_margin);
		 
	     $pdf->SetFont('Arial','',21);
		 $pdf->Cell(40,30,$sen2_phone);

		 
		$rep_bump = $next_item_bump + 40;
		 
		 
		$pdf->SetY(0 + $rep_bump + $y_offset);  // set Y  must preceed Set X
		$pdf->SetX($x_offset + $left_margin);
		
		$pdf->SetFont('Arial','U',14);
        $pdf->Cell(40,30,'Your Representative');

		
		
         foreach ($house_results as $row){
	      $rep_first_name = $row['first_name'];
		  $rep_last_name = $row['last_name'];
		  $rep_party = $row['party'];
		  $rep_phone = $this -> format_phone_number($row['phone']);
        }
   
   
		
		 
         $pdf->SetY(11 + $y_offset + $rep_bump); // y actually em's or something
		 // $pdf->SetX(40 + $x_offset);
		 $pdf->SetX($x_offset + $left_margin);
		 
	     $pdf->SetFont('Arial','',25);
		 $pdf->Cell(50,30,$rep_first_name." ".$rep_last_name);

	     // $pdf->SetX(40 + $x_offset);
		 $pdf->SetY(17 + $y_offset + $rep_bump); 
		 $pdf->SetX($x_offset + $left_margin);
		
		 $pdf->SetFont('Times','',14);
		 $pdf->Cell(40,30,$rep_party);

	     // $pdf->SetX(40 + $x_offset);
		 $pdf->SetY(24.5 + $y_offset + $rep_bump); 
		 $pdf->SetX($x_offset + $left_margin);
		 
	     $pdf->SetFont('Arial','',21);
		 $pdf->Cell(40,30,$rep_phone);

		 
		 $pdf->SetY(28.5 + $y_offset + $rep_bump); 
		 $pdf->SetX($x_offset + $left_margin + 10);
		 
		 $pdf->SetFont('Arial','',12);
		 $pdf->Cell(70,40,'voteforyou.co');
		 
		 // if you wanted to do an image cobrand you could add an image here instead of text
		 // (look up the FPDF documentation for more info)
		 // $pdf->Image('images/your_cobrand.jpg',NULL,NULL,50,2);
		 
		 
		 
	}
	
	
	function format_phone_number($number){
		
		// strip it of - 's 
		$number = preg_replace("/[^0-9]/","",$number);	

		$formatted_number = preg_replace("/^(\d{3})(\d{3})(\d{4})$/", "($1) $2-$3", $number);
		
		return $formatted_number;
		
		
	}
	
	
	 
	
	
      private function get_ip() 
                  {
                      if (isset($_SERVER) and !empty($_SERVER)) {
                          if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                              $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
                          } else if (isset($_SERVER['HTTP_CLIENT_IP'])) {
                              $ip = $_SERVER['HTTP_CLIENT_IP'];
                          } else {
                              $ip = $_SERVER['REMOTE_ADDR'];
                          }                    
                      } else {
                          if (getenv('HTTP_X_FORWARDED_FOR')) {
                              $ip = getenv('HTTP_X_FORWARDED_FOR');
                          } else if (getenv('HTTP_CLIENT_IP')) {
                              $ip = getenv('HTTP_CLIENT_IP');
                          } else {
                              $ip = getenv('REMOTE_ADDR');
                          }
                      }
                
                      return $ip;
                  }
				  
	
   
 
}


?>