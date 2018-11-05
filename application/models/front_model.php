<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Front_Model extends CI_Model {

	public function getFront()
	{
		$cek = $this->db->get('setting');
		if($cek->num_rows()>0)
		{
			foreach($cek->result() as $qad)
			{
				$sess_data['creator'] = $qad->creator;
				$sess_data['judul'] = $qad->judul;
				$sess_data['desc'] = $qad->desc;
				$sess_data['logo'] = $qad->logo;
				$this->session->set_userdata($sess_data);
			}
		}
	}
}

/* End of file front_model.php */
/* Location: ./application/models/front_model.php */