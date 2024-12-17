<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if ($this->session->userdata('role') != 'Admin')
		{
			redirect('keluar');
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('authmin');
	}

	public function index()
	{
		$data['title'] = 'Home Administrator';
		render('admin/home',$data);
	}

	function master_divisi()
	{
		$data['title'] = 'Master Divisi';
		$data['divisi'] = $this->db->query('
			SELECT
			a.*,
			b.id_profile,
			b.nama_divisi,
			b.email_divisi,
			b.no_telp,
			b.foto_divisi,
			b.lastupdate
			FROM tbl_divisi a
			LEFT JOIN tbl_profile_divisi b
			ON a.id_divisi = b.id_divisi
		')->result();

		render('admin/master_divisi',$data);
	}

	function cek_username()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$username = $this->input->post('arg');
			if ($username != '')
			{
				$cek = $this->db->get_where('tbl_divisi', 'username = "'.$username.'"');
				if ($cek->num_rows() > 0)
				{
					// http_response_code(204);
					echo json_encode(array('result' => 'not', ));
				}
				else
				{
					http_response_code(200);
					echo json_encode(array('result' => 'oke', ));
				}
			}
		}
		else
		{
			http_response_code(404);
		}
	}


	function tambah_divisi()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$id_divisi = rand(1,9999999);
			$nama = $this->input->post('divisi');
			$email = $this->input->post('email');
			$notelp = $this->input->post('notelp');

			$username = $this->input->post('username');
			$password = encrypt(md5($username.'1234'));

			$data_profile = array(
				'id_divisi' => $id_divisi, 
				'nama_divisi' => $nama, 
				'email_divisi' => $email, 
				'no_telp' => $notelp, 
			);

			$data_login = array(
				'id_divisi' => $id_divisi, 
				'username' => $username, 
				'password' => $password, 
				'flag_aktif' => 'Y', 
			);

			$cek = $this->db->get_where('tbl_profile_divisi', 'nama_divisi = "'.$nama.'"');
			if ($cek->num_rows() == 0)
			{
				$insert_login = $this->db->insert('tbl_divisi', $data_login);
				if ($insert_login)
				{
					$this->db->insert('tbl_profile_divisi', $data_profile);
					$this->session->set_flashdata('notif', '<script>swal("Berhasil","Data Divisi '.$nama.' berhasil ditambahkan 😎<br>Username = '.$username.'<br>Password = '.$username.'1234","success")</script>');
					redirect('m-divisi');
				}
			}
			else
			{
				$this->db->insert('tbl_profile_divisi', $data_profile);
				$this->session->set_flashdata('notif', '<script>swal("Gagal","Data Divisi '.$nama.' sudah ada 😥","error")</script>');
				redirect('m-divisi');
			}
		}
		else
		{
			http_response_code(404);
		}
	}

	function hapus_divisi()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$id_divisi = decrypt($this->input->post('arg'));
			$del = $this->db->delete('tbl_divisi',array('id_divisi' => $id_divisi,));
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

	function master_lowongan()
	{
		$this->load->model('ModelLowongan','m_lowongan');
		$data['title'] = 'Data Lowongan';
		$data['lowongan'] = $this->m_lowongan->get_lowongan();
		render('admin/master_lowongan',$data);
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

	function acc_lowongan()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$id_lowongan = decrypt($this->input->post('arg'));
			
			$update = $this->db->update('tbl_lowongan',array('flag_aktif' => 'Y', ),array('id_lowongan' => $id_lowongan,));
			if ($update)
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
		$data['lamaran'] = $this->db->get('view_lamaran')->result();
		render('admin/lamaran',$data);
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

				$this->load->view('admin/data_pelamar', $data);
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
					$update = $this->db->update('tbl_lamaran', array('flag_berkas' => $flag, ),array('id_lamaran' => $id_lamaran, ));
					if ($update)
					{
						$pesan = "
							
							Selamat !! 
							Anda Lolos Ditahap Berkas !! ✅
							Lamaran : $lamaran->judul_lowongan
							Divisi  : $lamaran->nama_divisi

						";
						$res = sendMessage($pesan,$id_telegram);
					}
				}
				else 
				{
					$update = $this->db->update('tbl_lamaran', array('flag_berkas' => 'T','flag_tes'=>'T','flag_aktif' =>'N'),array('id_lamaran' => $id_lamaran, ));
					if ($update)
					{
						$pesan = "
							
							Maaf !! 
							Anda Belum Lolos 🥺
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
			$cek = $this->db->get_where('tbl_admin', 'id_admin = "'.$this->session->userdata('id_admin').'" AND password = "'.encrypt(md5($old)).'"');
			if ($cek->num_rows() > 0)
			{
				$this->db->update('tbl_admin', array('password' => encrypt(md5($new))),array('id_admin' => $this->session->userdata('id_admin'), ));
				$this->session->set_flashdata('notif', '<script>swal("Berhasil","Password Berhasil Diubah","success")</script>');
				redirect('homemin');
			}
			else
			{
				$this->session->set_flashdata('notif', '<script>swal("Opss","Password Lama Salah","warning")</script>');
				redirect('homemin');
			}
		}
		else
		{
			http_response_code(404);
		}
	}
}

/* End of file Admin.php */
/* Location: ./application/controllers/Admin.php */