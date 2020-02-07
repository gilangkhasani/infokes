<script>
	$(function () {
		//Exportable table
		$('.js-exportable').DataTable({
			dom: 'Bfrtip',
			responsive: true,
			buttons: [
				'copy', 'csv', 'excel', 'pdf', 'print'
			]
		});
		
    });
	
	function add(title){
		$("#defaultModalLabel").html(title);
		$("#id_pasien").val("");
		$("#tanggal_pendaftaran").val("");
		$("#keluhan").val("");
		$("#myModal").modal();
	}
	
	function bayar(id_pendaftaran, status){
		if(status === 'Batal'){
			alert("Maaf anda tidak bisa melakukan karena pembayaran karena status anda sudah batal. terima kasih");
		} else if(status === 'Lunas') {
			alert("Pembayaran anda sudah lunas, Terima kasih :D");
		} else {
			$(".id_pendaftarans").val(id_pendaftaran);
			$("#myModalPembayaran").modal();
		}
	}
	
	function update(id_pendaftaran, title){
		$(function () {
			var fdata = {id_pendaftaran: id_pendaftaran};
			$('#loading_vendor_search').show();
			$.ajax({
				type:"GET",
				url: "<?php echo base_url()?>pendaftaran/getPendaftaran",
				dataType:'json',
				error: function (request,status, error) {
					console.log(request);
				},
				data:fdata
			}).done(function(data){
				console.log(data);
				if(data.count > 0){
					$("#defaultModalLabel").html(title);
					$("#id_pasien").val(data.result.id_pasien);
					$("#tanggal_pendaftaran").val(data.result.tanggal_pendaftaran);
					$("#keluhan").val(data.result.keluhan);
					$("#id_pendaftaran").val(id_pendaftaran);
					$("#myModal").modal();
				} else {
					alert(data.msg);
				}
			}).fail(function(data){
				console.log(data);
				//alert("terjadi kesalahan, silahkan refresh ulang");
			});
			
		});
	}
</script>
<div class="container-fluid">
	<!-- Basic Examples -->
	<div class="row clearfix">
		<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
			<div class="card">
				<div class="header">
					<h2>
						Data Pendaftaran
					</h2>
					<a class="btn btn-primary btn-small" onclick="add('Tambah Data Pendaftaran')">Tambah Data Pendaftaran</a>
					<p><?php echo $this->session->flashdata('notify');?></p>
				</div>
				<div class="body">
					<div class="table-responsive">
						<table class="table table-bordered table-striped table-hover js-exportable dataTable">
							<thead>
								<tr>
									<th style="text-align:center; vertical-align:middle;">Nama</th>
									<th style="text-align:center; vertical-align:middle;">Alamat</th>
									<th style="text-align:center; vertical-align:middle;">No Telepon</th>
									<th style="text-align:center; vertical-align:middle;">Tanggal Pendaftaran</th>
									<th style="text-align:center; vertical-align:middle;">Keluhan</th>
									<th style="text-align:center; vertical-align:middle;">Status</th>
									<th style="text-align:center;vertical-align:middle;">Action</th>
								</tr>
							</thead>
							<tbody>
								<?php
									foreach($result as $result){
								?>
										<tr>
											<td><?php echo $result->nama_pasien?></td>
											<td><?php echo $result->alamat_pasien?></td>
											<td><?php echo $result->telepon_pasien?></td>
											<td><?php echo $result->tanggal_pendaftaran?></td>
											<td><?php echo $result->keluhan?></td>
											<td><?php echo $result->status_pendaftaran?></td>
											<td>
												<a class="btn btn-danger btn-small" href="<?php echo base_url()?>pendaftaran/batal/<?php echo $result->id_pendaftaran?>">Batal</a>
												<a class="btn btn-success btn-small" onclick="bayar('<?php echo $result->id_pendaftaran?>', '<?php echo $result->status_pendaftaran?>')">Bayar Layanan</a>
											</td>
										</tr>
								<?php
									}
								?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- Default Size -->
<div class="modal fade" id="myModalPembayaran" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="<?php echo base_url()?>pembayaran/save" method="post">
				<div class="modal-header">
					<h4 class="modal-title" id="defaultModalLabel">Pembayaran Layanan</h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<div class="form-line">
							<b>ID Pendaftaran</b>
							<input type="text" class="form-control id_pendaftarans" name="id_pendaftaran" id="id_pendaftarans" placeholder="ID Pendaftaran" required disabled >
							<input type="hidden" class="form-control id_pendaftarans" name="id_pendaftaran" id="id_pendaftarans" placeholder="ID Pendaftaran" required >
						</div>
					</div>
					<div class="form-group">
						<div class="form-line">
							<b>Jumlah Pembayaran</b>
							<input type="number" class="form-control" name="nominal_pembayaran" required >
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary ">SAVE CHANGES</button>
					<button type="button" class="btn btn-danger " data-dismiss="modal">CLOSE</button>
				</div>
			</form>
		</div>
	</div>
</div>
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="<?php echo base_url()?>pendaftaran/save" method="post">
				<div class="modal-header">
					<h4 class="modal-title" id="defaultModalLabel"></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<div class="form-line">
							<b>Nama Pasien</b>
							<select id="id_pasien" name="id_pasien" required class="form-control show-tick">
								<option value="">-- Nama Pasien --</option>
								<?php 
									foreach($pasien as $result){
								?>
										<option value="<?php echo $result->id_pasien?>"><?php echo $result->nama_pasien?></option>
								<?php
									}
								?>
							</select>
						</div>
					</div>
					<div class="form-group">
						<div class="form-line">
							<b>Tanggal Pendaftaran</b>
							<input type="date" class="form-control" name="tanggal_pendaftaran" id="tanggal_pendaftaran" value="<?php echo date('Y-m-d')?>" placeholder="Tanggal Pendaftaran" required >
						</div>
					</div>
					<div class="form-group">
						<div class="form-line">
							<b>Keluhan</b>
							<input type="text" class="form-control" name="keluhan" id="keluhan" placeholder="Keluhan" required >
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" class="form-control" name="id_pendaftaran" id="id_pendaftaran" placeholder="id_pendaftaran" required >
					<button type="submit" class="btn btn-primary ">SAVE CHANGES</button>
					<button type="button" class="btn btn-danger " data-dismiss="modal">CLOSE</button>
				</div>
			</form>
		</div>
	</div>
</div>