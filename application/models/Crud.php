<?php 
 class Crud extends CI_Model{ 
     
     
            function insert($sap_id,$host_name,$mac_address,$loopback) 
            { 
               $data = array(
                  'Sapid'=>$sap_id,
                  'Hostname'=>$host_name,
                  'Loopback'=>$loopback,
                  'mac_address'=>$mac_address,
                
             
             );
             if ($this->db->insert('router_details', $data)) {
                return 'success';
             } else {
                return 'error';
             }
            } 
             
             function update($table,$id,$data) 
             { 
               $this->db->where('id', $id); 
               if ($this->db->update($table,$data)) {
                  return 'success';
               } else {
                  return 'error';
               }
               //return $this->db->update($table,$data); 
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