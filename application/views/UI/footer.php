				</div>
				<!-- /.container-fluid -->

			</div>
			<!-- End of Main Content -->

			<!-- Footer -->
			<footer class="sticky-footer bg-white">
				<div class="container my-auto">
					<div class="copyright text-center my-auto">
						<span>Copyright &copy; Juan Camilo Sepúlveda Montoya <?= date('Y') ?></span>
					</div>
				</div>
			</footer>
			<!-- End of Footer -->

		</div>
		<!-- End of Content Wrapper -->

	</div>
	<!-- End of Page Wrapper -->

	<!-- Scroll to Top Button-->
	<a class="scroll-to-top rounded" href="#page-top">
		<i class="fas fa-angle-up"></i>
	</a>

	<!-- Logout Modal-->
	<div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
		aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">¿Quieres cerrar la sesión de <?= $this->session->userdata('Nombre') ?>?</h5>
					<button class="close" type="button" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">×</span>
					</button>
				</div>
				<div class="modal-body">¿Está completamente seguro de finalizar la sección actual?</div>
				<div class="modal-footer">
					<button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
					<button class="btn btn-primary" type="button" id="btnCerrarSesion">Cerrar Sesión</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap core JavaScript-->
	<script src="<?= base_url('assets/js/jquery.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/vendor/bootstrap/js/bootstrap.bundle.min.js') ?>"></script>

	<!-- Core plugin JavaScript-->
	<script src="<?= base_url('assets/js/vendor/jquery-easing/jquery.easing.min.js') ?>"></script>

	<script type="text/javascript">
		function base_url(){
			return "<?= base_url() ?>";
		}
	</script>

	<!-- Custom scripts for all pages-->
	<script src="<?= base_url('assets/js/sb-admin-2.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/global.js') ?>"></script>

	<!-- Page level plugins -->
	<script src="<?= base_url('assets/js/jquery.dataTables.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/dataTables.bootstrap4.min.js') ?>"></script>

	<script src="<?= base_url('assets/js/datatables/dataTables.buttons.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/datatables/jszip.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/datatables/pdfmake.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/datatables/vfs_fonts.js') ?>"></script>
	<script src="<?= base_url('assets/js/datatables/buttons.html5.min.js') ?>"></script>
	<script src="<?= base_url('assets/js/datatables/buttons.print.min.js') ?>"></script>

	<script src="<?= base_url('assets/js/alertify.min.js') ?>"></script>

	<?php
	if (count($js_adicional) > 0) {
		foreach ($js_adicional as $value) {
			?>
			<script src="<?= base_url('assets/js/'.$value) ?> "></script>
			<?php
		}
	}
	?>

</body>

</html>