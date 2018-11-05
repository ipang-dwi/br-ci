<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends CI_Controller {
	
	public function __construct()
	{
		parent::__construct();

		$this->load->database();
		$this->load->helper('url');

		$this->load->library('grocery_CRUD');
	}
	
	public function index()
	{
		if($this->session->userdata('logged_in')!="" && $this->session->userdata('username')!="" && $this->session->userdata('password')!=""){
			$this->session->set_userdata('option','mobil');
			$crud = new grocery_CRUD();
			//$crud->set_theme('datatables');
			//$crud->set_language('indonesian');
			$crud->set_table('mobil');
			$crud->set_subject('Daftar Mobil Baru');
			$crud->display_as('spe','Nomer SPE')
			     ->display_as('nopol','Nomer Polisi')
				 ->display_as('jenis','Jenis Mobil')
				 ->display_as('nocon','Nomer Container')
				 ->display_as('supir','Nama Supir')
				 ->display_as('hp','Nomer HP')
				 ->display_as('masuk','Masuk Tgl-Jam');
			$crud->required_fields('ekspedisi','spe','jenis','nopol','nocon','supir','hp','masuk','tujuan','status');
			if($this->session->userdata('jt')!="admin") $crud->unset_delete();
			$output = $crud->render();

			$this->_example_output($output);
		}
		else
			header('location:'.base_url().'');
	}
	
	public function user(){
		if($this->session->userdata('logged_in')!="" && $this->session->userdata('username')!="" && $this->session->userdata('password')!="" && $this->session->userdata('jt')=="admin"){
			$this->session->set_userdata('option','user');
			$crud = new grocery_CRUD();
			$crud->set_table('user');
			$crud->display_as('job_title','Job Title');
			$crud->set_subject('User Baru');
			$crud->required_fields('username','password','job_title','pic','since');
			$crud->set_field_upload('pic','assets/uploads/pics');
			$crud->callback_before_insert(array($this,'encrypt_password'));
			$crud->callback_before_update(array($this,'encrypt_password'));
			$output = $crud->render();

			$this->_example_output($output);
		}
		else
			header('location:'.base_url().'');
	}
	
	public function setting(){
		if($this->session->userdata('logged_in')!="" && $this->session->userdata('username')!="" && $this->session->userdata('password')!=""){
			$this->session->set_userdata('option','setting');
			$crud = new grocery_CRUD();
			$crud->set_table('setting');
			$crud->unset_add()
				 ->unset_delete()
				 ->unset_print()
				 ->unset_export()
				 ->unset_read();
			$crud->display_as('desc','Deskripsi');
			$crud->display_as('logo','Gambar Halaman Depan');
			$crud->set_subject('User');
			$crud->required_fields('creator','judul','desc','logo');
			$crud->set_field_upload('logo','assets/uploads/logo');
			$output = $crud->render();

			$this->_example_output($output);
		}
		else
			header('location:'.base_url().'');
	}
	
	public function profile(){
		if($this->session->userdata('logged_in')!="" && $this->session->userdata('username')!="" && $this->session->userdata('password')!=""){
			$this->session->set_userdata('option','profile');
			$crud = new grocery_CRUD();
			$crud->set_table('user');
			$crud->columns('username','job_title','pic','since');
			$crud->fields('username','password','job_title','pic');
			$crud->unset_add()
				 ->unset_delete()
				 ->unset_print()
				 ->unset_export()
				 ->unset_read();
			$crud->where('username',$this->session->userdata('username'));
			$crud->display_as('job_title','Job Title');
			$crud->set_subject('User');
			$crud->required_fields('username','password','pic');
			$crud->set_field_upload('pic','assets/uploads/pics');
			$crud->callback_before_update(array($this,'encrypt_password'));
			$output = $crud->render();

			$this->_example_output($output);
		}
		else
			header('location:'.base_url().'');
	}
	
	public function encrypt_password($post_array, $primary_key = null)
    {
	    $this->load->helper('security');
	    $post_array['password'] = do_hash($post_array['password'].'@adDunyaa2$MataaAdDunyaa%4#AlMarAtus91Sholihah', 'md5');
	    return $post_array;
    }
	
	public function _example_output($output = null)
	{
		$this->load->view('lte.php',$output);
	}
	
}

/* End of file dashboard.php */
/* Location: ./application/controllers/dashboard.php */