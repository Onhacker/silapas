<script type="text/javascript">

    Highcharts.chart('tampil_stat', {
        chart: {
            type: 'column'
        },

        title: {
            text: 'Statistik Imunisasi Berdasarkan Puskesmas ',
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
            text: 'Data Berdasarkan Semua dusun <?php echo ucwords(strtolower($this->om->web_me()->kabupaten)).". ".$nama_penyakit.". ".$thn.". ".$bln ?>'
        },
        xAxis: {
         categories: [<?php  
            foreach ($dusun->result() as $row) : 
                echo "'".(($row->nama_dusun))."',";
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
            foreach ($dusun->result() as $v) :
                if ($jenis_vaksin <> "x") {
                    $this->db->where("jenis_vaksin", $jenis_vaksin);
                }
                if ($tahun <> "x") {
                    $this->db->where("year(tgl_suntik)", $tahun);
                }
                if ($bulan <> "x") {
                    $this->db->where('month(tgl_suntik)',$bulan);
                }

                $this->db->where("id_dusun",$v->id_dusun);
                $this->db->where("jk","L");
                $this->db->select("count(jenis_vaksin) as jumlah");
                $j = $this->db->get("imunisasi")->row();
                echo ($j->jumlah).",";
            endforeach; ?>]
        },
        {
          name: 'Perempuan',
          data: 
          [<?php  
            foreach ($dusun->result() as $v) :
                if ($jenis_vaksin <> "x") {
                    $this->db->where("jenis_vaksin", $jenis_vaksin);
                }
                if ($tahun <> "x") {
                    $this->db->where("year(tgl_suntik)", $tahun);
                }
                if ($bulan <> "x") {
                    $this->db->where('month(tgl_suntik)',$bulan);
                }

                $this->db->where("jk","P");
                $this->db->where("id_dusun",$v->id_dusun);
                $this->db->select("count(jenis_vaksin) as jumlah");
                $j = $this->db->get("imunisasi")->row();
                echo ($j->jumlah).",";
            endforeach; ?>]
        },

        {
          name: 'Total',
          data: 
          [<?php  
            foreach ($dusun->result() as $v) :
                if ($jenis_vaksin <> "x") {
                    $this->db->where("jenis_vaksin", $jenis_vaksin);
                }
                if ($tahun <> "x") {
                    $this->db->where("year(tgl_suntik)", $tahun);
                }
                if ($bulan <> "x") {
                    $this->db->where('month(tgl_suntik)',$bulan);
                }

                $this->db->where("id_dusun",$v->id_dusun);
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


