<?php
class Penelitian_prodi_x_model extends grocery_CRUD_Model
	{
		protected $kode_prodi = null;

    
    function set_kode_prodi($kode_prodi = null)
    {    	
    	$this->kode_prodi = $kode_prodi;
    	
    	return true;
    }

	function get_list()
	{
		if($this->table_name === null)
		 	return false;
		$select = "{$this->table_name}.*";
		$select .= ", dosen_meneliti.kode_meneliti_sebagai, dosen_meneliti.kode_dosen";

		if(!empty($this->relation))
		{
			foreach($this->relation as $relation)
			{
			   list($field_name , $related_table , $related_field_title) = $relation;
			   $unique_join_name = $this->_unique_join_name($field_name);
			   $unique_field_name = $this->_unique_field_name($field_name);
		  
				if(strstr($related_field_title,'{'))
					$select .= ", CONCAT('".str_replace(array('{','}'),array("',COALESCE({$unique_join_name}.",", ''),'"),str_replace("'","\\'",$related_field_title))."') as $unique_field_name";
		   		else	  
					$select .= ", $unique_join_name.$related_field_title as $unique_field_name";
		  
		   		if($this->field_exists($related_field_title))
					$select .= ", {$this->table_name}.$related_field_title as '{$this->table_name}.$related_field_title'";
			}
		}
		$this->db->select($select, false);
		
	  
		// $this->db->join('dosen_meneliti','dosen_meneliti.kode_penelitian = penelitian.kode_penelitian');
		// $this->db->join('dosen','dosen_meneliti.kode_dosen = dosen.kode_dosen');
		// $this->db->where('dosen.id_prodi', $this->kode_prodi); 
		// $this->db->group_by("penelitian.kode_penelitian"); 
	 	$results = $this->db->get($this->table_name)->result();
		
		 return $results;
		}
	}
?>