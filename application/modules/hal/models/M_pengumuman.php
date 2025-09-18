<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pengumuman extends CI_Model {

    public function __construct(){ parent::__construct(); }

    /** Versi "last changed" fallback (kalau key cache tidak ada) */
    public function last_changed_fallback(): int
    {
        // Tanpa kolom updated_at, kita ambil kombinasi MAX(tanggal) + MAX(id)
        // agar tambah & edit (tanggal sering diganti) tetap memicu perubahan.
        $row = $this->db->select("COALESCE(UNIX_TIMESTAMP(MAX(tanggal)),0) AS ts, COALESCE(MAX(id),0) AS mx", false)
                        ->get('pengumuman')->row();
        return (int)(($row->ts ?? 0) + ($row->mx ?? 0));
    }

    /** Ambil list + total untuk pagination */
    public function list_with_total(string $q = '', int $page = 1, int $per_page = 5): array
    {
        $page     = max(1, $page);
        $per_page = min(max(1, $per_page), 50); // batasi max

        // Hitung total
        $this->db->from('pengumuman');
        if ($q !== '') {
            $this->db->group_start()
                     ->like('judul', $q)
                     ->or_like('isi', $q)
                     ->group_end();
        }
        $total = (int)$this->db->count_all_results();

        // Ambil rows
        $this->db->from('pengumuman');
        if ($q !== '') {
            $this->db->group_start()
                     ->like('judul', $q)
                     ->or_like('isi', $q)
                     ->group_end();
        }
        $this->db->order_by('tanggal','DESC')->order_by('id','DESC');
        $this->db->limit($per_page, ($page - 1) * $per_page);
        $rows = $this->db->get()->result_array();

        return [$rows, $total];
    }

    public function get_one(int $id)
    {
        return $this->db->get_where('pengumuman', ['id'=>$id])->row();
    }
}
