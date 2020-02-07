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
			alert("Pembayaran anda sudah lunas");
		} else {
			$("#id_pendaftarans").val(id_pendaftaran);
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
						Data Pembayaran
					</h2>
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
									<th style="text-align:center; vertical-align:middle;">Nominal Pembayaran</th>
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
											<td><?php echo number_format($result->nominal_pembayaran)?></td>
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