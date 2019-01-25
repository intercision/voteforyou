<?php
defined('BASEPATH') OR exit('No direct script access allowed');

// govtrack data going away summer '17

class Experimental extends CI_Controller {




	// if you importing the data from a CSV instead of an SQL file
    // you need to run this to put the birthdays in a date field

	
	/*
	function bdays999(){


	   $q = $this->db->get('govtrack_congress_member');
	   $all_res = $q->result_array();

		set_time_limit (0);


     foreach ($all_res as $row){

	    $id = $row['id'];

	    $birthday = $row['birthday'];


		    // set email confirm to 1
	    $db_update = array(
               'birthday_date' => $birthday
         );

        $this->db->where('id', $id);
        $this->db->update('govtrack_congress_member', $db_update);




      }

	}

	*/

	/*

	function wait_test(){

       @set_time_limit(0);
 	   sleep(300);

	   echo "done waiting";

    }

	*/



	/*

	function add_fields(){

		   // takes in a CSV list of emails put through geocod.io (make sure to add Congressional District to your geocoding)
		   // to put in media/list.csv

		   // this currently just adds fields, does not update them
		   // you need to delete the fields it will add to have it add them


		   // may have to bump up max_execution_time in php.ini on your system
		   @set_time_limit(0);

		   $has_sen = false;
		   $has_rep = false;



		   // rep and sen prefixes


		   // this can be any field from that govtrack_congress_member table
		   // preceded by either sen_ or rep_ depending on if you want to get a Representative or Senator

		   $fields_to_add = Array(
		     'sen_first_name','sen_last_name','sen_phone',
			 'rep_first_name','rep_last_name','rep_phone'
		   );



	       $this->load->library('csvreader');

		   $this->load->model('experimental_model');


		   // list.csv is where your e-mail list (run through geocod.io to get the congressional district)
           $filePath = './media/list.csv';

           $csv_contents = $this->csvreader->parse_file($filePath);



	       $fp = fopen('./media/list_dest.csv', 'w');


		   $key_row_array = Array();

		   // get row headings
		   $key_row = '';
		   foreach($csv_contents[0] as $key => $value){


			   $key_row_array[] = $key;

		   }



		   $rep_fields = Array();
		   $sen_fields = Array();

		   // add our row headings and split sen/rep fields

		   $field_dest_array = Array();

		   foreach($fields_to_add as $field){

			   // check for sen and rep

			   if ( strpos($field, 'rep_') !== false ) {

			     $has_rep = true;

				 $rep_fields[] = substr($field,4);

				 $field_dest_array[] = $field;
		         $key_row_array[] = $field;
			   }
               else if ( strpos($field, 'sen_') !== false ) {

			      $has_sen = true;
			      $field_short = substr($field,4);
				  $sen_fields[] = $field_short;


				  // two fields for senators   right next to each other!



		          $key_row_array[] =  'sen1_'.$field_short;  $key_row_array[] =  'se2_'.$field_short;


				  $field_dest_array[] = 'sen1_'.$field_short;  $field_dest_array[] = 'sen2_'.$field_short;

			   }


		   }


		   fputcsv($fp, $key_row_array);







			$dest_row_array = Array();

		   foreach($csv_contents as $field){


		   // optimized for geocod.io
		   // [state_twoletter][district #]
		   $heading_name = '"Congressional District"';




			// must build array

			// found district info in source CSV
			if (array_key_exists($heading_name,$field)){
		      $state_plus_district = $field[$heading_name];
			  $state_twoletter = substr($state_plus_district,0,2);
			  $district = substr($state_plus_district,2);


			  if ($has_rep){
			     $rep = $this-> experimental_model -> get_official_rep_record($state_twoletter,$district);

				 foreach ($rep as $row){


                    foreach ($rep_fields as $rf_key){

						// echo $row[$sf_key].",";
						$dest_key = 'rep_'.$rf_key;
						$dest_row_array[$dest_key] = $row[$rf_key];

					}




				}


			  }

			  if ($has_sen){
				// going to be two on this one
			    $sen = $this-> experimental_model -> get_official_sen_record($state_twoletter);

				$i = 1;
				foreach ($sen as $row){

                    foreach ($sen_fields as $sf_key){

						$dest_key = 'sen'.$i."_".$sf_key;
						$dest_row_array[$dest_key] = $row[$sf_key];

					}


					$i++;
				}

			  }

		    }


			 // initial fields

             $final_there_array = Array();
			 foreach ($field as $key => $value){
			   $final_there_array[] = $value;
			 }

			 $final_addon_array = Array();

			 // >>> field_dest_array has the best information  <<<


			 // addon fields  $correct_order_holder = Array();
			 foreach ($field_dest_array as $key2){
				$final_addon_array[] = $dest_row_array[$key2];
			 }


             $final_row_array = array_merge($final_there_array, $final_addon_array);


			$put_flag = fputcsv($fp, $final_row_array);


			// foreach csv_contents
		   }


		   echo "Output is going to be in media/list_dest.csv";

	}


	*/




