<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Tracking extends MX_Controller {
	function __construct(){
		parent::__construct();
		$this->load->helper("front");
		$this->load->model("front_model",'fm');
		$this->load->model('M_admin_kamar','mk');
        $this->load->model('M_admin_kamar_detail','md');
	}

	public function index($token = null)
    {
        if (!$token) show_404();

        $kamar = $this->db->from('kamar')->where('qr_token',$token)->get()->row();
        if (!$kamar) show_404();

        $tahanan = $this->db->from('kamar_tahanan')->where('id_kamar',$kamar->id_kamar)->order_by('nama','asc')->get()->result();
        $data["title"] = "Data Tahanan";
		$data["deskripsi"] = "Data Tahanan";
		$data["prev"] = base_url("assets/images/track.png");
		$data["rec"] = $this->fm->web_me();
        $data['kamar']   = $kamar;
        $data['tahanan'] = $tahanan;
        $data['title']   = 'Data Kamar - '.$kamar->nama;

        $this->load->view('kamar_scan_view', $data);
    }

 //    function index(){
	// 	$data["title"] = "Data Tahanan";
	// 	$data["deskripsi"] = "Data Tahanan";
	// 	$data["prev"] = base_url("assets/images/track.png");
	// 	$data["rec"] = $this->fm->web_me();
	// 	$this->load->view('tracking_view',$data);

	// }

	public function cek()
	{
		$no = $this->input->post('no_registrasi');
		$query = $this->db->get_where('view_semua_paket', ['id_pemohon' => $no]);

		if ($query->num_rows() > 0) {
			$row = $query->row();
			$update_time = explode(" ", $row->update_time);
        // Mengirim status sebagai angka untuk diproses di frontend
        $status = (int) $row->status;  // Pastikan status adalah angka
        $update_time_arr = explode(" ", $row->update_time);
		$update_time_formatted = $update_time_arr[0] . ' ' . $update_time_arr[1]; // <--- fix di sini
		$this->db->select('master_dusun.nama_dusun, lokasi.desa, lokasi.kecamatan, lokasi.kota');
		$this->db->from('master_dusun');
		$this->db->join('lokasi', 'lokasi.id_desa = master_dusun.id_desa');
		$this->db->where('master_dusun.id_dusun', $row->id_dusun);
		$query = $this->db->get();
		$this->db->where('nama_tabel', $row->asal_tabel);
		$this->db->select("ket");
		$query_ket = $this->db->get("master_permohonan")->row();
		if (!empty($query_ket)) {
			$key = $query_ket->ket;
		}
		// echo $this->db->last_query();
		$alamak = $row->alamat;
		if ($query->num_rows() > 0) {
			$result = $query->row();
			$alamak = $alamak . "<br>Dusun " . $result->nama_dusun .
			" Desa " . ucwords(strtolower($result->desa)) .
			" Kecamatan " . ucwords(strtolower($result->kecamatan)) .
			" " . ucwords(strtolower($result->kota));
			$kantor = " Desa " . ucwords(strtolower($result->desa)) .
			" Kecamatan " . ucwords(strtolower($result->kecamatan)) .
			" " . ucwords(strtolower($result->kota));
		}
		echo json_encode([
			'status' => true,
			'data' => [
				'nama' => $row->nama,
				'nik' => $row->nik,
				'no_kk' => $row->no_kk,
				'tgl_permohonan' => hari($row->create_date).", ".tgl_indo($row->create_date)." ".$row->create_time,
				'nama_permohonan' => $row->nama_permohonan,
				'ket' => $key,
				'deskripsi' => "Permohonan ".$row->deskripsi,
				'durasi' => hitungLamaProses($row->create_date, $row->create_time, $update_time_formatted),
				'update_time' => hari($update_time_arr[0]).", ".tgl_indo($update_time_arr[0]) . " " . $update_time_arr[1],
				'status' => $status, 
				'alamat' => $alamak,
				'kantor' => $kantor,
                'alasan_penolakan' => $row->alasan_penolakan 
            ]
        ]);
	} else {
		echo json_encode(['status' => false]);
	}
	// echo $this->db->last_query();
}



}
