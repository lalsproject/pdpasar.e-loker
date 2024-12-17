<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class ModelLowongan extends CI_Model {

	// public $variable;

	public function __construct()
	{
		parent::__construct();
		
	}

	function get_lowongan($id_divisi='')
	{
		if ($id_divisi != '')
		{
			$data = $this->db->query('
				SELECT 
				a.*
				FROM tbl_lowongan a
				WHERE a.id_divisi = "'.$id_divisi.'"
				ORDER BY a.regdate DESC
			')->result();
		}
		else
		{
			$data = $this->db->query('
				SELECT 
				a.*,
				b.nama_divisi
				FROM tbl_lowongan a
				LEFT JOIN tbl_profile_divisi b
				ON a.id_divisi = b.id_divisi
				ORDER BY a.regdate DESC
			')->result();
		}

		return $data;
	}

	function get_lowongan_aktif($id_divisi='')
	{
		if ($id_divisi != '')
		{
			$data = $this->db->query('
				SELECT 
				a.*
				FROM tbl_lowongan a
				WHERE a.id_divisi = "'.$id_divisi.'" AND flag_aktif = "Y"
				ORDER BY a.regdate DESC
			')->result();
		}
		else
		{
			$data = $this->db->query('
				SELECT 
				a.*,
				b.nama_divisi
				FROM tbl_lowongan a
				LEFT JOIN tbl_profile_divisi b
				ON a.id_divisi = b.id_divisi
				WHERE flag_aktif = "Y"
				ORDER BY a.regdate DESC
			')->result();
		}

		return $data;
	}

}

/* End of file ModelLowongan.php */
/* Location: ./application/models/ModelLowongan.php */