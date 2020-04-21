<?php
/**
* 
*/
class Home extends CI_Controller
{	
	function __construct()
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
		 $this->load->view('templates/templates-user/footer', $data);
		} else {
		  $data['user'] = 'Pengunjung';
		   $this->load->view('templates/templates-user/header', $data); 
		   $this->load->view('buku/daftarbuku', $data); 
		   $this->load->view('templates/templates-user/modal'); 
		   $this->load->view('templates/templates-user/footer', $data); }
}

public function detailBuku()
 {        
 	$id = $this->uri->segment(3);         
 	$buku = $this->ModelBuku->joinKategoriBuku(['buku.id' => $id])->result(); 
 
        $data['user'] = "Pengunjung";         
        $data['title'] = "Detail Buku"; 
 
        foreach ($buku as $fields) {             
            $data['judul'] = $fields->judul_buku;             
            $data['pengarang'] = $fields->pengarang;             
            $data['penerbit'] = $fields->penerbit;             
            $data['kategori'] = $fields->kategori;             
            $data['tahun'] = $fields->tahun_terbit;             
            $data['isbn'] = $fields->isbn;             
            $data['gambar'] = $fields->image;             
            $data['dipinjam'] = $fields->dipinjam;             
            $data['dibooking'] = $fields->dibooking;             
            $data['stok'] = $fields->stok;             
            $data['id'] = $id;         
        } 
 
        $this->load->view('templates/templates-user/header', $data); 
        $this->load->view('buku/detail-buku', $data);         
        $this->load->view('templates/templates-user/modal');         
        $this->load->view('templates/templates-user/footer');     
   }
}

public function logout()     
{         
	$this->session->unset_userdata('email');         
	$this->session->unset_userdata('role_id'); 
 
        
        $this->session->set_flashdata('pesan', '<div class="alert alertsuccess alert-message" role="alert">Anda telah logout!!</div>');         redirect('home');     
    } 



public function tambahBooking()     
{         
	$id_buku = $this->uri->segment(3); 
 
        //memilih data buku yang untuk dimasukkan ke tabel temp/keranjang melalui variabel $isi         
	$d = $this->db->query("Select*from buku where id='$id_buku'")->row(); 
 
        //berupa data2 yang akan disimpan ke dalam tabel temp/keranjang         
	$isi = [             
		'id_buku' => $id_buku,             
		'judul_buku' => $d->judul_buku,             
		'id_user' => $this->session->userdata('id_user'),             
		'email_user' => $this->session->userdata('email'),             
		'tgl_booking' => date('Y-m-d H:i:s'),             
		'image' => $d->image,             
		'penulis' => $d->pengarang,             
		'penerbit' => $d->penerbit,             
		'tahun_terbit' => $d->tahun_terbit         
	]; 
 
        //cek apakah buku yang di klik booking sudah ada di keranjang 

	  $temp = $this->ModelBooking>getDataWhere('temp', ['id_buku' => $id_buku])->num_rows(); 
 
        $userid = $this->session->userdata('id_user'); 
 
        //cek jika sudah memasukan 3 buku untuk dibooking dalam keranjang         
        $tempuser = $this->db>query("select*from temp where id_user ='$userid'")->num_rows(); 
 
        //cek jika masih ada booking buku yang belum diambil         
        $databooking = $this->db>query("select*from booking where id_user='$userid'")->num_rows();         
        if ($databooking > 0) {             
        	$this->session->set_flashdata('pesan', '<div class="alert alertdanger alertmessage" role="alert">Masih Ada booking buku sebelumnya yang belum diambil.<br> A bmil Buku yang dibooking atau tunggu 1x24 Jam untuk bisa booking kembali </div>') ;             
        	redirect(base_url());         
        } 
 
        //jika buku yang diklik booking sudah ada di keranjang          
        if ($temp > 0) {             
        	$this->session->set_flashdata('pesan', '<div class="alert alertdanger alert-message" role="alert">Buku ini Sudah anda booking </div>');             
        	redirect(base_url() . 'home');         
        } 
 
        //jika buku yang akan dibooking sudah mencapai 3 item         
        if ($tempuser == 3) {             
        	$this->session->set_flashdata('pesan', '<div class="alert alertdanger alert-message" role="alert">Booking Buku Tidak Boleh Lebih dari 3</div>');             
        	redirect(base_url() . 'home');         
        } 
 
        //membuat tabel temp jika belum ada         
        $this->ModelBooking->createTemp();         
        $this->ModelBooking->insertData('temp', $isi); 
 
        //pesan ketika berhasil memasukkan buku ke keranjang         
        $this->session->set_flashdata('pesan', '<div class="alert alertsuccess alertmessage" role="alert">Buku berhasil ditambahkan ke keranjang </div>');         
        redirect(base_url() . 'home');     
    } 