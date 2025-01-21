<div class="col-md-12 mb-30">
	<div class="card-box pd-20 height-100-p mb-30">
		<div class="row align-items-center">
			<div class="col-md-2">
				<img src="<?= asset() ?>vendors/user/<?= $this->session->userdata('foto') ?>" alt="" />
			</div>
			<div class="col-md-10">
				<h4 class="font-20 weight-500 mb-10 text-capitalize">
					Selamat Datang di Aplikasi Perekrutan Karyawan Online
					<div class="weight-600 font-30 text-blue"><?php echo $this->session->userdata('nama'); ?></div>
				</h4>
				<p class="font-18">
					Perusahaan Umum Daerah Pasar Kota Manado adalah salah satu Badan Usaha Milik
					Daerah di Kota Manado yang menangani dan mengatur operasional Unit Usaha
					Perdagangan Komoditi Dasar Kebutuhan Masyarakat yang ada di Kota Manado.
					Seperti berbagai macam produk segar ikan, sayuran, buah-buahan, rempah dan 
					bumbu termasuk juga berbagai keperluan rumah tangga.
				</p>
			</div>
		</div>
	</div>
</div>