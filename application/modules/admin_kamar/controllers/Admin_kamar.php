<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_kamar extends Admin_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('M_admin_kamar', 'dm');
        cek_session_akses(get_class($this), $this->session->userdata('admin_session'));
        $this->load->helper(['url','string']);
    }

    public function index(){
        $data["controller"] = get_class($this);
        $data["title"]      = "Master Kamar Tahanan";
        $data["subtitle"]   = $this->om->engine_nama_menu(get_class($this));
        $data["content"]    = $this->load->view("Admin_kamar_view", $data, true);
        $this->render($data);
    }

    /** DataTables server-side */
    public function get_data()
    {
        $list = $this->dm->get_data();
        $data = [];
        foreach ($list as $r) {
            $row = [];

            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single">'
                        . '<input type="checkbox" class="data-check" value="'.(int)$r->id_kamar.'"><label></label>'
                        . '</div>';

            $row['no']  = ''; // isi di rowCallback

            $nama = htmlspecialchars($r->nama, ENT_QUOTES, 'UTF-8');
            $blok = htmlspecialchars($r->blok, ENT_QUOTES, 'UTF-8');
            $info = $blok ? $nama.'<br><small class="text-muted">Blok: '.$blok.'</small>' : $nama;
            $row['nama'] = $info;

            $row['kapasitas'] = (int)$r->kapasitas;
            $row['terisi']    = (int)$r->jumlah_tahanan;

            $statusBadge = $r->status === 'aktif'
                ? '<span class="badge badge-success">Aktif</span>'
                : '<span class="badge badge-secondary">Nonaktif</span>';
            $row['status'] = $statusBadge;
            // tombol QR
            $qrBtn = $r->qr_url
                ? '<a href="'.htmlspecialchars(site_url(strtolower(get_class($this)).'/cetak_qr/'.(int)$r->id_kamar), ENT_QUOTES, 'UTF-8').'" target="_blank" class="btn btn-outline-dark btn-sm">
                     <i class="fe-printer"></i> QR
                   </a>'
                : '<button type="button" class="btn btn-outline-secondary btn-sm" disabled>
                     <i class="fe-printer"></i> QR
                   </button>';

            // tombol lain
            $btnEdit = '<button type="button" class="btn btn-warning btn-sm" onclick="edit('.(int)$r->id_kamar.')">
                          <i class="fe-edit"></i> Edit
                        </button>';

            $btnDetail = '<a href="'.site_url('admin_kamar_detail/index/'.(int)$r->id_kamar).'" class="btn btn-primary btn-sm">
                            <i class="fe-users"></i> Tahanan
                          </a>';

            $btnLihat = '<a href="'.site_url('tracking/index/'.$r->qr_token).'" class="btn btn-blue btn-sm" target="_blank">
                           <i class="fe-eye"></i> Lihat
                         </a>';

            // dibungkus supaya sejajar
            $row['aksi'] =
                '<div class="btn-group btn-group-sm" role="group" aria-label="Aksi kamar">'.
                    $btnEdit.
                    $btnDetail.
                    $qrBtn.
                    $btnLihat.
                '</div>';


            $data[] = $row;
        }

        $out = [
            "draw"            => (int)$this->input->post('draw'),
            "recordsTotal"    => $this->dm->count_all(),
            "recordsFiltered" => $this->dm->count_filtered(),
            "data"            => $data,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($out));
    }

    /** Ambil satu kamar */
    public function get_one($id)
    {
        $id  = (int)$id;
        $row = $this->dm->get_by_id($id);
        if (!$row) {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Data tidak ditemukan"]);
            return;
        }
        echo json_encode(["success"=>true,"data"=>$row]);
    }

    /** Create kamar + generate QR & token */
    public function add()
    {
        $data = $this->input->post(NULL, TRUE);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('nama','Nama Kamar','trim|required|min_length[3]|max_length[100]');
        $this->form_validation->set_rules('blok','Blok','trim|max_length[50]');
        $this->form_validation->set_rules('lantai','Lantai','trim|max_length[20]');
        $this->form_validation->set_rules('kapasitas','Kapasitas','trim|required|integer');
        $this->form_validation->set_rules('keterangan','Keterangan','trim|max_length[500]');

        $this->form_validation->set_message('required','* %s harus diisi');
        $this->form_validation->set_message('integer','* %s harus angka');
        $this->form_validation->set_error_delimiters('<br> ',' ');

        if ($this->form_validation->run() !== TRUE) {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>validation_errors()]);
            return;
        }

        // Token acak dan unik
        $token = $this->_generate_unique_token();

        // URL scan kamar pakai token → susah dihafal
        $scan_url = site_url('tracking/index/'.$token);

        // generate QR
        $qr_url = $this->_make_qr($scan_url, true);

        $ins = [
            'nama'       => $data['nama'],
            'blok'       => $data['blok'] ?? null,
            'lantai'     => $data['lantai'] ?? null,
            'kapasitas'  => (int)$data['kapasitas'],
            'keterangan' => $data['keterangan'] ?? null,
            'qr_token'   => $token,
            'qr_url'     => $qr_url,
            'status'     => $data['status'] ?? 'aktif',
        ];

        $res = $this->db->insert('kamar',$ins);
        if ($res) {
            echo json_encode(["success"=>true,"title"=>"Berhasil","pesan"=>"Kamar berhasil disimpan"]);
        } else {
            echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Kamar gagal disimpan"]);
        }
    }

    /** Update kamar (QR & token tidak diubah) */
   public function update()
{
    $data = $this->input->post(NULL, TRUE);
    $id   = (int)($data['id_kamar'] ?? 0);

    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_kamar','ID','required|integer');
    $this->form_validation->set_rules('nama','Nama Kamar','trim|required|min_length[3]|max_length[100]');
    $this->form_validation->set_rules('blok','Blok','trim|max_length[50]');
    $this->form_validation->set_rules('lantai','Lantai','trim|max_length[20]');
    $this->form_validation->set_rules('kapasitas','Kapasitas','trim|required|integer');
    $this->form_validation->set_rules('keterangan','Keterangan','trim|max_length[500]');
    $this->form_validation->set_rules('status','Status','trim|required');

    $this->form_validation->set_message('required','* %s harus diisi');
    $this->form_validation->set_error_delimiters('<br> ',' ');

    if ($this->form_validation->run() !== TRUE) {
        echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>validation_errors()]);
        return;
    }

    $row = $this->dm->get_by_id($id);
    if (!$row) {
        echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Data tidak ditemukan"]);
        return;
    }

    // ========== TEST-QR: regen token + QR setiap UPDATE (hapus blok ini kalau sudah tidak perlu) ==========
    // $token    = $this->_generate_unique_token();
    // $scan_url = site_url('tracking/index/'.$token);
    // $qr_url   = $this->_make_qr($scan_url, true);
    // ========== END TEST-QR ==========================================================================

    $upd = [
        'nama'       => $data['nama'],
        'blok'       => $data['blok'] ?? null,
        'lantai'     => $data['lantai'] ?? null,
        'kapasitas'  => (int)$data['kapasitas'],
        'keterangan' => $data['keterangan'] ?? null,

        // ========== TEST-QR: simpan token & QR baru ==========
        // 'qr_token'   => $token,
        // 'qr_url'     => $qr_url,
        // ========== END TEST-QR ==============================

        // kalau nanti blok TEST-QR dihapus, ini bisa balik ke:
        'qr_token' => $row->qr_token,
        'qr_url'   => $row->qr_url,

        'status'     => $data['status'] ?? $row->status,
        'updated_at' => date('Y-m-d H:i:s'),
    ];

    $res = $this->db->where('id_kamar',$id)->update('kamar',$upd);

    if ($res) {
        echo json_encode(["success"=>true,"title"=>"Berhasil","pesan"=>"Data berhasil diupdate"]);
    } else {
        echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Data gagal diupdate"]);
    }
}

    /** Delete (bulk) */
    public function hapus_data()
{
    $ids = $this->input->post('id'); // bisa array atau single

    if (!$ids) {
        echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Tidak ada data dikirim"]);
        return;
    }

    // kalau single value (string/int), jadikan array
    if (!is_array($ids)) {
        $ids = [$ids];
    }

    // casting ke integer + filter yang valid
    $idInts = [];
    foreach ($ids as $id) {
        $id = (int)$id;
        if ($id > 0) $idInts[] = $id;
    }

    if (!$idInts) {
        echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Tidak ada data valid"]);
        return;
    }

    // hapus sekaligus pakai where_in
    $this->db->where_in('id_kamar', $idInts);
    $ok  = $this->db->delete('kamar');
    $err = $this->db->error();
    $aff = $this->db->affected_rows();

    if ($err['code'] != 0) {
        echo json_encode([
            "success"=>false,
            "title"=>"Gagal",
            "pesan"=>"Query delete gagal. Kode: {$err['code']} - {$err['message']}"
        ]);
        return;
    }

    if (!$ok || $aff === 0) {
        echo json_encode([
            "success"=>false,
            "title"=>"Gagal",
            "pesan"=>"Tidak ada data yang dihapus"
        ]);
        return;
    }

    echo json_encode([
        "success"=>true,
        "title"=>"Berhasil",
        "pesan"=>"Data berhasil dihapus ($aff baris)"
    ]);
}


    /** Cetak QR poster */
    public function cetak_qr($id)
    {
        $id  = (int)$id;
        $row = $this->dm->get_by_id($id);
        if (!$row) show_404();

        $data['row']    = $row;
        $data['qr_url'] = $row->qr_url;
        $this->load->view('Admin_kamar_qr_print', $data);
    }

    /** Generate token unik */
    private function _generate_unique_token($length = 32)
    {
        $token = '';
        do {
            $token = random_string('alnum', $length);
            $exists = $this->db->where('qr_token',$token)->count_all_results('kamar');
        } while ($exists > 0);
        return $token;
    }

    /** Buat QR (copy dari snippet kamu, hanya nama param diganti) */
   private function _make_qr($data, $with_logo = true)
{
    $this->load->library('ciqrcode');
    $dir = './uploads/qr/';
    if (!is_dir($dir)) {
        @mkdir($dir, 0755, true);
    }

    // pakai hash supaya unik & pendek
    $hash = md5($data);
    $file = 'qr_kamar_'.$hash.'.png';

    $this->ciqrcode->generate([
        'data'     => $data,
        'level'    => 'H',
        'size'     => 10,
        'savename' => $dir.$file
    ]);

    if ($with_logo) {
        $logo_path = FCPATH.'assets/images/logo.png';
        if (is_file($logo_path)) {
            // overlay logo PENUH WARNA di tengah QR
            $this->_qr_overlay_logo($dir.$file, $logo_path, 0.22, false);
        }
    }

    return base_url('uploads/qr/'.$file);
}

