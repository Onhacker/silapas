<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_kamar_detail extends Admin_Controller {

    private $upload_path;

    public function __construct(){
        parent::__construct();
        $this->load->model('M_admin_kamar_detail','dm');
        $this->load->model('M_admin_kamar','mk');
        cek_session_akses(get_class($this), $this->session->userdata('admin_session'));

        // Folder upload foto
        $this->upload_path = FCPATH.'uploads/kamar_tahanan/';
        if (!is_dir($this->upload_path)) {
            @mkdir($this->upload_path, 0755, true);
        }
    }

    public function index($id_kamar = null)
    {
        $id_kamar = (int)$id_kamar;
        $kamar = $this->mk->get_by_id($id_kamar);
        if (!$kamar) show_404();

        $data["controller"] = get_class($this);
        $data["title"]      = "Detail Kamar Tahanan";
        $data["subtitle"]   = "Tahanan pada ".$kamar->nama;
        $data["kamar"]      = $kamar;
        $data["content"]    = $this->load->view(($data["controller"])."_view",$data,true);
        $this->render($data);
    }

    /** DataTables untuk tahanan per kamar */
    public function get_data($id_kamar)
    {
        $id_kamar = (int)$id_kamar;
        $list = $this->dm->get_data($id_kamar);
        $data = [];
        foreach ($list as $r) {
            $row = [];

            $row['cek'] = '<div class="checkbox checkbox-primary checkbox-single">'
                        . '<input type="checkbox" class="data-check" value="'.(int)$r->id_detail.'"><label></label>'
                        . '</div>';
            $row['no']  = '';

            $nama    = htmlspecialchars($r->nama, ENT_QUOTES, 'UTF-8');
            $no_reg  = htmlspecialchars($r->no_reg, ENT_QUOTES, 'UTF-8');
            $perkara = htmlspecialchars($r->perkara, ENT_QUOTES, 'UTF-8');

            // Avatar / foto kecil di kolom identitas
            if (!empty($r->foto)) {
                $src = base_url('uploads/kamar_tahanan/'.rawurlencode($r->foto));
                $avatar = '<div class="mr-2 d-inline-block align-top">
                             <img src="'.$src.'" alt="'.$nama.'" class="rounded-circle border"
                                  style="width:40px;height:40px;object-fit:cover;">
                           </div>';
            } else {
                $avatar = '<div class="mr-2 d-inline-block align-top rounded-circle bg-light border"
                                 style="width:40px;height:40px;display:flex;align-items:center;justify-content:center;">
                             <i class="fe-user text-muted"></i>
                           </div>';
            }

            $row['identitas'] =
                '<div class="d-flex align-items-start">'
              .   $avatar
              .   '<div class="flex-grow-1">'
              .     '<strong>'.$nama.'</strong><br>'
              .     '<small>No.Reg: '.$no_reg.'<br>Perkara: '.$perkara.'</small>'
              .   '</div>'
              . '</div>';

            $put = (int)$r->putusan_tahun.' th '.(int)$r->putusan_bulan.' bln '.(int)$r->putusan_hari.' hr';
            $row['putusan'] = $put;

            $row['expirasi'] = $r->expirasi ? date('d-m-Y', strtotime($r->expirasi)) : '-';

            // Badge status lebih rapi
            $status = strtolower((string)$r->status);
            $badge = 'secondary';
            switch ($status) {
                case 'aktif': $badge = 'success'; break;
                case 'pindah': $badge = 'info'; break;
                case 'bebas': $badge = 'primary'; break;
                default: $badge = 'secondary'; break;
            }
            $row['status'] = '<span class="badge badge-'.$badge.'">'.ucfirst($status).'</span>';

            $btnEdit = '<button type="button" class="btn btn-warning btn-sm" onclick="edit('.(int)$r->id_detail.')">'
                     . '<i class="fe-edit"></i> Edit</button>';

            $row['aksi'] = $btnEdit;

            $data[] = $row;
        }

        $out = [
            "draw"            => (int)$this->input->post('draw'),
            "recordsTotal"    => $this->dm->count_all($id_kamar),
            "recordsFiltered" => $this->dm->count_filtered($id_kamar),
            "data"            => $data,
        ];
        $this->output->set_content_type('application/json')->set_output(json_encode($out));
    }

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

    /** Helper upload foto */
    private function _do_upload($field, $oldFile = '')
{
    // kalau tidak ada file baru -> kembalikan nama lama (atau '' kalau tidak ada)
    if (empty($_FILES[$field]['name'])) {
        return $oldFile ?: '';
    }

    $config = [
        'upload_path'   => $this->upload_path,
        'allowed_types' => 'jpg|jpeg|png',
        'max_size'      => 1024, // 1MB
        'encrypt_name'  => true,
    ];

    $this->load->library('upload');
    $this->upload->initialize($config);

    if (!$this->upload->do_upload($field)) {
        $err = strip_tags($this->upload->display_errors('', ' '));
        echo json_encode([
            "success" => false,
            "title"   => "Gagal Upload Foto",
            "pesan"   => $err ?: 'Upload foto gagal'
        ]);
        exit;
    }

    $up = $this->upload->data();
    $newFile = $up['file_name'];

    // hapus foto lama kalau ada
    if (!empty($oldFile) && is_file($this->upload_path.$oldFile)) {
        @unlink($this->upload_path.$oldFile);
    }

    // PASTIKAN string, bukan null
    return $newFile ?: ($oldFile ?: '');
}


   public function add()
{
    $data = $this->input->post(NULL, TRUE);
    $this->load->library('form_validation');

    $this->form_validation->set_rules('id_kamar','Kamar','required|integer');
    $this->form_validation->set_rules('nama','Nama','trim|required|min_length[3]|max_length[150]');
    $this->form_validation->set_rules('no_reg','No.Reg','trim|required|max_length[50]');
    $this->form_validation->set_rules('perkara','Perkara','trim|required|max_length[255]');
    $this->form_validation->set_rules('putusan_tahun','Putusan Tahun','trim|integer');
    $this->form_validation->set_rules('putusan_bulan','Putusan Bulan','trim|integer');
    $this->form_validation->set_rules('putusan_hari','Putusan Hari','trim|integer');
    $this->form_validation->set_rules(
        'status',
        'Status',
        'trim|required|in_list[aktif,pindah,bebas,lainnya]'
    );

    $this->form_validation->set_message('required','* %s harus diisi');
    $this->form_validation->set_error_delimiters('<br> ',' ');

    if ($this->form_validation->run() !== TRUE) {
        echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>validation_errors()]);
        return;
    }

    $exp = $data['expirasi'] ?? null;
    if ($exp === '') $exp = null;

    $status = strtolower($data['status'] ?? 'aktif');
    if (!in_array($status, ['aktif','pindah','bebas','lainnya'], true)) {
        $status = 'aktif';
    }

    // ========== FOTO OPSIONAL ==========
    // default: string kosong, agar tidak NULL
    $foto = '';
    if (!empty($_FILES['foto']['name'])) {
        $foto = $this->_do_upload('foto', '');
    }
    // ===================================

    $ins = [
        'id_kamar'       => (int)$data['id_kamar'],
        'nama'           => $data['nama'],
        'no_reg'         => $data['no_reg'],
        'perkara'        => $data['perkara'],
        'putusan_tahun'  => (int)($data['putusan_tahun'] ?? 0),
        'putusan_bulan'  => (int)($data['putusan_bulan'] ?? 0),
        'putusan_hari'   => (int)($data['putusan_hari'] ?? 0),
        'expirasi'       => $exp,
        'jenis_kelamin'  => $data['jenis_kelamin'] ?? null,
        'tempat_lahir'   => $data['tempat_lahir'] ?? null,
        'tanggal_lahir'  => ($data['tanggal_lahir'] ?? '') ?: null,
        'alamat'         => $data['alamat'] ?? null,
        'status'         => $status,
        'deskripsi'      => $data['deskripsi'] ?? null,
        'foto'           => $foto, // SELALU string (bisa kosong), tidak null
    ];

    $res = $this->db->insert('kamar_tahanan',$ins);
    if ($res) {
        echo json_encode(["success"=>true,"title"=>"Berhasil","pesan"=>"Data tahanan berhasil disimpan"]);
    } else {
        echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Data gagal disimpan"]);
    }
}


   public function update()
{
    $data = $this->input->post(NULL, TRUE);
    $id   = (int)($data['id_detail'] ?? 0);

    $this->load->library('form_validation');
    $this->form_validation->set_rules('id_detail','ID','required|integer');
    $this->form_validation->set_rules('nama','Nama','trim|required|min_length[3]|max_length[150]');
    $this->form_validation->set_rules('no_reg','No.Reg','trim|required|max_length[50]');
    $this->form_validation->set_rules('perkara','Perkara','trim|required|max_length[255]');
    $this->form_validation->set_rules(
        'status',
        'Status',
        'trim|required|in_list[aktif,pindah,bebas,lainnya]'
    );

    if ($this->form_validation->run() !== TRUE) {
        echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>validation_errors()]);
        return;
    }

    $row = $this->dm->get_by_id($id);
    if (!$row) {
        echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Data tidak ditemukan"]);
        return;
    }

    $exp = $data['expirasi'] ?? null;
    if ($exp === '') $exp = null;

    $status = strtolower($data['status'] ?? $row->status);
    if (!in_array($status, ['aktif','pindah','bebas','lainnya'], true)) {
        $status = $row->status;
    }

    // pastikan foto lama tidak null
    $currentFoto = $row->foto ?: '';

    // upload foto (jika ada file baru) -> kalau tidak ada, tetap pakai foto lama (string kosong pun oke)
    $foto = $this->_do_upload('foto', $currentFoto) ?: '';

    $upd = [
        'nama'           => $data['nama'],
        'no_reg'         => $data['no_reg'],
        'perkara'        => $data['perkara'],
        'putusan_tahun'  => (int)($data['putusan_tahun'] ?? 0),
        'putusan_bulan'  => (int)($data['putusan_bulan'] ?? 0),
        'putusan_hari'   => (int)($data['putusan_hari'] ?? 0),
        'expirasi'       => $exp,
        'jenis_kelamin'  => $data['jenis_kelamin'] ?? null,
        'tempat_lahir'   => $data['tempat_lahir'] ?? null,
        'tanggal_lahir'  => ($data['tanggal_lahir'] ?? '') ?: null,
        'alamat'         => $data['alamat'] ?? null,
        'status'         => $status,
        'deskripsi'      => $data['deskripsi'] ?? null,
        'updated_at'     => date('Y-m-d H:i:s'),
        'foto'           => $foto,
    ];

    $res = $this->db->where('id_detail',$id)->update('kamar_tahanan',$upd);

    if ($res) {
        echo json_encode(["success"=>true,"title"=>"Berhasil","pesan"=>"Data berhasil diupdate"]);
    } else {
        echo json_encode(["success"=>false,"title"=>"Gagal","pesan"=>"Data gagal diupdate"]);
    }
}


   public function hapus_data()
{
    // terima baik "id" maupun "id_detail" dari client (jaga-jaga)
    $ids = $this->input->post('id');
    if (!$ids) {
        $ids = $this->input->post('id_detail');
    }

    // pastikan array
    if (!$ids) {
        echo json_encode([
            "success" => false,
            "title"   => "Gagal",
            "pesan"   => "Tidak ada ID yang dikirim dari client"
        ]);
        return;
    }

    if (!is_array($ids)) {
        $ids = [$ids];
    }

    // casting ke integer & buang yang 0
    $idInts = array_values(array_unique(array_filter(array_map('intval', $ids))));
    if (!$idInts) {
        echo json_encode([
            "success" => false,
            "title"   => "Gagal",
            "pesan"   => "Tidak ada data valid"
        ]);
        return;
    }

    // ambil dulu foto-fotonya
    $rows = $this->db->select('id_detail,foto')
                     ->from('kamar_tahanan')
                     ->where_in('id_detail', $idInts)
                     ->get()
                     ->result();

    // hapus data
    $this->db->where_in('id_detail', $idInts);
    $ok  = $this->db->delete('kamar_tahanan');
    $err = $this->db->error();
    $aff = $this->db->affected_rows();

    if ($err['code'] != 0) {
        // ada error query (misal karena constraint FK)
        log_message('error', 'Gagal hapus kamar_tahanan: '.print_r($err, true));
        echo json_encode([
            "success" => false,
            "title"   => "Gagal",
            "pesan"   => "Query delete gagal. Kode: {$err['code']} - {$err['message']}"
        ]);
        return;
    }

    if (!$ok || $aff === 0) {
        // query sukses tapi tidak ada baris terkena
        echo json_encode([
            "success" => false,
            "title"   => "Gagal",
            "pesan"   => "Tidak ada data yang dihapus. Cek lagi ID yang dikirim ke server."
        ]);
        return;
    }

    // hapus file foto
    foreach ($rows as $r) {
        if (!empty($r->foto) && is_file($this->upload_path.$r->foto)) {
            @unlink($this->upload_path.$r->foto);
        }
    }

    echo json_encode([
        "success" => true,
        "title"   => "Berhasil",
        "pesan"   => "Data berhasil dihapus ($aff baris)"
    ]);
}

}