	/*
	function images_from_bioguide(){


	   $q = $this->db->get('govtrack_congress_member');
	   $all_res = $q->result_array();

		set_time_limit (0);


	 $i = 0;

     foreach ($all_res as $row){

	    $bioguide_id = $row['bioguide_id'];

		$first_letter = substr($bioguide_id, 0,1);

        $image_url = 'http://bioguide.congress.gov/bioguide/photo/'.$first_letter.'/'.$bioguide_id.'.jpg';

	    echo "<img src=".$image_url.">";
		echo "<br>";

        $i++;

	    //if ($i >= 10) break;

      }

	}

	*/

	/*

	// not as good as https://github.com/unitedstates/congress-legislators Python script to do it

	public function yaml_to_csv()
	{

	  // parsing YAML data, trying to with array
	  // for when govtrack CSV data is no more




	  $constants_array = array(

	  'last_name' => 'last_name',
	  'first_name' => 'first_name',
	  'birthday' => 'birthday',
	  'gender' => 'gender',
	  'type' => 'type',
	  'district' => 'district',
	  'party' => 'party',
	  'url' => 'url',
	  'address' => 'address',
	  'phone' => 'phone',
	  'contact_form' => 'contact_form',
	  'rss_url' => 'rss_url',
	  'bioguide_id' => 'bioguide_id',
	  'thomas_id' => 'thomas_id',
	  'opensecrets_id' => 'opensecrets_id',
	  'lis_id' => 'lis_id',
	  'cspan_id' => 'cspan_id',
	  'govtrack_id' => 'govtrack_id',
	  'votesmart_id' => 'votesmart_id',
	  'ballotpedia_id' => 'ballotpedia_id',
	  'maplight_id' => 'maplight_id',
	  'icpsr_id' => 'icpsr_id',
	  'wikipedia_id' => 'wikipedia_id',
	  'house_history_id' => 'house_history_id',
	  'google_entity_id' => 'google_entity_id'
	   );


	   $to_csv_data[] = $constants_array;



      // echo "test";

      $this->load->helper('spyc');


	  // $data = spyc_load_file('./data/indent_1.yaml');

	  $data = spyc_load_file('./data/legislators-current.yaml');


	  $counter = 0;


	  // very data structure dependant

	  foreach ($data as $item){

		   if (is_array($item)){

		      $keys_array = Array();
			  $terms_array = Array();

              foreach ($item as $key => $value){

				  $keys_array[] = $key;

				  if (is_numeric($key)){
					 $terms_array[] = $key;
				  }



				  // debug

				  //echo "<h2>".$key."</h2>";
                  // var_dump($value);


				   if ($key === 'id'){
					  // echo "<h1>".$key."</h1>";

						foreach ($value as $subitem_key => $subitem_value){


					    if ($subitem_key === 'bioguide'){
						    $bioguide_id = $subitem_value;
					    }
	                    else if ($subitem_key === 'thomas'){
						    $thomas_id = $subitem_value;
					    }
	                    else if ($subitem_key === 'opensecrets'){
						    $opensecrets_id = $subitem_value;
					    }
	                    else if ($subitem_key === 'lis'){
						    $lis_id = $subitem_value;
					    }
	                    else if ($subitem_key === 'cspan'){
						    $cspan_id = $subitem_value;
					    }
                        else if ($subitem_key === 'govtrack'){
						    $govtrack_id = $subitem_value;
					    }
                        else if ($subitem_key === 'votesmart'){
						    $votesmart_id = $subitem_value;
					    }
                        else if ($subitem_key === 'ballotpedia'){
						    $ballotpedia_id = $subitem_value;
					    }
                        else if ($subitem_key === 'maplight'){
						    $maplight_id = $subitem_value;
					    }
                        else if ($subitem_key === 'icpsr'){
						    $icpsr_id = $subitem_value;
					    }
                        else if ($subitem_key === 'wikipedia'){
						    $wikipedia_id = $subitem_value;
					    }
                        else if ($subitem_key === 'house_history'){
						    $house_history_id = $subitem_value;
					    }
                        else if ($subitem_key === 'wikidata'){
						    $wikidata_id = $subitem_value;
					    }
                        else if ($subitem_key === 'google_entity_id'){
						    $google_entity_id = $subitem_value;
					    }





					   }

					}


				 	if ($key === 'name'){
					 // echo "<h1>".$key."</h1>";

						foreach ($value as $subitem_key => $subitem_value){

					     if ($subitem_key === 'first'){
						    $first_name = $subitem_value;
					     }
						 else if ($subitem_key === 'last'){
						    $last_name = $subitem_value;
					     }
						 else if ($subitem_key === 'official_full'){
						    $official_full = $subitem_value;
					     }

					   }

					}


				 	if ($key === 'bio'){
					  // echo "<h1>".$key."</h1>";

						foreach ($value as $subitem_key => $subitem_value){

					     if ($subitem_key === 'birthday'){
						    $birthday = $subitem_value;
					     }
						 else if ($subitem_key === 'gender'){
						    $gender = $subitem_value;
					     }


					   }

					}






			  }

		   }
		   else {
			 // echo $item;
		   }



		   $max_term = max($terms_array);

		     // get data of latest term

			 // debug

			 // echo $max_term;

			 // if ($max_term == 0){
			  // echo $official_full;
			 // }

		     foreach ($item as $key => $value){


					// echo $key."<br>";

					if ($key === $max_term){
					  // echo "<h1>".$key."</h1>";

					    $district = 0;

					    foreach ($value as $subitem_key => $subitem_value){

					     if ($subitem_key === 'type'){
						    $type = $subitem_value;
					     }
						 else if ($subitem_key === 'state'){
						    $state = $subitem_value;
					     }
						 else if ($subitem_key === 'party'){
						    $party = $subitem_value;
					     }
	                     else if ($subitem_key === 'phone'){
						    $phone = $subitem_value;
					     }
	                     else if ($subitem_key === 'contact_form'){
						    $contact_form = $subitem_value;
					     }
	                     else if ($subitem_key === 'district'){
						    $district = $subitem_value;
					     }
	                     else if ($subitem_key === 'url'){
						    $url = $subitem_value;
					     }
	                     else if ($subitem_key === 'address'){
						    $address = $subitem_value;
					     }
	                     else if ($subitem_key === 'rss_url'){
						    $rss_url = $subitem_value;
					     }



					   }

				   }



			 }




	$add_record_array = array(
	  'last_name' => $last_name,
	  'first_name' => $first_name,
	  'birthday' => $birthday,
	  'gender' => $gender,
	  'type' => $type,
	  'district' => $district,
	  'party' => $party,
	  'url' => $url,
	  'address' => $address,
	  'phone' => $phone,
	  'contact_form' => $contact_form,
	  'rss_url' => $rss_url,
	  'bioguide_id' => $bioguide_id,
	  'thomas_id' => $thomas_id,
	  'opensecrets_id' => $opensecrets_id,
	  'lis_id' => $lis_id,
	  'cspan_id' => $cspan_id,
	  'govtrack_id' => $govtrack_id,
	  'votesmart_id' => $votesmart_id,
	  'ballotpedia_id' => $ballotpedia_id,
	  'maplight_id' => $maplight_id,
	  'icpsr_id' => $icpsr_id,
	  'wikipedia_id' => $wikipedia_id,
	  'house_history_id' => $house_history_id,
	  'google_entity_id' => $google_entity_id
	   );

	   $to_csv_data[] = $add_record_array;



		 // order of CSV  different than GovTrack

		 //  echo $last_name."<br>";
         //  echo $first_name."<br>";
		 //  echo $birthday."<br>";

		 //  echo $gender."<br>";
		 //  echo $type."<br>";
		 //  echo $state."<br>";
		 //  echo "District: ".$district."<br>";
         //  echo $party."<br>";

         //  echo $url."<br>";

		 //  echo $address."<br>";
		 //  echo $phone."<br>";
		 //  echo $contact_form."<br>";
		 //  echo $rss_url."<br>";

		  // missing FB and Twitter

		 //  echo "Bioguide ID: ".$bioguide_id."<br>";
		 //  echo "Thomas ID: ".$thomas_id."<br>";
		 //  echo "Opensecrets ID: ".$opensecrets_id."<br>";
		 //  echo "Lis ID: ".$lis_id."<br>";
		 //  echo "CSPAN ID: ".$cspan_id."<br>";
		 //  echo "GovTrack ID: ".$govtrack_id."<br>";
		 //  echo "VoteSmart ID: ".$votesmart_id."<br>";
		 //  echo "Ballotpedia ID: ".$ballotpedia_id."<br>";
		 //  echo "Maplight ID: ".$maplight_id."<br>";
		 //  echo "Icpsr ID: ".$icpsr_id."<br>";
		 //  echo "Wikipedia ID: ".$wikipedia_id."<br>";
		 //  echo "House History ID: ".$house_history_id."<br>";
		 //  echo "Google Entity ID: ".$google_entity_id."<br>";






           // var_dump($item);
		   // echo "<hr>";



	  }


	 // echo "<hr><hr><hr>";


	   // var_dump($to_csv_data);

	   $this -> to_csv ($to_csv_data);





	}

	*/





	private function to_csv($data_array){

    

	       // $data_array[] = array('x'=> '1', 'y'=> '2', 'z'=> '3', 'a'=> '5');
             header("Content-type: application/csv");
            header("Content-Disposition: attachment; filename=\"officials".".csv\"");
            header("Pragma: no-cache");
            header("Expires: 0");

            $handle = fopen('php://output', 'w');

            foreach ($data_array as $data) {
                fputcsv($handle, $data);
            }
                fclose($handle);
            exit;



	}



}
