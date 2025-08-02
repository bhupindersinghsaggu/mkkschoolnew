<div class="modal fade" id="add-stock">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<div class="page-title">
					<h4>Add Stock</h4>
				</div>
				<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form action="https://dreamspos.dreamstechnologies.com/html/template/index.html">
				<div class="modal-body">
					<div class="row">
						<div class="col-lg-12">
							<div class="mb-3">
								<label class="form-label">Warehouse <span class="text-danger ms-1">*</span></label>
								<select class="select">
									<option>Select</option>
									<option>Lobar Handy</option>
									<option>Quaint Warehouse</option>
								</select>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="mb-3">
								<label class="form-label">Store <span class="text-danger ms-1">*</span></label>
								<select class="select">
									<option>Select</option>
									<option>Selosy</option>
									<option>Logerro</option>
								</select>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="mb-3">
								<label class="form-label">Responsible Person <span
										class="text-danger ms-1">*</span></label>
								<select class="select">
									<option>Select</option>
									<option>Steven</option>
									<option>Gravely</option>
								</select>
							</div>
						</div>
						<div class="col-lg-12">
							<div class="search-form mb-0">
								<label class="form-label">Product <span class="text-danger ms-1">*</span></label>
								<input type="text" class="form-control" placeholder="Select Product">
								<i data-feather="search" class="feather-search"></i>
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-md btn-dark me-2" data-bs-dismiss="modal">Cancel</button>
					<button type="submit" class="btn btn-md btn-primary">Add Stock</button>
				</div>
			</form>
		</div>
	</div>
</div>
<!-- /Add Stock -->

<!-- jQuery -->
<script src="../assets/js/jquery-3.7.1.min.js" type="baf560cacd13bfb28c23b3e3-text/javascript"></script>
<!-- Feather Icon JS -->
<script src="../assets/js/feather.min.js" type="baf560cacd13bfb28c23b3e3-text/javascript"></script>
<!-- Slimscroll JS -->
<script src="../assets/js/jquery.slimscroll.min.js" type="baf560cacd13bfb28c23b3e3-text/javascript"></script>
<!-- Bootstrap Core JS -->
<script src="../assets/js/bootstrap.bundle.min.js" type="baf560cacd13bfb28c23b3e3-text/javascript"></script>
<!-- ApexChart JS -->
<script src="../assets/plugins/apexchart/apexcharts.min.js" type="baf560cacd13bfb28c23b3e3-text/javascript"></script>
<script src="../assets/plugins/apexchart/chart-data.js" type="baf560cacd13bfb28c23b3e3-text/javascript"></script>
<!-- Chart JS -->
<script src="../assets/plugins/chartjs/chart.min.js" type="baf560cacd13bfb28c23b3e3-text/javascript"></script>
<script src="../assets/plugins/chartjs/chart-data.js" type="baf560cacd13bfb28c23b3e3-text/javascript"></script>
<!-- Daterangepikcer JS -->
<script src="../assets/js/moment.min.js" type="baf560cacd13bfb28c23b3e3-text/javascript"></script>
<script src="../assets/plugins/daterangepicker/daterangepicker.js"
	type="baf560cacd13bfb28c23b3e3-text/javascript"></script>
<!-- Select2 JS -->
<script src="../assets/plugins/select2/js/select2.min.js" type="baf560cacd13bfb28c23b3e3-text/javascript"></script>
<!-- Color Picker JS -->
<script src="../assets/plugins/%40simonwep/pickr/pickr.es5.min.js"
	type="baf560cacd13bfb28c23b3e3-text/javascript"></script>
<!-- Custom JS -->
<script src="../assets/js/theme-colorpicker.js" type="baf560cacd13bfb28c23b3e3-text/javascript"></script>
<script src="../assets/js/script.js" type="baf560cacd13bfb28c23b3e3-text/javascript"></script>
<script src="../assets/js/rocket-loader.min.js" data-cf-settings="baf560cacd13bfb28c23b3e3-|49" defer></script>
<script defer
	src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
	integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
	data-cf-beacon='{"rayId":"95e6786a8eafa804","version":"2025.6.2","serverTiming":{"name":{"cfExtPri":true,"cfEdge":true,"cfOrigin":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"3ca157e612a14eccbb30cf6db6691c29","b":1}'
	crossorigin="anonymous"></script>
</body>

<script>
	$(document).ready(function() {
		$('#teacherSelect').select2({
			placeholder: 'Search Teacher...',
			ajax: {
				url: 'search_teacher.php',
				dataType: 'json',
				delay: 250,
				data: function(params) {
					return {
						term: params.term
					};
				},
				processResults: function(data) {
					return {
						results: data.results
					};
				},
				cache: true
			}
		});

		// Auto-fill teacher_name when one is selected
		$('#teacherSelect').on('select2:select', function(e) {
			var data = e.params.data;
			$('#teacherName').val(data.name);
		});
	});
</script>

document.getElementById('teacherSelect').addEventListener('change', function () {
const selectedOption = this.options[this.selectedIndex];
const teacherName = selectedOption.getAttribute('data-name');
document.getElementById('teacherName').value = teacherName ? teacherName : '';
});
</script>

</html>