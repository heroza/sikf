<?php
class Kurikulum_model extends CI_Model  {
 
    public function kurikulum_berlaku_prodi($id_prodi) {
        $query = $this->db->get_where('kurikulum', array('id_prodi' => $id_prodi, 'akhir_berlaku' => NULL));

        if ($query->num_rows() > 0)
        {
           $row = $query->row(); 

           return $row->kode;
        }
        else
            return '0';
    }
 
}
?>