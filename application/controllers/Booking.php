<?php 
defined('BASEPATH') or exit('No Direct Script Access Allowed'); date_default_timezone_set('Asia/Jakarta'); 
 
class Booking extends CI_Controller 
{     
	public function __construct() 
	  {         
	  	parent::__construct();         cek_login();         
	  	$this->load->model(['ModelBooking', 'ModelUser']);     
	  } 
 
    public function index()     
    {         
    	$id = ['bo.id_user' => $this->uri->segment(3)];         
    	$id_user = $this->session->userdata('id_user');         
    	$data['booking'] = $this->ModelBooking->joinOrder($id)->result(); 
 
        $user = $this->ModelUser->cekData(['email' => $this->session>userdata('email')])->row_array();         
        foreach ($user as $a) {             
        	$data = [                 
        		'image' => $user['image'],                 
        		'user' => $user['nama'],                 
        		'email' => $user['email'],                 
        		'tanggal_input' => $user['tanggal_input']             
        	];         
        	}         
        	$dtb = $this->ModelBooking->showtemp(['id_user' => $id_user])>num_rows(); 
 
        if ($dtb < 1) {             
        	$this->session->set_flashdata('pesan', '<div class="alert alertmassege alert-danger" role="alert">Tidak Ada Buku dikeranjang</div>');
        	             redirect(base_url());         
        	         } else {             
        	         	$data['temp'] = $this->db>query("select image, judul_buku, penulis, penerbit, tahun_terbit,id_buku from te mp where id_user='$id_user'")->result_array();         
        	         }         
        	         $data['judul'] = "Data Booking"; 
 
        $this->load->view('templates/templates-user/header', $data);         
        $this->load->view('booking/data-booking', $data);         
        $this->load->view('templates/templates-user/modal');         
        $this->load->view('templates/templates-user/footer');     
    }