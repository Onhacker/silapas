<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_permohonan extends Admin_Controller {
	function __construct(){
		parent::__construct();

        // $this->output->set_header('Cache-Control: no-cache, no-store, must-revalidate');
        // $this->output->set_header('Pragma: no-cache');
        // $this->output->set_header('Expires: 0');
        // $this->output->set_header('Last-Modified: ' . gmdate("D, d M Y H:i:s") . ' GMT');

        $this->load->model("M_admin_permohonan", "mbt");
        // $this->load->model("M_paket_a", "pa");
    }


    public function index()
    {
        $level = $this->session->userdata("admin_level");
        if ($level !== "admin" && $level !== "user") {
            show_error("Anda tidak memiliki akses.", 403, "Akses Ditolak");
            return;
        }

        $data['controller'] = get_class($this);
        $data['title']      = "Monitoring Booking Tamu";
        $data['subtitle']   = "Semua Booking";
        $data['deskripsi']  = "Data seluruh booking kunjungan tamu";

        // dropdown unit
        $data['arr_units']  = $this->mbt->arr_units();

        $data['content'] = $this->load->view('Admin_permohonan_view', $data, true);
        $this->render($data);
    }

    public function get_data()
{
    $post = $this->input->post(NULL, TRUE);

    $list  = $this->mbt->get_datatables($post);
    $data  = [];
    $start = intval($post['start'] ?? 0);

    foreach ($list as $row) {
        $start++;

        // Status badge lengkap
        switch ($row->status) {
            case 'approved':
                $badge = '<span class="badge bg-info text-dark">✅ Approved</span>'; break;
            case 'checked_in':
                $badge = '<span class="badge bg-success">🟢 Checked-in</span>'; break;
            case 'checked_out':
                $badge = '<span class="badge bg-warning text-dark">🟡 Checked-out</span>'; break;
            case 'expired':
                $badge = '<span class="badge bg-secondary">⛔ Tidak Datang</span>'; break;
            case 'rejected':
                $badge = '<span class="badge bg-danger">❌ Rejected</span>'; break;
            default:
                $badge = '<span class="badge bg-light text-dark">Draft</span>';
        }

        $asal = $row->asal ?: '-'; // dari COALESCE(target_instansi_nama, instansi)
        $unit = $row->unit_tujuan_nama ?: '-';

        $data[] = [
            'no'   => $start,
            'kode' => '<a href="'.site_url('admin_permohonan/detail/'.rawurlencode($row->kode_booking)).'" '.
                      'class="badge badge-info" title="Lihat detail">'.
                      htmlspecialchars($row->kode_booking).'</a>',
            'tgljam' => hari_ini($row->tanggal).",".htmlspecialchars(tgl_view($row->tanggal)).' '.$row->jam,
            'tamu'   => '<b>'.htmlspecialchars($row->nama_tamu).'</b>'.
                        '<div class="text-muted small">'.htmlspecialchars($row->jabatan ?: '-').'</div>',
            'asal'   => htmlspecialchars($asal),
            'instansi' => '<b>'.htmlspecialchars($unit).'</b>'.
                          ( !empty($row->nama_petugas_instansi)
                              ? '<div class="small text-muted">'.htmlspecialchars($row->nama_petugas_instansi).'</div>'
                              : '' ),
            'status' => $badge
        ];
    }

    $output = [
        "draw"            => intval($post['draw'] ?? 1),
        "recordsTotal"    => $this->mbt->count_all($post),
        "recordsFiltered" => $this->mbt->count_filtered($post),
        "data"            => $data,
    ];
    echo json_encode($output);
}


    public function cetak_pdf()
{
    // Ambil filter via GET
    $filters = [
        'tanggal_mulai'   => $this->input->get('tanggal_mulai', TRUE),
        'tanggal_selesai' => $this->input->get('tanggal_selesai', TRUE),
        'unit_tujuan'     => $this->input->get('unit_tujuan', TRUE),
        'form_asal'       => $this->input->get('form_asal', TRUE),
        'status'          => $this->input->get('status', TRUE),
    ];

    // Data
    $rows = $this->mbt->get_for_export($filters);
    // ... setelah $filters didefinisikan
$filters['unit_tujuan_nama'] = '';
if (!empty($filters['unit_tujuan'])) {
    $u = $this->db->select('nama_unit')
                  ->where('id', (int)$filters['unit_tujuan'])
                  ->get('unit_tujuan')->row();
    if ($u) {
        $filters['unit_tujuan_nama'] = $u->nama_unit;
    }
}

    // Siapkan HTML untuk TCPDF
   $html = $this->load->view('laporan_booking', [
    'rows'    => $rows,
    'filters' => $filters,
    'title'   => 'Laporan Booking Tamu'
], true);



    // Load TCPDF
    if (!class_exists('TCPDF')) {
        // Sesuaikan path jika berbeda
        require_once(APPPATH.'third_party/tcpdf/tcpdf.php');
    }

    // Buat PDF
    $pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
    $pdf->SetCreator('SILAPAS');
    $pdf->SetAuthor('SILAPAS');
    $pdf->SetTitle('Laporan Booking Tamu');
    $pdf->SetSubject('Laporan Booking Tamu');

    // Header/Footer dimatikan (opsional)
    $pdf->setPrintHeader(false);
    $pdf->setPrintFooter(false);

    // Margin & font
    $pdf->SetMargins(10, 12, 10);
    $pdf->SetAutoPageBreak(TRUE, 12);
    // Gunakan font unicode supaya karakter Indonesia aman
    $pdf->SetFont('dejavusans', '', 10);

    // Halaman
    $pdf->AddPage();

    // Tulis HTML
    $pdf->writeHTML($html, true, false, true, false, '');

    // Output
    $filename = 'booking_tamu_'.date('Ymd_His').'.pdf';
    $pdf->Output($filename, 'I'); // 'I' inline di browser, 'D' untuk download
}

public function detail($kode_booking = null)
{
    if (empty($kode_booking)) { show_404(); }

    $row = $this->mbt->get_detail_by_kode($kode_booking);
    if (!$row) { show_404(); }

    // ⬇️ Tambahan: ambil pendamping
    $pendamping_rows = $this->mbt->get_pendamping_by_kode($kode_booking);

    $data['controller'] = get_class($this);
    $data['title']      = 'Detail Booking: '.$kode_booking;
    $data['deskripsi']  = 'Rincian lengkap data booking tamu';
    $data['subtitle']   = 'Detail Booking: '.$kode_booking;

    $data['row']             = $row;
    $data['pendamping_rows'] = $pendamping_rows; // ⬅️ kirim ke view

    $data['content'] = $this->load->view('Admin_permohonan_detail', $data, true);
    $this->render($data);
}


public function lampiran($jenis = '', $kode = '')
{
    // cek login/otorisasi sesuai kebutuhanmu...
    $row = $this->db->get_where('booking_tamu', ['kode_booking' => $kode])->row();
    if (!$row) show_404();

    if ($jenis === 'surat') {
        $file_name = $row->surat_tugas;
        $base_path = FCPATH.'uploads/surat_tugas/';
    } elseif ($jenis === 'foto') {
        $file_name = $row->foto;
        $base_path = FCPATH.'uploads/foto/';
    } else {
        show_404();
    }

    if (empty($file_name)) show_404();

    $path = $base_path . $file_name;
    if (!is_file($path)) show_404();

    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
    $mime = 'application/octet-stream';
    if ($ext === 'pdf') $mime = 'application/pdf';
    if (in_array($ext, ['jpg','jpeg'])) $mime = 'image/jpeg';
    if ($ext === 'png') $mime = 'image/png';
    if ($ext === 'gif') $mime = 'image/gif';
    if ($ext === 'webp') $mime = 'image/webp';

    // dl=1 -> force download
    $force = $this->input->get('dl', true) == '1';
    $disp  = $force ? 'attachment' : 'inline';

    // bersihkan output buffer
    if (ob_get_length()) ob_end_clean();

    header('Content-Type: '.$mime);
    header('X-Content-Type-Options: nosniff');
    header('Content-Length: '.filesize($path));
    header('Content-Disposition: '.$disp.'; filename="'.basename($path).'"');

    // kirim file
    readfile($path);
    exit;
}



}
