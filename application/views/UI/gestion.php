<?php 

	$this->load->view('UI/head');

	$this->load->view('UI/navbar');

	$this->load->view($content_view);

	$this->load->view('UI/footer');

?>