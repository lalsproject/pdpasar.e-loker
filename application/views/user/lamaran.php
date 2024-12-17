<div class="col-md-12 mb-30">
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
							<th width="15%">Lowongan</th>
							<th width="15%">Divisi</th>
							<th width="15%">Tgl Lamar</th>
							<th width="15%"><center>Status Berkas</center></th>
							<th width="15%"><center>Status Tes</center></th>
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