/**
 * Overlay logo ke tengah QR (logo tetap BERWARNA)
 */
private function _qr_overlay_logo($qr_path, $logo_path, $scale = 0.22, $save_as_new = false)
{
    if (!is_file($qr_path) || !is_file($logo_path)) return;

    // load gambar
    $qr   = imagecreatefrompng($qr_path);
    $logo = imagecreatefrompng($logo_path);

    // pastikan keduanya truecolor supaya warna logo tidak jadi abu-abu
    if (function_exists('imagepalettetotruecolor')) {
        imagepalettetotruecolor($qr);
        imagepalettetotruecolor($logo);
    }

    // jaga alpha di QR
    imagealphablending($qr, true);
    imagesavealpha($qr, true);

    $qr_w   = imagesx($qr);
    $qr_h   = imagesy($qr);
    $logo_w = imagesx($logo);
    $logo_h = imagesy($logo);

    // skala logo relatif ke lebar QR
    $new_logo_w = (int)($qr_w * $scale);
    $new_logo_h = (int)($logo_h * ($new_logo_w / $logo_w));

    // posisi tengah QR
    $dst_x = (int)(($qr_w - $new_logo_w) / 2);
    $dst_y = (int)(($qr_h - $new_logo_h) / 2);

    // canvas logo baru (truecolor + transparan)
    $logo_resized = imagecreatetruecolor($new_logo_w, $new_logo_h);
    imagealphablending($logo_resized, false);
    imagesavealpha($logo_resized, true);

    // isi dengan background transparan
    $transparent = imagecolorallocatealpha($logo_resized, 0, 0, 0, 127);
    imagefilledrectangle($logo_resized, 0, 0, $new_logo_w, $new_logo_h, $transparent);

    // resize logo TANPA filter grayscale -> warna tetap asli
    imagecopyresampled(
        $logo_resized,
        $logo,
        0, 0, 0, 0,
        $new_logo_w, $new_logo_h,
        $logo_w, $logo_h
    );

    // tempel logo berwarna ke QR
    imagecopy(
        $qr,
        $logo_resized,
        $dst_x, $dst_y,
        0, 0,
        $new_logo_w, $new_logo_h
    );

    $save_path = $save_as_new
        ? preg_replace('/\.png$/', '_logo.png', $qr_path)
        : $qr_path;

    imagepng($qr, $save_path);

    imagedestroy($qr);
    imagedestroy($logo);
    imagedestroy($logo_resized);
}

}
