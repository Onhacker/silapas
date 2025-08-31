
<script type="text/javascript">

    Highcharts.chart('tampil_stat', {
        chart: {
            type: 'column'
        },

        title: {
            text: 'Statistik Semua Permohonan'
        },

        subtitle: {
            <?php 
            $desa = "Semua Desa";
            $dusun = "Semua Dusun";
            $thn = "Semua Tahun";

            if (!empty($id_desa)) {
                $this->db->where("id", $id_desa);
                $desa_data = $this->db->get("tiger_desa")->row();
                if ($desa_data) {
                    $desa = "Desa " . ucwords(strtolower($desa_data->desa));
                }
            }

            if ($this->session->userdata("admin_level") == "admin") {
                if (!empty($id_dusun)) {
                    $this->db->where("id_dusun", $id_dusun);
                    $dusun_data = $this->db->get("master_dusun")->row();
                    if ($dusun_data) {
                        $dusun = "Dusun " . $dusun_data->nama_dusun;
                    }
                }
            } else {
                $this->db->where("id_dusun", $this->session->userdata("admin_dusun"));
                $dusun_data = $this->db->get("master_dusun")->row();
                if ($dusun_data) {
                    $dusun = "Dusun " . $dusun_data->nama_dusun;
                }
            }

            if (!empty($tahun) && $tahun !== 'x') {
                $thn = "Tahun $tahun";
            }
            ?>
            text: 'Data Berdasarkan <?php echo $desa . ", " . $dusun . ", " . $thn ?>'
        },

        xAxis: {
            categories: <?= json_encode(array_column($permohonan->result_array(), 'nama_permohonan')) ?>
        },

        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f} Permohonan</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },

        yAxis: {
            title: {
                text: 'Jumlah Permohonan'
            }
        },

        plotOptions: {
            column: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },

        colors: ['#087EC1', '#9400D3', '#26B20C'],

        series: [{
            name: 'Total',
            data: <?php  
            $data_series = [];
            foreach ($permohonan->result() as $v) {
                $tabel = $v->nama_tabel;
                $count = 0;

                if ($this->db->table_exists($tabel)) {
                    $this->db->reset_query();
                    $this->db->from($tabel);

                    if (!empty($id_desa)) {
                        $this->db->where("id_desa", $id_desa);
                    }

                    if (!empty($id_dusun)) {
                        $this->db->where("id_dusun", $id_dusun);
                    }

                    if (!empty($id_kecamatan)) {
                        $string = $id_kecamatan;
                        $parts = explode('_', $string);
                        $hasil = $parts[0] . '_' . $parts[1] . '_' . $parts[2];
                        $this->db->like("id_desa", $hasil . '_', 'after');
                    }

                    if (!empty($tahun)) {
                        $this->db->where("YEAR(create_date)", $tahun);
                    }

                    $count = $this->db->count_all_results();
                }

                $data_series[] = $count;
            }
            echo json_encode($data_series);
            ?>
        }]
    }, function(chart) {
        const dataSeries = <?= json_encode($data_series) ?>;
        const total = dataSeries.reduce((a, b) => a + b, 0);
        if (dataSeries.length === 0 || total === 0) {
            $("#tampil_stat").hide().html(`
                <div class="text-center text-muted my-4 animate__animated animate__fadeIn">
                <i class="fas fa-info-circle fa-2x mb-2"></i><br>
                <strong>Belum ada data</strong><br>
                Tidak ada permohonan yang dapat ditampilkan pada grafik.
                </div>
                `).fadeIn(300);
        }
    });

</script>
