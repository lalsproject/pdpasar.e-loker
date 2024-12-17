<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class LoginDivisi extends CI_Controller {

	public function __construct()
	{
		parent::__construct();

	}

	public function index()
	{
		if ($this->session->userdata('is_login') != true AND $this->session->userdata('role') != 'User')
		{
			$this->load->view('login_divisi');
		}
		else
		{
			$not = '
				<script>
					swal({
						type: "success",
						title: "Selamat Datang Kembali <br>'.$this->session->userdata('nama').'",
						text: "Tanggal '.date('d/m/Y').'",
						icon: "success",
						confirmButtonText: "Tutup"
					})

				</script>';
			$this->session->set_flashdata('notif', $not);
			redirect('home');
		}
	}

	function proses_login()
	{
		if ($this->input->server('REQUEST_METHOD') == 'POST')
		{
			$salah = '<script>
			swal({
					type: "error",
					title: "Ops",
					text: "Username & Password Salah, atau anda tidak terdaftar!",
					icon: "error",
					confirmButtonText: "Tutup"
				})

			</script>';

			$username = $this->input->post('username');
			$password = $this->input->post('password');


			$where = array(
				'username' =>$username,
				'password' =>encrypt(md5($password)),  
				'flag_aktif' => 'Y'  
			);

			$status = array(
				'lastlogin' =>  date('Y-m-d H:i:s'),
			);

			$cek = $this->db->get_where('tbl_divisi',$where);
			if ($cek->num_rows() > 0)
			{
				$cs = $cek->row();
				$pr = $this->db->get_where('tbl_profile_divisi','id_divisi = "'.$cs->id_divisi.'"')->row();

				$welcome = '
					<script>
						swal({
							type: "success",
							title: "Selamat Datang <br>'.$pr->nama_divisi.'",
							text: "Tanggal '.date('d/m/Y').'",
							icon: "success",
							confirmButtonText: "Tutup"
						})

					</script>'; 

				$data_session = array(
					'is_login' => true,
					'id_divisi' => $cs->id_divisi,
					'username' => $cs->username,
					'nama' => $pr->nama_divisi,
					'lastlogin' => $cs->lastlogin,
					'foto' => $pr->foto_divisi,
					'role' => 'Divisi'
				);

				$this->db->update('tbl_divisi', $status, $where);
				$this->session->set_userdata($data_session);
				$this->session->set_flashdata('notif', $welcome);
				redirect('homediv');
			}
			else
			{
				$this->session->set_flashdata('gagal', $salah);
				redirect('authdiv');
			}
		}
		else
		{
			http_response_code(404);
		}
	}

	function logout()
	{
		$this->session->sess_destroy();
		redirect('authdiv');
	}

}

/* End of file LoginDivisi.php */
/* Location: ./application/controllers/LoginDivisi.php */