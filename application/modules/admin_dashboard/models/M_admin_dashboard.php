<?php 
class M_admin_dashboard extends CI_model{
    public function arr_kecamatan() {
        $res = $this->db->order_by("kecamatan")->get("tiger_kecamatan")->result();
        $arr[''] = '== Pilih Kecamatan ==';
        foreach ($res as $row) {
            $arr[$row->id] = $row->kecamatan;
        }
        return $arr;
    }

    public function get_status_count()
    {
        $id_session = $this->session->userdata("admin_session");

    // Ambil data view_users_capil terlebih dahulu (terpisah dari query utama)
        $asal_tabels = [];
        $cekper = $this->db->get_where("view_users_capil", ["id_session" => $id_session]);
        foreach ($cekper->result() as $t) {
            $asal_tabels[] = $t->nama_tabel;
        }

    // Menyusun query utama untuk menghitung status permohonan
        $this->db->select('status, COUNT(*) as total');
        $this->db->from('view_semua_paket');
        
        if ($this->session->userdata("admin_level") != "admin") {
        // Jika bukan super admin, batasi berdasarkan desa dan username admin
            $this->db->where_in('status', [0, 1, 2, 3, 4]);
            $this->db->where('YEAR(create_date)', date('Y'));
            $this->db->where('id_desa', $this->session->userdata("id_desa"));
            $this->db->where('username', $this->session->userdata("admin_username"));
        } else {
        // Jika super admin, gunakan asal_tabel berdasarkan hak akses yang ada
            if (!empty($asal_tabels)) {
                $this->db->where_in("asal_tabel", $asal_tabels);
            }
            $this->db->where_in('status', [2, 3, 4]);
            $this->db->where('YEAR(create_date)', date('Y'));
        }

    // Kelompokkan hasil berdasarkan status
        $this->db->group_by('status');
        $query = $this->db->get();

    // Buat array lengkap untuk status 0-4, dengan nilai default 0
        $result = array_fill_keys([0, 1, 2, 3, 4], 0);
        foreach ($query->result() as $row) {
            $result[$row->status] = $row->total;
        }

        return $result;
    }



    public function arr_desa2($id_kecamatan = "") {
        if ($id_kecamatan != "") {
            $this->db->where("id_kecamatan", $id_kecamatan);
        }
        $res = $this->db->order_by("desa")->get("tiger_desa")->result();
        $arr[''] = '== Pilih Desa ==';
        foreach ($res as $row) {
            $arr[$row->id] = $row->desa;
        }
        return $arr;
    }

    public function arr_dusun($id_desa = "") {
        if ($id_desa != "") {
            $this->db->where("id_desa", $id_desa);
        }
        $res = $this->db->order_by("nama_dusun")->get("master_dusun")->result();
        $arr[''] = '== Pilih Dusun ==';
        foreach ($res as $row) {
            $arr[$row->id_dusun] = $row->nama_dusun;
        }
        return $arr;
    }



    function arr_tahun()
    {
        $query = "
        SELECT DISTINCT YEAR(update_time) AS tahun FROM paket_a
        UNION
        SELECT DISTINCT YEAR(update_time) AS tahun FROM paket_b
        UNION
        SELECT DISTINCT YEAR(update_time) AS tahun FROM paket_c
        UNION
        SELECT DISTINCT YEAR(update_time) AS tahun FROM paket_d
        UNION
        SELECT DISTINCT YEAR(update_time) AS tahun FROM paket_e
        UNION
        SELECT DISTINCT YEAR(update_time) AS tahun FROM paket_f
        UNION
        SELECT DISTINCT YEAR(update_time) AS tahun FROM paket_g
        UNION
        SELECT DISTINCT YEAR(update_time) AS tahun FROM paket_h
        UNION
        SELECT DISTINCT YEAR(update_time) AS tahun FROM paket_i
        UNION
        SELECT DISTINCT YEAR(update_time) AS tahun FROM paket_j
        UNION
        SELECT DISTINCT YEAR(update_time) AS tahun FROM paket_k
        UNION
        SELECT DISTINCT YEAR(update_time) AS tahun FROM paket_l
        UNION
        SELECT DISTINCT YEAR(update_time) AS tahun FROM paket_m
        UNION
        SELECT DISTINCT YEAR(update_time) AS tahun FROM paket_n
        UNION
        SELECT DISTINCT YEAR(update_time) AS tahun FROM paket_o
        ORDER BY tahun DESC
        ";

        $res = $this->db->query($query);
        $arr[""] = "== Semua Tahun ==";
        foreach ($res->result() as $row) {
            $arr[$row->tahun] = $row->tahun;
        }

        return $arr;
    }


}