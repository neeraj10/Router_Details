<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

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
	 
	public function __construct() {
		parent::__construct();
		$this->load->database();
	 }
  
	
	 
	public function index()
	{
		$file_data=0;
		if(isset($_POST['submit']) && !empty($_POST['submit'])) 

		{
			$file_data = $this->csvimport->get_array($_FILES["csv_file"]["tmp_name"]);
			$i=1;	
			if(!empty($file_data)){
			foreach($file_data as $row)
			{
				$data['Sapid']=$row['Sapid'];
				$data['Hostname']=$row['Hostname'];
				$data['Loopback']=$row['Loopback'];
				$data['mac_address']=$row['mac_address'];
			 	$this->crud->insert('router_details',$data);
			 
			}
			}else{
				echo "Please select file";
			}
			
		
		}

		
		$this->db->get('router_details');
		$this->load->view('welcome_message');
	}
	public function get_items()
   {
      $draw = intval($this->input->get("draw"));
      $start = intval($this->input->get("start"));
      $length = intval($this->input->get("length"));


      $query = $this->db->get("router_details");


      $data = [];


      foreach($query->result() as $r) {
           $data[] = array(
                $r->id,
                $r->Sapid,
                $r->Hostname,
				$r->Loopback,
				$r->mac_address
				
           );
      }


      $result = array(
               "draw" => $draw,
                 "recordsTotal" => $query->num_rows(),
                 "recordsFiltered" => $query->num_rows(),
                 "data" => $data
            );


      echo json_encode($result);
      exit();
   }

   function deletedata($id=''){
	$id = intval($this->input->post("id"));
	$this->crud->delete('router_details',$id);
   }
   function updatedata($id='',$sap='',$host='',$loop='',$mac=''){
	$id = intval($this->input->post("id"));
	$sap = $this->input->post("sap");
	$host = $this->input->post("host");
	$loop = $this->input->post("loop");
	$mac = $this->input->post("mac");
	$data = [
		'Sapid' => $sap,
		'Hostname' => $host,
		'Loopback' => $loop,
		'mac_address' => $mac,
	];

	$this->crud->update('router_details',$id,$data);
   }
   
}




