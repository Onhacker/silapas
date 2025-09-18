<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_pengumuman extends CI_Model
{
    /**
     * Ambil list + total untuk pagination & pencarian.
     * Return: [$rowsArray, $totalInt]
     */
    public function list_with_total(string $q = '', int $page = 1, int $per_page = 5)
    {
        $off = ($page - 1) * $per_page;
        if ($off < 0) $off = 0;

        $this->db->start_cache();
        $this->db->from('pengumuman');

        if ($q !== '') {
            $this->db->group_start()
                ->like('judul', $q)
                ->or_like('isi', $q)
            ->group_end();
        }
        $this->db->stop_cache();

        // Total
        $total = (int)$this->db->count_all_results('', false);

        // Rows
        $this->db->select('id, judul, isi, tanggal, link_seo');
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit($per_page, $off);
        $rows = $this->db->get()->result_array();

        // bersihkan cache builder
        $this->db->flush_cache();

        return [$rows, $total];
    }

    /**
     * Fallback versi perubahan (ketika 'pengumuman_ver' belum ada).
     * Pakai MAX(tanggal) sebagai patokan.
     */
    public function last_changed_fallback(): int
    {
        $row = $this->db->select('UNIX_TIMESTAMP(MAX(tanggal)) AS ts', false)
                        ->get('pengumuman')->row();
        return ($row && $row->ts) ? (int)$row->ts : time();
    }
}
