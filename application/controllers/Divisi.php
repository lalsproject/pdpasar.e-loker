<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Divisi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('is_login') != true OR $this->session->userdata('role') != 'Divisi')
		{
			redirect('outdiv');
		}
	}

	public function index()
	{
		$data['title'] = 'homediv Divisi';
		$data['c_lamaran'] = $this->db->get_where('view_lamaran','flag_aktif = "Y" AND id_divisi = "'.$this->session->userdata('id_divisi').'"')->num_rows();
		$data['c_lowongan'] = $this->db->get_where('tbl_lowongan','flag_aktif = "Y" AND id_divisi = "'.$this->session->userdata('id_divisi').'"')->num_rows();
		render('divisi/home',$data);
	}

	function lowongan()
	{
		$this->load->model('ModelLowongan','m_lowongan');
		$data['title'] = 'Data Lowongan';
		$data['lowongan'] = $this->m_lowongan->get_lowongan($this->session->userdata('id_divisi'));
		
		render('divisi/lowongan',$data);
	}

	function simpan_lowongan()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$judul = $this->input->post('judul_lowongan');
			$persyaratan = $this->input->post('persyaratan');
			$tanggung_jawab = $this->input->post('tanggung_jawab');
			$gaji = $this->input->post('gaji');

			$data = array(
				'id_divisi' => $this->session->userdata('id_divisi'), 
				'judul_lowongan' => $judul, 
				'persayaratan' => $persyaratan, 
				'tanggung_jawab' => $tanggung_jawab, 
				'gaji' => $gaji, 
			);

			$insert = $this->db->insert('tbl_lowongan', $data);
			if ($insert)
			{
				$this->session->set_flashdata('notif', '<script>swal("Berhasil","Data Lowongan berhasil ditambahkan","success")</script>');
				redirect('data_lowongan');
			}
			else
			{
				$this->session->set_flashdata('notif', '<script>swal("Error","Data Lowongan gagal ditambahkan","error")</script>');
				redirect('data_lowongan');
			}
		}
	}

	function detail_lowongan()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$id_lowongan = $this->input->post('arg');
			$data['l'] = $this->db->get_where('tbl_lowongan', 'id_lowongan = "'.decrypt($id_lowongan).'"');
			if ($data['l']->num_rows() > 0)
			{
				$data['l'] = $data['l']->row();
				$this->load->view('divisi/detail_lowongan', $data);
			}
			else
			{
				echo '<div class="alert alert-danger" role="alert">
					Data Tidak Ditemukan 😥
				</div>';
			}
		}
	}

	function edit_lowongan()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$id_lowongan = $this->input->post('arg');
			$data['l'] = $this->db->get_where('tbl_lowongan', 'id_lowongan = "'.decrypt($id_lowongan).'"');
			if ($data['l']->num_rows() > 0)
			{
				$data['l'] = $data['l']->row();
				$this->load->view('divisi/edit_lowongan', $data);
			}
			else
			{
				echo '<div class="alert alert-danger" role="alert">
					Data Tidak Ditemukan 😥
				</div>';
			}
		}
	}

	function simpan_edit_lowongan()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$id = decrypt($this->input->post('arg'));
			$judul = $this->input->post('judul_lowongan');
			$persyaratan = $this->input->post('persyaratan');
			$tanggung_jawab = $this->input->post('tanggung_jawab');
			$gaji = $this->input->post('gaji');

			$data = array(
				'id_divisi' => $this->session->userdata('id_divisi'), 
				'judul_lowongan' => $judul, 
				'persayaratan' => $persyaratan, 
				'tanggung_jawab' => $tanggung_jawab, 
				'gaji' => $gaji, 
			);

			$insert = $this->db->update('tbl_lowongan', $data,array('id_lowongan' => $id, ));
			if ($insert)
			{
				$this->session->set_flashdata('notif', '<script>swal("Berhasil","Data Lowongan berhasil diubah","success")</script>');
				redirect('data_lowongan');
			}
			else
			{
				$this->session->set_flashdata('notif', '<script>swal("Error","Data Lowongan gagal diubah","error")</script>');
				redirect('data_lowongan');
			}
		}
	}

	function hapus_lowongan()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$id_lowongan = decrypt($this->input->post('arg'));
			$del = $this->db->delete('tbl_lowongan',array('id_lowongan' => $id_lowongan,));
			if ($del)
			{
				echo json_encode(array('result' => 'oke',));
			}
			else
			{
				http_response_code(404);
				echo json_encode(array('result' => 'gagal',));
			}
		}
	}

	function lamaran()
	{
		$data['title'] = 'Lamaran';
		$data['lamaran'] = $this->db->get_where('view_lamaran','flag_aktif = "Y" AND flag_berkas = "Y" AND id_divisi = "'.$this->session->userdata('id_divisi').'"')->result();
		render('divisi/lamaran',$data);
	}

	function cek_lamaran()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$id_lamaran = decrypt($this->input->post('arg'));
			$cek = $this->db->get_where('view_lamaran', 'id_lamaran = "'.$id_lamaran.'"');
			if ($cek->num_rows() > 0)
			{
				$this->load->model('ModelUser','m_user');
				
				$data['l'] = $cek->row();
				$data['pribadi'] = $this->m_user->get_profile_user($data['l']->id_user);
				$data['pendidikan'] = $this->db->get_where('tbl_pendidikan', 'id_user = "'.$data['l']->id_user.'"')->result();
				$data['pengalaman'] = $this->db->get_where('tbl_pengalaman', 'id_user = "'.$data['l']->id_user.'"')->result();
				
				// echo "<pre>";
				// echo json_encode ($data,JSON_PRETTY_PRINT);
				// echo "</pre>";

				$this->load->view('divisi/data_pelamar', $data);
			}
			else
			{
				echo '
				<div class="alert alert-warning" role="alert">
					<strong>opss!</strong> Lamaran Tidak Ditemukan
				</div>
				';
			}
		}
		else
		{
			http_response_code(404);
		}
	}

	function cek_berkas()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$id_lamaran = decrypt($this->input->post('arg'));
			$flag = decrypt($this->input->post('arg1'));
			$cek = $this->db->get_where('tbl_lamaran','id_lamaran = "'.$id_lamaran.'"');
			if ($cek->num_rows() > 0)
			{
				$lamaran = $this->db->get_where('view_lamaran','id_lamaran = "'.$cek->row()->id_lamaran.'"')->row();
				$id_telegram = $this->db->get_where('tbl_user', 'id_user = "'.$cek->row()->id_user.'"')->row()->id_telegram;
				if ($flag == 'Y')
				{
					$update = $this->db->update('tbl_lamaran', array('flag_tes' => $flag, ),array('id_lamaran' => $id_lamaran, ));
					if ($update)
					{
						$pesan = "
							
Selamat !! 
Anda Lulus Ditahap Tes !! ✅
Lamaran : $lamaran->judul_lowongan
Divisi  : $lamaran->nama_divisi

						";
						$res = sendMessage($pesan,$id_telegram);
					}
				}
				else 
				{
					$update = $this->db->update('tbl_lamaran', array('flag_tes'=>'T','flag_aktif' =>'N'),array('id_lamaran' => $id_lamaran, ));
					if ($update)
					{
						$pesan = "
							
Maaf !! 
Anda Belum Lulus  Tes 🥺
Lamaran : $lamaran->judul_lowongan
Divisi  : $lamaran->nama_divisi

						";
						$res = sendMessage($pesan,$id_telegram);
					}
				}

				echo json_encode(array('result' => 'oke', ));
			}
			else
			{
				echo json_encode(array('result' => 'not_found', ));
			}
		}
	}

	function ubahpassword()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$old = $this->input->post('old_pass');
			$new = $this->input->post('new_pass');
			$cek = $this->db->get_where('tbl_divisi', 'id_divisi = "'.$this->session->userdata('id_divisi').'" AND password = "'.encrypt(md5($old)).'"');
			if ($cek->num_rows() > 0)
			{
				$this->db->update('tbl_divisi', array('password' => encrypt(md5($new))),array('id_divisi' => $this->session->userdata('id_divisi'), ));
				$this->session->set_flashdata('notif', '<script>swal("Berhasil","Password Berhasil Diubah","success")</script>');
				redirect('homediv');
			}
			else
			{
				$this->session->set_flashdata('notif', '<script>swal("Opss","Password Lama Salah","warning")</script>');
				redirect('homediv');
			}
		}
		else
		{
			http_response_code(404);
		}
	}
}

/* End of file Divisi.php */
/* Location: ./application/controllers/Divisi.php */