<?php
/**
* 
*/
class Home extends CI_Controller
{
	
	function __construct(argument)
	{
		parent::__construct();
		$this->load->model(['ModelBuku', 'ModelUser', 'ModelBooking']);
	}
	public function index()
	{$data = [
		'judul' => "Katalog Buku",
		'buku' => $this->ModelBuku->getBuku()->result(),];
	//jika sudah login dan jika belum login 
		if ($this->session->userdata('email')) {
		 $user = $this->ModelUser->cekData(['email' => $this->session->userdata('email')])->row_array(); 
		 $data['user'] = $user['nama']; 
		 $this->load->view('templates/templates-user/header', $data); 
		 $this->load->view('buku/daftarbuku', $data); 
		 $this->load->view('templates/templates-user/modal'); 
		 $this->load->view('templates/templates-user/footer', $data); } else {
		  $data['user'] = 'Pengunjung';
		   $this->load->view('templates/templates-user/header', $data); 
		   $this->load->view('buku/daftarbuku', $data); 
		   $this->load->view('templates/templates-user/modal'); 
		   $this->load->view('templates/templates-user/footer', $data); }
}