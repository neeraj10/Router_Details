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
		$data = array();
		$data['result'] = $this->crud->get_data('router_details');
		$this->load->view('welcome_message',$data);
		
	}
	public function importdata()
	{ 
		$this->load->view('import_data');
		if(isset($_POST["submit"]) && !empty($_FILES['file']['tmp_name']))
		{
			$file = $_FILES['file']['tmp_name'];
			//if(!empty($file))
			$handle = fopen($file, "r");
			$c = 0;//
			$count = 0;
			
			while(($filesop = fgetcsv($handle, 1000, ",")) !== false)
			{
				$count++;
				if ($count == 1){ 
					continue;
				}
				$sap_id = $filesop[0];
				$host_name = $filesop[1];
				$mac_address = $filesop[2];
				$loopback = $filesop[3];
				
				$this->crud->insert($sap_id,$host_name,$mac_address,$loopback);
				
			}
			 redirect('welcome');
				
		}
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

	return $this->crud->update('router_details',$id,$data);
	redirect('welcome');
   }
   
}




