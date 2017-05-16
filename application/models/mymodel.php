<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mymodel extends CI_Model {

  public function insert($data_company){
    $this->db->insert('amien',$data_company);
  }
  public function get_data(){
    $query = $this->db->get('amien');
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return $query->result();
    }
  }
  public function get_data_company($id){
    $where = array(
      'id'=>$id
    );
    $query = $this->db->get_where('amien',$where);
    if($query->num_rows() > 0){
      return $query->result();
    }else{
      return false;
    }
  }
  public function update($company,$id){
    $this->db->where('id',$id);
    $this->db->update('amien',$company);
  }
  public function delete($id){
              $this->db->where('id',$id);
    $hasil =  $this->db->delete('amien');
    if($hasil){
      return true;
    }else{
      return false;
    }

  }

}
