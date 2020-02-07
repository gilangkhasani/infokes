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
		$("#nama_pasien").val("");
		$("#alamat_pasien").val("");
		$("#telepon_pasien").val("");
		$("#id_pasien").val("");
		$("#myModal").modal();
	}
	
	function update(id_pasien, title){
		$(function () {
			var fdata = {id_pasien: id_pasien};
			$('#loading_vendor_search').show();
			$.ajax({
				type:"GET",
				url: "<?php echo base_url()?>pasien/getPasien",
				dataType:'json',
				error: function (request,status, error) {
					console.log(request);
				},
				data:fdata
			}).done(function(data){
				console.log(data);
				if(data.count > 0){
					$("#defaultModalLabel").html(title);
					$("#nama_pasien").val(data.result.nama_pasien);
					$("#alamat_pasien").val(data.result.alamat_pasien);
					$("#telepon_pasien").val(data.result.telepon_pasien);
					$("#id_pasien").val(id_pasien);
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
						Data Pasien
					</h2>
					<a class="btn btn-primary btn-small" onclick="add('Tambah Data Pasien')">Tambah Data pasien</a>
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
											<td>
												<a class="btn btn-primary btn-small" onclick="update('<?php echo $result->id_pasien?>', 'Edit Data Pasien')">Edit</a>
												<a class="btn btn-danger btn-small" href="<?php echo base_url()?>pasien/delete/<?php echo $result->id_pasien?>">Delete</a>
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
<div class="modal fade" id="myModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form action="<?php echo base_url()?>pasien/save" method="post">
				<div class="modal-header">
					<h4 class="modal-title" id="defaultModalLabel"></h4>
				</div>
				<div class="modal-body">
					<div class="form-group">
						<div class="form-line">
							<b>Nama Pasien</b>
							<input type="text" class="form-control" name="nama_pasien" id="nama_pasien" placeholder="Nama Pasien" required >
						</div>
					</div>
					<div class="form-group">
						<div class="form-line">
							<b>Alamat Pasien</b>
							<textarea rows="4" class="form-control no-resize" id="alamat_pasien" name="alamat_pasien" placeholder="Alamat"></textarea>
						</div>
					</div>
					<div class="form-group">
						<div class="form-line">
							<b>Nomor Telepon Pasien</b>
							<input type="number" class="form-control" name="telepon_pasien" id="telepon_pasien" placeholder="No Telepon" required >
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<input type="hidden" class="form-control" name="id_pasien" id="id_pasien" placeholder="No Telepon" required >
					<button type="submit" class="btn btn-primary ">SAVE CHANGES</button>
					<button type="button" class="btn btn-danger " data-dismiss="modal">CLOSE</button>
				</div>
			</form>
		</div>
	</div>
</div>