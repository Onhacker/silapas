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

            // PUTUSAN sebagai text apa adanya
            $put = trim((string)$r->putusan);
            $row['putusan'] = $put !== ''
                ? htmlspecialchars($put, ENT_QUOTES, 'UTF-8')
                : '-';

            // EXPIRASI sebagai text apa adanya
            $exp = trim((string)$r->expirasi);
            $row['expirasi'] = $exp !== ''
                ? htmlspecialchars($exp, ENT_QUOTES, 'UTF-8')
                : '-';

            // Badge status
            $status = strtolower((string)$r->status);
            $badge = 'secondary';
            switch ($status) {
                case 'aktif': $badge = 'success'; break;
                case 'pindah': $badge = 'info'; break;
                case 'bebas': $badge = 'primary'; break;
                default:      $badge = 'secondary'; break;
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
   private function _do_upload($field, $oldFile = null)
{
    if (empty($_FILES[$field]['name'])) {
        return $oldFile; // tidak ada file baru
    }

    $config = [
        'upload_path'   => $this->upload_path,            // mis: ./uploads/kamar_tahanan/
        'allowed_types' => 'jpg|jpeg|png',
        'max_size'      => 2048, // 2MB (boleh disesuaikan)
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

    $up      = $this->upload->data();
    $newFile = $up['file_name'];

    // === AUTO RESIZE + THUMBNAIL ===
    $this->load->library('image_lib');

    // Pastikan folder thumbnail ada
    $thumb_path = rtrim($this->upload_path, '/').'/thumb/';
    if (!is_dir($thumb_path)) {
        @mkdir($thumb_path, 0755, true);
    }

    // 1) Resize "full" (batasi max 1200x1200, quality 80%)
    $config_full = [
        'image_library'  => 'gd2',
        'source_image'   => $this->upload_path.$newFile,
        'maintain_ratio' => true,
        'width'          => 1200,
        'height'         => 1200,
        'quality'        => '80%',
    ];
    $this->image_lib->initialize($config_full);
    $this->image_lib->resize();
    $this->image_lib->clear();

    // 2) Buat thumbnail (misal 260x260)
    $config_thumb = [
        'image_library'  => 'gd2',
        'source_image'   => $this->upload_path.$newFile,
        'new_image'      => $thumb_path.$newFile,
        'maintain_ratio' => true,
        'width'          => 260,
        'height'         => 260,
        'quality'        => '80%',
    ];
    $this->image_lib->initialize($config_thumb);
    $this->image_lib->resize();
    $this->image_lib->clear();

    // Hapus foto lama kalau ada
    if ($oldFile) {
        $oldMain  = $this->upload_path.$oldFile;
        $oldThumb = $thumb_path.$oldFile;
        if (is_file($oldMain))  @unlink($oldMain);
        if (is_file($oldThumb)) @unlink($oldThumb);
    }

    return $newFile;
}

    public function add()
    {
        $data = $this->input->post(NULL, TRUE);
        $this->load->library('form_validation');

        $this->form_validation->set_rules('id_kamar','Kamar','required|integer');
        $this->form_validation->set_rules('nama','Nama','trim|required|min_length[3]|max_length[150]');
        $this->form_validation->set_rules('no_reg','No.Reg','trim|required|max_length[50]');
        $this->form_validation->set_rules('perkara','Perkara','trim|required|max_length[255]');
        $this->form_validation->set_rules('putusan','Putusan','trim');
        $this->form_validation->set_rules('expirasi','Expirasi','trim');
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

        // normalisasi nilai text
        $putusan = trim($data['putusan'] ?? '');
        if ($putusan === '') $putusan = null;

        $exp = trim($data['expirasi'] ?? '');
        if ($exp === '') $exp = null;

        $status = strtolower($data['status'] ?? 'aktif');
        if (!in_array($status, ['aktif','pindah','bebas','lainnya'], true)) {
            $status = 'aktif';
        }

        // FOTO OPSIONAL
        $foto = '';
        if (!empty($_FILES['foto']['name'])) {
            $foto = $this->_do_upload('foto', '');
        }

        $ins = [
            'id_kamar'       => (int)$data['id_kamar'],
            'nama'           => $data['nama'],
            'no_reg'         => $data['no_reg'],
            'perkara'        => $data['perkara'],
            'putusan'        => $putusan,
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
        $this->form_validation->set_rules('putusan','Putusan','trim');
        $this->form_validation->set_rules('expirasi','Expirasi','trim');
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

        $status = strtolower($data['status'] ?? $row->status);
        if (!in_array($status, ['aktif','pindah','bebas','lainnya'], true)) {
            $status = $row->status;
        }

        // normalisasi text putusan & expirasi
        $putusan = trim($data['putusan'] ?? '');
        if ($putusan === '') $putusan = null;

        $exp = trim($data['expirasi'] ?? '');
        if ($exp === '') $exp = null;

        // foto lama
        $currentFoto = $row->foto ?: '';

        // upload foto (jika ada file baru)
        $foto = $this->_do_upload('foto', $currentFoto) ?: $currentFoto;

        $upd = [
            'nama'           => $data['nama'],
            'no_reg'         => $data['no_reg'],
            'perkara'        => $data['perkara'],
            'putusan'        => $putusan,
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

public function generate_thumbnails_kamar_tahanan()
{
    // Amankan dulu: hanya boleh dipanggil oleh admin login
    // (Silakan sesuaikan dengan sistem auth kamu)
    // if (!$this->session->userdata('logged_in')) show_404();

    $upload_path = FCPATH.'uploads/kamar_tahanan/';
    $thumb_path  = $upload_path.'thumb/';

    if (!is_dir($thumb_path)) {
        @mkdir($thumb_path, 0755, true);
    }

    $this->load->library('image_lib');

    // Ambil semua foto yang ada di tabel
    $rows = $this->db->select('id_detail, foto')
                     ->from('kamar_tahanan')
                     ->where('foto !=', '')
                     ->get()
                     ->result();

    echo "<pre>";
    foreach ($rows as $r) {
        $file = trim((string)$r->foto);
        if ($file === '') continue;

        $srcFull  = $upload_path.$file;
        $dstThumb = $thumb_path.$file;

        if (!is_file($srcFull)) {
            echo "SKIP (file tidak ada): {$file}\n";
            continue;
        }

        // Kalau thumbnail sudah ada, skip
        if (is_file($dstThumb)) {
            echo "OK (thumb sudah ada): {$file}\n";
            continue;
        }

        // Resize full (optional, biar tidak kegedean)
        $config_full = [
            'image_library'  => 'gd2',
            'source_image'   => $srcFull,
            'maintain_ratio' => true,
            'width'          => 1200,
            'height'         => 1200,
            'quality'        => '80%',
        ];
        $this->image_lib->initialize($config_full);
        if (!$this->image_lib->resize()) {
            echo "GAGAL resize full: {$file} -> ".$this->image_lib->display_errors()."\n";
        } else {
            echo "OK resize full: {$file}\n";
        }
        $this->image_lib->clear();

        // Buat thumbnail 260x260
        $config_thumb = [
            'image_library'  => 'gd2',
            'source_image'   => $srcFull,
            'new_image'      => $dstThumb,
            'maintain_ratio' => true,
            'width'          => 260,
            'height'         => 260,
            'quality'        => '80%',
        ];
        $this->image_lib->initialize($config_thumb);
        if (!$this->image_lib->resize()) {
            echo "GAGAL buat thumb: {$file} -> ".$this->image_lib->display_errors()."\n";
        } else {
            echo "OK buat thumb: {$file}\n";
        }
        $this->image_lib->clear();
    }

    echo "SELESAI.\n";
    echo "</pre>";
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
            echo json_encode([
                "success" => false,
                "title"   => "Gagal",
                "pesan"   => "Tidak ada data yang dihapus. Cek lagi ID yang dikirim ke server."
            ]);
            return;
        }

        // hapus file foto
        foreach ($rows as $r) {
            if (!empty($r->foto)) {
                $main  = $this->upload_path.$r->foto;
                $thumb = rtrim($this->upload_path,'/').'/thumb/'.$r->foto;

                if (is_file($main))  @unlink($main);
                if (is_file($thumb)) @unlink($thumb);
            }
        }

        echo json_encode([
            "success" => true,
            "title"   => "Berhasil",
            "pesan"   => "Data berhasil dihapus ($aff baris)"
        ]);
    }

}
