<style type="text/css" media="screen">
	.widget-icon{
		background: #bc373c !important;
	}
	.icon{
		color: white !important;
	}
</style>
<div class="col-md-12 mb-30">
	<div class="card-box pd-20 height-100-p mb-30">
		<div class="row align-items-center">
			<div class="col-md-4">
				<img src="<?= asset() ?>vendors/images/banner-img.png" alt="" />
			</div>
			<div class="col-md-8">
				<h4 class="font-20 weight-500 mb-10 text-capitalize">
					Selamat Datang di Aplikasi Perekrutan Karyawan Online 
					<div class="weight-600 font-30 text-blue"><?php echo $this->session->userdata('nama'); ?></div>
				</h4>
				<p class="font-18">
					Perusahaan Umum Daerah Pasar Kota Manado adalah salah satu Badan Usaha Milik Daerah di Kota Manado yang menangani dan mengatur operasional Unit Usaha Perdagangan Komoditi Dasar Kebutuhan Masyarakat yang ada di Kota Manado. Seperti berbagai macam produk segar ikan, sayuran, buah-buahan, rempah dan bumbu termasuk juga berbagai keperluan rumah tangga.
				</p>
			</div>
		</div>
	</div>
</div>
<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
	<div class="card-box height-100-p widget-style3">
		<div class="d-flex flex-wrap">
			<div class="widget-data">
				<div class="weight-700 font-24 text-dark"><?= $c_divisi ?></div>
				<div class="font-14 text-secondary weight-500">
					Divisi
				</div>
			</div>
			<div class="widget-icon">
				<div class="icon" data-color="#00eccf" style="color: rgb(0, 236, 207);">
					<i class="icon-copy dw dw-apartment"></i>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
	<div class="card-box height-100-p widget-style3">
		<div class="d-flex flex-wrap">
			<div class="widget-data">
				<div class="weight-700 font-24 text-dark"><?= $c_lowongan ?></div>
				<div class="font-14 text-secondary weight-500">
					Lowongan
				</div>
			</div>
			<div class="widget-icon">
				<div class="icon" data-color="#00eccf" style="color: rgb(0, 236, 207);">
					<i class="icon-copy dw dw-certificate"></i>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
	<div class="card-box height-100-p widget-style3">
		<div class="d-flex flex-wrap">
			<div class="widget-data">
				<div class="weight-700 font-24 text-dark"><?= $c_user ?></div>
				<div class="font-14 text-secondary weight-500">
					Pelamar
				</div>
			</div>
			<div class="widget-icon">
				<div class="icon" data-color="#00eccf" style="color: rgb(0, 236, 207);">
					<i class="icon-copy dw dw-user3"></i>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="col-xl-3 col-lg-3 col-md-6 mb-20">
	<div class="card-box height-100-p widget-style3">
		<div class="d-flex flex-wrap">
			<div class="widget-data">
				<div class="weight-700 font-24 text-dark"><?= $c_lamaran ?></div>
				<div class="font-14 text-secondary weight-500">
					Lamaran
				</div>
			</div>
			<div class="widget-icon">
				<div class="icon" data-color="white" style="color: rgb(0, 0, 0);">
					<i class="icon-copy dw dw-id-card2"></i>
				</div>
			</div>
		</div>
	</div>
</div>

<div class="col-md-12">
	<div class="card-box" style="padding: 20px;">
		<div class="row">
			<div class="col-md-12 mb-30">
				<div class="title">
					<h4 style="font-size: 18px;">Riwayat Lamaran</h4>
				</div>
			</div>
			<div class="col-md-12">
				<table class="table table-hover table-striped dt " width="100%" style="width: 100%;">
					<thead>
						<tr>
							<th width="10%"><center>#</center></th>
							<th width="15%">Pelamar</th>
							<th width="15%">Lowongan</th>
							<th width="15%">Divisi</th>
							<th width="15%">Tgl Lamar</th>
							<th width="10%"><center>Berkas</center></th>
							<th width="10%"><center>Tes</center></th>
						</tr>
					</thead>
					<tbody>
						<?php if ($lamaran != null){ ?>
							<?php $no=1; foreach ($lamaran as $l){ ?>
								<tr>
									<?php if ($l->flag_aktif == 'Y'){ ?>
										
										<td><center><?= $no ?></center></td>
									<?php }else{ ?>
										<td><center><?= $no ?></center></td>
									<?php } ?>
									<td><?= $l->nama ?></td>
									<td><?= $l->judul_lowongan ?></td>
									<td><?= $l->nama_divisi ?></td>
									<td><?= date('d/m/Y H:i',strtotime($l->regdate)) ?></td>
									<td>
										<center>
											<?php if ($l->flag_berkas == 'Y'){ ?>
												<span class="badge badge-pill badge-success">Diterima</span>
											<?php }else if($l->flag_berkas == 'N'){ ?>
												<span class="badge badge-pill badge-warning" style="color: white;">Menunggu</span>
											<?php }else if($l->flag_berkas == 'T'){ ?>
												<span class="badge badge-pill badge-danger">Ditolak</span>
											<?php } ?>
										</center>
									</td>
									<td>
										<center>
											<?php if ($l->flag_tes == 'Y'){ ?>
												<span class="badge badge-pill badge-success">Lulus</span>
											<?php }else if($l->flag_tes == 'N'){ ?>
												<span class="badge badge-pill badge-warning" style="color: white;">Menunggu</span>
											<?php }else if($l->flag_tes == 'T'){ ?>
												<span class="badge badge-pill badge-danger">Tidak Lulus</span>
											<?php } ?>
										</center>
									</td>
								</tr>
							<?php $no++;} ?>
						<?php } ?>
					</tbody>
				</table>
			</div>
		</div>		
	</div>
</div>
