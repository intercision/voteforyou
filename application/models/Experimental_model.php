<?php
// now in UTF-8

class Experimental_model extends CI_Model {


 function get_official_rep_record($state_twoletter,$district){
	 
   // get rep
   $this->db->where('state',$state_twoletter);
   $this->db->where('district',$district);
   $this->db->where('type','rep');
   
    $q = $this->db->get('govtrack_congress_member');

      if ( $q->num_rows() > 0 ) {

	    return $q->result_array();
		 
		 
	  }
	  
   
 }
 
 function get_official_sen_record($state_twoletter){
	 
   // get rep
   $this->db->where('state',$state_twoletter);
    $this->db->where('type','sen');
    $q = $this->db->get('govtrack_congress_member');

      if ( $q->num_rows() > 0 ) {

	    return $q->result_array();
		 
		 
	  }
	  
   
 }
 
 
 
 
 
 
 
 

}