<?php 
 class Crud extends CI_Model{ 
     
     
 function insert($table,$data) 
             { 
                         $result= $this->db->insert($table, $data); 
                         return $result; 
             } 
             
             
             
             function update($table,$id,$data) 
             { 
                         $this->db->where('id', $id); 
                         return $this->db->update($table,$data); 
             } 
   
   
             
             function get_data($table) 
             {   
                $data= $this->db->get($table); 
                return $data->result();                
             } 
   
             
             function delete($table,$id) 
             { 
                         $this->db->where('id', $id); 
                         return $this->db->delete($table); 
             } 
             
   
             public function fetchdatabyid($id,$table) 
     { 
                                     $this->db->where('id',$id); 
                 $data=$this->db->get($table); 
                 return $data->result(); 
     } 
   
             
   
             
 } 