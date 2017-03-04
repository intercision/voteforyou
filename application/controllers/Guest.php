<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// govtrack data going away summer '17

class Guest extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 
	 

		  
		  
		  
	public function index()
	{
		 
		 
		  // use location from GPS? 
		  
		  $data['message'] = '';
		 
		
	      $this->load->model('guest_model');
	
	      $month_day = date('m-d');
		  
		  
	      $data['people_with_birthdays'] = $this-> guest_model -> get_officials_bday($month_day);

		  

		  $this->load->view('guest/index',$data);
		
 
	}
	
	
	
	
	
	public function look_up()
	{
		
		  // use location from GPS? 
		
		  
		  $this->load->library('form_validation');
          $this->load->helper('security');

		  $data['message'] = '';
		 
		
	      $this->load->model('guest_model');
	
	
	      $data['page_title'] = 'Enter an Address';
		  $data['message'] = '';
		  
		$this->load->library('Recaptcha');
		
		
		$data['recap_widget'] = $this->recaptcha->getWidget();
		$data['recap_script'] = $this->recaptcha->getScriptTag();

		
		$this->form_validation->set_rules('address', 'Postal Address', 'min_length[1]');
        $this->form_validation->set_rules('lat', 'Latitude', 'numeric');
        $this->form_validation->set_rules('lng', 'Longitude', 'numeric');

		// MUST ENABLE ON PRODUCTION
		
		if (SITE_LOCATION == 'remote'){
		 $this->form_validation->set_rules('g-recaptcha-response', 'I\'m not a robot checkbox', 'required|callback_recap_check'); 
        }
	   
	   
	   // echo $this->input->post('g-recaptcha-response');
	   
	    if ($this->form_validation->run() == FALSE)
        {
		    
            $this->load->view('guest/look_up',$data);
		}
		else {
			
			
			  
			  $data['message'] = 'Congressional officials found';

			  
			  $found_data = false;
			  
			  if ($this->input->post('address', TRUE) != ''){
			    // doing 2 requests, geocode and congressional district     extra 'address',TRUE for XSS Clean
			    $json_results = $this -> guest_model -> sor_crude_rest_geocode_address_lookup( $this->input->post('address',TRUE) );
				$found_data = true;
				
			  }
			  else if ( $this->lat_lon_check($this->input->post('lat',TRUE)) && $this->lat_lon_check($this->input->post('lng',TRUE)) ){
				  // reverse lookup
				  $json_results = $this -> guest_model -> sor_crude_rest_reverse_geocode_lookup( $this->input->post('lat',TRUE),$this->input->post('lng',TRUE) );
				  // var_dump( $json_results );
				  $found_data = true;
				  
			  }
			  else {
				  
				// echo "You need to provide some input"; 
				
			  }
			  
			  
			  
			  
			  
			  
			  // need to get results => address_components => State and congressional_district => name
		      
			  
			  
			  
			  if ($found_data){
				  
			  
			  $json =  json_decode($json_results,true);  // get as array
			  
			  
			  // var_dump(($json['results']['q']['response']['results']));
			  
			if (!empty($json['results']['q']['response']['results'])){
				
				
			// http://stackoverflow.com/questions/4035742/parsing-json-object-in-php-using-json-decode
			foreach($json['results']['q']['response']['results'] as $item) {
              // print $item['state'];
			  
			  // var_dump($item);
			  
			  $state_twoletter = $item['address_components']['state'];
			  $district_in_state_with_copy =  $item['fields']['congressional_district']['name'];
			  
			  
			  
            }

			
			// congressional district comes with copy from API, need to just get numeric item
			
			$district_split_array = explode(" ",$district_in_state_with_copy);
			
			$district = 0;
			
			foreach ($district_split_array as $item){
			
               if ( is_numeric($item)){
                 $district = $item;
			   }			   
				
			}
			
			
			
			redirect(base_url().'my-congress/'.$state_twoletter."/".$district, 'location');
			
			
			/*
			
			
			
			$data['senator_results'] = $this -> guest_model -> get_senators_for_state($state_twoletter);
	  
	      
			$data['house_results'] = $this -> guest_model -> get_rep_for_state($state_twoletter,$district);
	  
	  		
			
			// pass vars to view for pdf generation
			
			$data['district'] = $district;
			$data['state_twoletter'] = $state_twoletter;
			
			
			// if non error data found
			}
			else {
			  $found_data = false;  // non correct data found	
			}
			
			$data['found_data'] = $found_data;
			
			$this->load->view('guest/results',$data);
			
			
			*/
			
			
			
			
			
			
			// found data if end
			}
			else if ($json_results == 'past_limit') {
				
				$data['message'] = "Exceeded API accesses for the day";
				$this->load->view('guest/error',$data);
			}
			else {
			  $data['message'] = "You need to enter something";	
			  $this->load->view('guest/error',$data);
				
			}
			
			
		  }
          else {
			 $data['message'] = "Nothing found";  
			 $this->load->view('guest/error',$data);
			  
		  }
		  
      // form validation run
	  }
    }

	
	
	
	
	
	function my_congress($state_twoletter='',$district=0){
		
		// must check for valid state
		  
		  
		  if ($this -> is_sate($state_twoletter)){
			  
			  if ((is_numeric($district) && $district < 150) && strtoupper($state_twoletter) != 'DC'){
				  
				   
				      $this->load->model('guest_model');
	               
					
				   
				   
				   
				   
				   
			
			// congressional district comes with copy from API, need to just get numeric item
	
			$data['senator_results'] = $this -> guest_model -> get_senators_for_state($state_twoletter);
	  
	        /*
	        echo "Senate<br>";
			foreach ($senator_results as $row){
			  echo $row['first_name']." ".$row['last_name'];
              echo "<br>";			  
			}
			
			echo "House ".$district."<br>";
			
			*/
			// echo substr("Hello world",10);
			
			$data['house_results'] = $this -> guest_model -> get_rep_for_state($state_twoletter,$district);
	  
	  
	        /*
			foreach ($house_results as $row){
			  echo $row['first_name']." ".$row['last_name'];
              echo "<br>";			  
			}
			
			*/
			
			
			// pass vars to view for pdf generation
			
			$data['district'] = $district;
			$data['state_twoletter'] = $state_twoletter;
			
			
			$data['found_data'] = true;
			
			$data['state_name'] = $this->get_state_name($state_twoletter);
			
			 $this->load->view('guest/results',$data);
			
			
			
			
			// if non error data found
			}
			else if (strtoupper($state_twoletter) == 'DC'	) {
			     $found_data = false; 
				 
			
			    $data['found_data'] = false; 
				$this->load->view('guest/dc',$data);
			}
			else {
			  $found_data = false;  // non correct data found	
			}
			
			
			  
			  // failed bad data check
		  }
		  
		
	}
	
	
	// come in with state and district for PDF
	
	function generate_pdf($state_twoletter='',$district=0){
		
		  // must check for valid state
		  
		  if ($this -> is_sate($state_twoletter)){
			  
			  if (is_numeric($district) && $district < 150){
				  
				    $this->load->model('guest_model');
	                $this->guest_model->generate_pdf($state_twoletter,$district);

			  }

		  }
		  else {
			  
			  // failed bad data check
		  }
		  
		  
	 
		
	}
	
	
	
	
	
	function is_sate($state_twoletter){
		
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
		
		return true;
		
	}
	else {
	  return false;	
		
	}
	
		
	}
	
	

	
	
	function get_state_name($state_twoletter){
		
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
	
	
	

	 private function lat_lon_check($ll){
		
      return is_numeric($ll);		
	  // return preg_match('/^(\-?\d+(\.\d+)?),\s*(\-?\d+(\.\d+)?)$/', $ll);
	
	 }
	 
	
	function recap_check($str){
	
	
	   $recaptcha = $this->input->post('g-recaptcha-response');
        if (!empty($recaptcha)) {
            $response = $this->recaptcha->verifyResponse($recaptcha);
            if (isset($response['success']) and $response['success'] === true) {
                return true;
            }
			else {
				 $this->form_validation->set_message('racap_check', 'You must complete the I\'m not a robot checkbox correctly.');
	             return false;
			}
			
        }

		
	 /*
	 if (strtolower($str) == 'yes'){
	   return true;
	 }
	 else {
	  $this->form_validation->set_message('yes_check', 'You must type \'yes\' in the yes box.');
	  return false;
	 }
	 */
	 
	}
	
	
    // not being used
	
    function force_ssl() {
		
		$url_parts = parse_url(current_url());
        $url = str_replace('www.', '', $url_parts['host']);

    // only if remote 
	if ($url == 'voteforyou.co'){
     if (!isset($_SERVER['HTTPS']) || $_SERVER['HTTPS'] != "on") {
        $url = "https://". $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];
        redirect($url);
        exit;
     }
	}
	
}
	
	
	
}
