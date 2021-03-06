<!-- page heading start-->
<div id="content">
	<div id="content-header">
		<div id="breadcrumb">
			<a href="<?php echo base_url('mastercms'); ?>" title="" class="tip-bottom" data-original-title="Go to Home">
				<i class="icon-home"></i> Home
			</a>
			<a href="#" class="current"></i></i>Profil
			</a>
		</div>
	</div>
	<div class="span12" >
		
	</div>
	<!-- page heading end-->
	<!-- body start -->
	<div class="container-fluid">
		<div class="row-fluid">
			<div class="col-md-4">
				<div class="panel">
					<div class="panel-body">
						<div class="profile-desk">
							<div class="text-center" style="width:100%;">
								<img style="width: 100%; height: auto; padding: 10px; " name="Logo Perusahaan" src="
								<?php echo base_url("assets/images/qrcode/".$detail['qr_code']); ?>">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="col-md-8">
				<div class="panel">
					<div class="panel-body">
						<div class="profile-desk">
							<div class="col-md-12" style="padding-top:10px;">
								<h3><?= $detail['lokasi_nama']; ?>
								<span class="pull-right" style="font-size: 12px; padding-bottom: 30px;">
									<span class="btn btn-warning btn-sm"><a style="color: #fff;" href="<?php echo base_url('mastercms/perusahaan/edit/').$id; ?>" title="Edit"><i class="fa fa-pencil"></i>&nbsp;Edit</a></span>&nbsp;&nbsp;
									<span class="btn btn-danger btn-sm"><a style="color: #fff;" href="<?= base_url('mastercms/perusahaan/cabang'); ?>" title="Kembali"><i class="fa fa-undo"></i>&nbsp;Kembali</a></span>
								</span>
							</h3>
							<table class="table">
								<tbody>
									<tr>
										<td>Kantor</td>
										<td>:</td>
										<td><?php echo ucwords($detail['perusahaan_title']); ?></td>
									</tr>
									<tr>
										<td style="width: 20%">Nama Perusahaan</td>
										<td style="width: 5%">:</td>
										<td><?php echo $detail['lokasi_nama']; ?></td>
									</tr>
									<tr>
										<td>Alamat</td>
										<td>:</td>
										<td><?php echo $detail['perusahaan_alamat']; ?></td>
									</tr>
									<tr>
										<td style="font-weight: bold;">Jam Kerja</td>
										<td>&nbsp;</td>
										<td colspan="2">
											<?php if (!empty($jamkerja)): ?>
												<table class="table" width="100%">
													<thead style="font-weight: bold;">
														<tr>
															<td>Hari</td>
															<td>Jam Masuk</td>
															<td>Jam Keluar</td>
														</tr>
													</thead>
													<tbody>
														<?php foreach ($jamkerja as $key => $value): ?>
															<tr>
																<td width="25%"><?= $value['kerja_hari']; ?></td>
																<td width="25%"><?= $value['jam_masuk']; ?></td>
																<td width="25%"><?= $value['jam_keluar']; ?></td>
															</tr>
														<?php endforeach ?>	
													</tbody>
												</table>
												<?php else: ?>
													<span class="btn btn-primary"><a href="<?php echo base_url('mastercms/perusahaan/add_jam_kerja/').$detail['lokasi_id']; ?>" title="Detail" style="color: white">Tambah Jam Kerja</a></span>
												<?php endif ?>
											</td>
										</tr>
									</tbody>
								</table>
								<!-- <span class="designation">MEMBE	R ID : </span> -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- body end -->
</div>