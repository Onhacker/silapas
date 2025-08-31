<script type="text/javascript">

    Highcharts.chart('tampil_stat', {
        chart: {
            type: 'column'
        },

        title: {
            text: 'Statistik Imunisasi Berdasarkan Desa ',
        },

        subtitle: {
            <?php 
                if ($jenis_vaksin <> "x") {
                    $this->db->where("id_penyakit", $jenis_vaksin);
                    $nama_penyakit = $this->db->get("master_penyakit")->row();
                    $nama_penyakit = "Vaksin ".(($nama_penyakit->nama_penyakit));
                } else {
                    $nama_penyakit = "Semua Vaksin";
                }
                if ($this->session->userdata("admin_level")=='admin'){
                    if ($id_dusun <> "x" and $this->session->userdata("admin_level")=='admin') {
                        $this->db->where("id_dusun",$id_dusun);
                        $dusun = $this->db->get("master_dusun")->row();
                        $dusun = "Puskesmas ".$dusun->nama_dusun;
                    } else {
                        $dusun = "Semua Puskesmas";
                    } 

                } else {
                    $this->db->where("id_dusun",$this->session->userdata("admin_dusun"));
                    $dusun = $this->db->get("master_dusun")->row();
                    $dusun = "Puskesmas ".$dusun->nama_dusun;
                }
                if ($tahun <> "x") {
                    $thn = "Tahun ".$tahun;
                } else {
                    $thn = "Semua Tahun ";
                }
                if ($bulan <> "x") {
                    $bln = "Bulan ".getBulan($bulan);
                } else {
                    $bln = "Semua Bulan";
                }

            ?>
            text: 'Data Berdasarkan <?php echo $dusun.". ".$nama_penyakit.". ".$thn.". ".$bln ?>'
        },
        xAxis: {
         categories: [<?php  
            foreach ($desa->result() as $row) : 
                echo "'".(($row->desa))."',";
            endforeach;
            ?>]
        },



        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f} Anak</b>  </td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true,
        },
        yAxis: {
            title: {
                text: 'Anak'
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
        colors: ['#087EC1','#9400D3','#26B20C'],
        series: [
        {
          name: 'Laki-Laki',
          data: 
          [<?php  
            foreach ($desa->result() as $v) :
                if ($jenis_vaksin <> "x") {
                    $this->db->where("jenis_vaksin", $jenis_vaksin);
                }
                if ($tahun <> "x") {
                    $this->db->where("year(tgl_suntik)", $tahun);
                }
                if ($bulan <> "x") {
                    $this->db->where('month(tgl_suntik)',$bulan);
                }

                if ($this->session->userdata("admin_level")=='admin'){
                    if ($id_dusun <> "x" and $this->session->userdata("admin_level")=='admin') {
                        $this->db->where("id_dusun",$id_dusun);
                    } 

                } else {
                    $this->db->where("id_dusun",$this->session->userdata("admin_dusun"));
                }
                $this->db->where("jk","L");
                $this->db->where("id_desa", $v->id_desa);
                $this->db->select("count(jenis_vaksin) as jumlah");
                $j = $this->db->get("imunisasi")->row();
                echo ($j->jumlah).",";
            endforeach; ?>]
        },
        {
          name: 'Perempuan',
          data: 
          [<?php  
            foreach ($desa->result() as $v) :
                if ($jenis_vaksin <> "x") {
                    $this->db->where("jenis_vaksin", $jenis_vaksin);
                }
                if ($tahun <> "x") {
                    $this->db->where("year(tgl_suntik)", $tahun);
                }
                if ($bulan <> "x") {
                    $this->db->where('month(tgl_suntik)',$bulan);
                }

                if ($this->session->userdata("admin_level")=='admin'){
                    if ($id_dusun <> "x" and $this->session->userdata("admin_level")=='admin') {
                        $this->db->where("id_dusun",$id_dusun);
                    } 

                } else {
                    $this->db->where("id_dusun",$this->session->userdata("admin_dusun"));
                }
                $this->db->where("jk","P");
                $this->db->where("id_desa", $v->id_desa);
                $this->db->select("count(jenis_vaksin) as jumlah");
                $j = $this->db->get("imunisasi")->row();
                echo ($j->jumlah).",";
            endforeach; ?>]
        },

        {
          name: 'Total',
          data: 
          [<?php  
            foreach ($desa->result() as $v) :
                if ($jenis_vaksin <> "x") {
                    $this->db->where("jenis_vaksin", $jenis_vaksin);
                }
                if ($tahun <> "x") {
                    $this->db->where("year(tgl_suntik)", $tahun);
                }
                if ($bulan <> "x") {
                    $this->db->where('month(tgl_suntik)',$bulan);
                }

                if ($this->session->userdata("admin_level")=='admin'){
                    if ($id_dusun <> "x" and $this->session->userdata("admin_level")=='admin') {
                        $this->db->where("id_dusun",$id_dusun);
                    } 

                } else {
                    $this->db->where("id_dusun",$this->session->userdata("admin_dusun"));
                }
                $this->db->where("id_desa", $v->id_desa);
                $this->db->select("count(jenis_vaksin) as jumlah");
                $j = $this->db->get("imunisasi")->row();
                echo ($j->jumlah).",";
            endforeach; ?>]
        },
       
        ]
    },function(chart){
        if(chart.series[0].data.length == 0) 
            swal({   
                 title: "Data tidak ditemukan",   
                 type: "warning", 
                 html: "Data Imunisasi belum ada untuk ditampilkan di Statistik",
                 confirmButtonColor: "#22af47",   
            });
    });

</script>


