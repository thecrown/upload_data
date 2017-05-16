<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mycontroller extends CI_Controller {
	public function __construct()
  {
     parent::__construct();
     $this->load->helper(array('form','url','file'));
		 $this->load->library(array('form_validation'));
		 $this->load->model('mymodel');
  }
	public function index()
	{
		$error=array(
			'error_name'=>'',
			'error_image'=>''
		);
		$this->load->view('upload_image',$error);
	}
	public function do_upload(){
		$this->form_validation->set_rules('Companyname','Companyname','trim|xss_clean|required');

		$config['upload_path'] 		= './uploads/';
        $config['allowed_types']	= 'gif|jpg|png';
        $config['max_size']     	=   2048;

  	     $this->load->library('upload', $config);
		$image_status = $this->upload->do_upload('userfile');
		
        if($this->form_validation->run() == false and empty($_FILES['userfile']['name'][0])){
				$error = array(
					'error_name'=>'please fill the Company name',
					'error_image'=>'please fill the Company image',
				);
				$this->load->view('upload_image',$error);
		}elseif($this->form_validation->run() == true and empty($_FILES['userfile']['name'][0])){
				$error = array(
					'error_name'=>'',
					'error_image'=>'please fill the Company image',
				);
				$this->load->view('upload_image',$error);
		}elseif($this->form_validation->run()==false and !empty($_FILES['userfile']['name'][0])){
				!$this->upload->data();
				$error = array(
					'error_name'=>'please fill the Company name',
					'error_image'=>'',
				);
				$this->load->view('upload_image',$error);
		}elseif($this->form_validation->run()==true and !empty($_FILES['userfile']['name'][0])){
			$this->upload->do_upload();
			$data = array('upload_data'=>$this->upload->data());
			$this->resize_image($data['upload_data']['full_path'],$data['upload_data']['file_name']);
			$config =array(
				'companyname' => $this->input->post('Companyname'),
				'companyimage' => $data['upload_data']['file_name']
			);
			$this->load->model('mymodel');
			$this->mymodel->insert($config);
		}
	}
	public function resize_image($path,$file)
		{
			$config_resize =array();
			$config_resize['image_library'] = 'gd2';
			$config_resize['source_image'] = $path;
			//$config_resize['create_thumb'] = TRUE;
			$config_resize['maintian_ratio'] = TRUE;
			$config_resize['width'] = 75;
			$config_resize['height'] = 50;
			$config_resize['new_image'] = './uploads/thumb/'.$file;
			$this->load->library('image_lib',$config_resize);
			$this->image_lib->resize();
		}
	public function company_list(){
		$data['company'] = $this->mymodel->get_data();
		$this->load->view('company_list',$data);
	}
	public function edit_image($id){
		$company = array(
			'error_name'=>'',
			'error_image'=>''
		);
		$this->load->model('mymodel');
		$company['data_company'] = $this->mymodel->get_data_company($id);
		$this->load->view('edit_data',$company);
	}
	public function do_update($id){

		$this->form_validation->set_rules('Companyname','Companyname','trim|xss_clean|required');

		$config['upload_path'] 		= './uploads/';
    $config['allowed_types']	= 'gif|jpg|png';
    $config['max_size']     	=   2048;

  	$this->load->library('upload', $config);
		$image_status = $this->upload->do_upload('userfile');

		if($this->form_validation->run() == false and empty($_FILES['userfile']['name'][0])){

				$company = array(
					'error_name'=>'please fill the Company name',
					'error_image'=>'',
				);

				$company['data_company'] = $this->mymodel->get_data_company($id);
				$this->load->view('edit_data',$company);

		}elseif($this->form_validation->run() == true and empty($_FILES['userfile']['name'][0])){

				$company = array(
					'companyname'=>$this->input->post('Companyname')
				);

				$this->mymodel->update($company,$id);
				redirect('Mycontroller/company_list');

		}elseif($this->form_validation->run()==true and !empty($_FILES['userfile']['name'][0])){

			$this->upload->do_upload();
			$data = array('upload_data'=>$this->upload->data());
			$this->resize_image($data['upload_data']['full_path'],$data['upload_data']['file_name']);

			$query = $this->mymodel->get_data_company($id);

			foreach ($query as $key) {
				unlink('./uploads/'.$row->companyimage);
				unlink('./uploads/thumb/'.$row->companyimage);
			}

			$company =array(
				'companyname' => $this->input->post('Companyname'),
				'companyimage' => $data['upload_data']['file_name']
			);
			$this->load->model('mymodel');
			$this->mymodel->update($company,$id);
			redirect('Mycontroller/company_list');
		}
	}
	public function delete_data($id){
		$query = $this->mymodel->delete($id);
		foreach ($query as $key) {
			unlink('./uploads/'.$row->companyimage);
			unlink('./uploads/thumb/'.$row->companyimage);
		}
		if($query){
			redirect ('Mycontroller/company_list');
		}else{
			$company = array(
				'error_name'=>'sorry file delete unsucces',
				'error_image'=>'',
			);
			$company['company'] = $this->mymodel->get_data();
			$this->load->view('edit_data',$company);

		}
	}
}
