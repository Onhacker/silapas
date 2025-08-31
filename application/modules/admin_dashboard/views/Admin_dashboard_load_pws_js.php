<script type="text/javascript">
    <?php 
    if ($jenis_vaksin == "9999") {
        $vaksin = "IDL IPV";
    } elseif ($jenis_vaksin == "8888") {
       $vaksin = "IDL NON IPV";
    } else {
        if ($jenis_vaksin <> "x") {
            $this->db->where("id_penyakit", $jenis_vaksin);
            $vaksin = $this->db->get("master_penyakit")->row();
            $vaksin = "Vaksin ".(($vaksin->nama_penyakit));
        } else {
            $vaksin = "Semua Vaksin";
        }
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
        $this->db->where("id_dusun",$id_dusun);
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
    
    Highcharts.chart('tampil_stat', {
        chart: {
            type: 'column'
        },

        title: {
            text: 'Pemantauan Wilayah Setempat (PWS) <?php echo $dusun.". ".$vaksin ?>',
        },

        subtitle: {
            
            text: 'Data PWS <?php echo $vaksin.". ".$thn.". ".$bln ?>'
        },
        xAxis: {
         categories: [<?php  
            $i = 1;
            foreach ($desa2->result() as $row) : 
                echo "'".(($row->desa))."',";
            endforeach;
            ?>]
        },



        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.2f} %</b>  </td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true,
        },
        yAxis: {
            title: {
                text: 'Persentase'
            }
        },

        plotOptions: {
            column: {
                dataLabels: {
                    enabled: true,
                    formatter: function () {
                        return Highcharts.numberFormat(this.y,2)+" %";
                    }
                },
                zones: [{
                    value: 29,
                    color: 'red'
                }, {
                    value: 40,
                    color: '#7cb5ec'
                }, {
                    color: '#90ed7d'
                }],

                enableMouseTracking: true
            }
        },

        colors: ['#087EC1','#9400D3','#D2810B'],
        series: [
        {
            <?php 
            $tahun_1 = $tahun - 1; 
            if ($jenis_vaksin == "9999") {?>
                name: 'Komulatif (%) <?php echo $vaksin ?> 01 <?php echo getBulan($bulan)." ".$tahun_1 ?> s/d <?php echo date("d")." ".getBulan($bulan)." ".$tahun ?>',
            <?php } else { ?>
                name: 'Komulatif (%) <?php echo $vaksin ?> Bulan Januari s/d <?php echo getBulan($bulan)." Tahun ".$tahun ?>',
            <?php  } ?>
          
          dataSorting: {
            enabled: false
        },
          data: 
          [<?php  
            foreach ($desa2->result() as $v) :
                $this->db->where("id_desa", $v->id_desa);
                $by = $this->db->get("im_tahun_vaksin_isi")->row();
                $byj = $by->bayi_si_l + $by->bayi_si_p;
                $bysi = 100/$byj;
                if ($jenis_vaksin == "9999") {
                    $this->db->where(array("id_dusun" => $id_dusun, "id_desa" => $v->id_desa)); 
                    $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bulan.'-01" and "'. $tahun.'-'.$bulan.'-'.date("d").'"');
                    $this->db->group_by("id_anak");
                    $this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
                    $this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
                    $idl = $this->db->get();
                    echo ($idl->num_rows() * $bysi).",";
                } elseif ($jenis_vaksin == "8888") {
                    $this->db->where(array("id_dusun" => $id_dusun, "id_desa" => $v->id_desa)); 
                    $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bulan.'-01" and "'. $tahun.'-'.$bulan.'-'.date("d").'"');
                    $this->db->group_by("id_anak");
                    $this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
                    $this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
                    $idl = $this->db->get();
                    echo ($idl->num_rows() * $bysi).",";
                } else {
                    if ($jenis_vaksin <> "x") {
                        $this->db->where("jenis_vaksin", $jenis_vaksin);
                    }
                    if ($tahun <> "x") {
                        $this->db->where("year(tgl_suntik)", $tahun);
                    }
                    if ($bulan <> "x") {
                         $this->db->where("month(tgl_suntik) BETWEEN 01 and ".$bulan." ");
                    }

                    $this->db->where("id_dusun",$id_dusun);
                    $this->db->where("id_desa", $v->id_desa);
                    $this->db->select("count(jenis_vaksin) as jumlah");
                    $j = $this->db->get("imunisasi")->row();
                    // echo $this->db->last_query();
                    $ha = $j->jumlah * $bysi;
                    if (is_nan($ha)) {
                        echo "0,";
                    } elseif (is_infinite($ha)) {
                        echo "0,";
                    } 
                    else {
                        echo ($j->jumlah * $bysi).",";
                    }
                }
            endforeach; ?>]
        },
        ]
    },function(chart){
        // if(chart.series[0].data.length == 0) 
        //     swal({   
        //          title: "Data tidak ditemukan",   
        //          type: "warning", 
        //          html: "Data Imunisasi belum ada untuk ditampilkan di Statistik",
        //          confirmButtonColor: "#22af47",   
        //     });
    });


</script>




<script type="text/javascript">
    Highcharts.chart('tampil_bulan', {
        chart: {
            type: 'column'
        },
           <?php $blnl = date('Y-m-d', strtotime('-1 month', strtotime($tahun."-".$bulan."-01")));
         ?>
        title: {
            <?php 
             if ($jenis_vaksin == "9999") {
                $waktu_awal = getBulan(substr($blnl, 5,2))." ".$tahun_1." S/d ". getBulan($bulan)." ".$tahun; 
             } else {
                if ($bulan <> "x") {
                    if ($bulan == "1") {
                        $tahun_1 = $tahun - 1;
                        $waktu_awal = getBulan(substr($blnl, 5,2))." ".$tahun_1." S/d ". getBulan($bulan)." ".$tahun; 
                    } else {
                        if ($tahun <> "x") {
                            $waktu_awal = getBulan(substr($blnl, 5,2))." S/d ". getBulan($bulan)." ".$tahun; 
                        }
                    }
                }
             }
                
            ?>

            text: '% <?php echo $waktu_awal ?><br><?php echo $dusun." ".$vaksin ?>',

        },

        subtitle: {
            
            text: 'Data PWS <?php echo $vaksin ?>'
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
            '<td style="padding:0"><b>{point.y:.2f} %</b>  </td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true,
        },
        yAxis: {
            title: {
                text: 'Persentase'
            }
        },

        plotOptions: {
            column: {
                dataLabels: {
                    enabled: true,
                    formatter: function () {
                        return Highcharts.numberFormat(this.y,2)+" %";
                    }
                },
               
                enableMouseTracking: true
            }
        },

        colors: ['#087EC1','#9400D3','#D2810B'],
        series: [
       
     
        {
        <?php 
        if ($jenis_vaksin == "9999") {?>
            name: '% Bulan lalu (<?php echo getBulan(substr($blnl, 5,2)) ?>).<br>Cakupan <?php echo $vaksin ?> 01 <?php echo getBulan(substr($blnl, 5,2))." ".$tahun_1 ?> - <?php echo date("d")." ".getBulan(substr($blnl, 5,2))." ".$tahun ?>',
        <?php } else {?>
             name: 'Bulan lalu (<?php echo getBulan(substr($blnl, 5,2)) ?>) ',
        <?php  } ?>
          data: 
          [<?php  
            foreach ($desa->result() as $v) :
                $this->db->where("id_desa", $v->id_desa);
                $by = $this->db->get("im_tahun_vaksin_isi")->row();
                $byj = $by->bayi_si_l + $by->bayi_si_p;
                $bysi = 100/$byj;
                if ($jenis_vaksin == "9999") {
                    $this->db->where(array("id_dusun" => $id_dusun, "id_desa" => $v->id_desa)); 
                    $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.substr($blnl, 5,2).'-01" and "'. $tahun.'-'.substr($blnl, 5,2).'-'.date("d").'"');
                    $this->db->group_by("id_anak");
                    $this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
                    $this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
                    $idl = $this->db->get();
                    echo ($idl->num_rows() * $bysi).",";
                } elseif ($jenis_vaksin == "8888") {
                   $this->db->where(array("id_dusun" => $id_dusun, "id_desa" => $v->id_desa)); 
                   $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.substr($blnl, 5,2).'-01" and "'. $tahun.'-'.substr($blnl, 5,2).'-'.date("d").'"');
                   $this->db->group_by("id_anak");
                   $this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
                   $this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
                   $idl = $this->db->get();
                   echo ($idl->num_rows() * $bysi).",";
                } else {
                    if ($jenis_vaksin <> "x") {
                        $this->db->where("jenis_vaksin", $jenis_vaksin);
                    }
                    if ($bulan <> "x") {
                        if ($bulan == "1") {
                            $tahun_1 = $tahun - 1;
                            $this->db->where("year(tgl_suntik)", $tahun_1);
                            $this->db->where("month(tgl_suntik)",substr($blnl, 5,2));
                        } else {
                            if ($tahun <> "x") {
                                $this->db->where("year(tgl_suntik)", $tahun);
                                $this->db->where("month(tgl_suntik)",substr($blnl, 5,2));
                            }
                        }
                    }

                    $this->db->where("id_dusun",$id_dusun);
                    $this->db->where("id_desa", $v->id_desa);
                    $this->db->select("count(jenis_vaksin) as jumlah");
                    $j = $this->db->get("imunisasi")->row();
                    if (is_nan($j->jumlah * $bysi)) {
                        echo "0,";
                    }  elseif (is_infinite($j->jumlah * $bysi)) {
                        echo "0,";
                    } else {
                        echo ($j->jumlah * $bysi).",";
                    }
                }
                
            endforeach; ?>]
        },
         {
        <?php 
            if ($jenis_vaksin == "9999") {?>
            name: '% Bulan ini (<?php echo getBulan($bulan) ?>).<br>Cakupan <?php echo $vaksin ?> 01 <?php echo getBulan($bulan)." ".$tahun_1 ?> - <?php echo date("d")." ".getBulan($bulan)." ".$tahun ?>',
            <?php } else {?>
            name: 'Bulan ini (<?php echo getBulan($bulan) ?>) ',
            <?php  } ?>
          
          data: 
          [<?php  
            foreach ($desa->result() as $v) :
                $this->db->where("id_desa", $v->id_desa);
                $by = $this->db->get("im_tahun_vaksin_isi")->row();
                $byj = $by->bayi_si_l + $by->bayi_si_p;
                $bysi = 100/$byj;
                if ($jenis_vaksin == "9999") {
                   $this->db->where(array("id_dusun" => $id_dusun, "id_desa" => $v->id_desa)); 
                   $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bulan.'-01" and "'. $tahun.'-'.$bulan.'-'.date("d").'"');
                   $this->db->group_by("id_anak");
                   $this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
                   $this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
                   $idl = $this->db->get();
                   echo ($idl->num_rows() * $bysi).",";
                } elseif ($jenis_vaksin == "8888") {
                    $this->db->where(array("id_dusun" => $id_dusun, "id_desa" => $v->id_desa)); 
                    $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bulan.'-01" and "'. $tahun.'-'.$bulan.'-'.date("d").'"');
                    $this->db->group_by("id_anak");
                    $this->db->having("sum(jenis_vaksin) = '1272' or sum(jenis_vaksin) = '1255'");
                    $this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
                    $idl = $this->db->get();
                   echo ($idl->num_rows() * $bysi).",";
                } else {
                    if ($jenis_vaksin <> "x") {
                        $this->db->where("jenis_vaksin", $jenis_vaksin);
                    }
                    if ($tahun <> "x") {
                        $this->db->where("year(tgl_suntik)", $tahun);
                    }
                    if ($bulan <> "x") {
                         $this->db->where("month(tgl_suntik)",$bulan);
                    }

                    $this->db->where("id_dusun",$id_dusun);
                    $this->db->where("id_desa", $v->id_desa);
                    $this->db->select("count(jenis_vaksin) as jumlah");
                    $j = $this->db->get("imunisasi")->row();
                    // echo $this->db->last_query();
                    if (is_nan($j->jumlah * $bysi)) {
                        echo "0,";
                    } elseif (is_infinite($j->jumlah * $bysi)) {
                        echo "0,";
                    } else {
                        echo ($j->jumlah * $bysi).",";
                    }
                }
                
            endforeach; ?>]
        },
        ]
    },function(chart){
        // if(chart.series[0].data.length == 0) 
        //     swal({   
        //          title: "Data tidak ditemukan",   
        //          type: "warning", 
        //          html: "Data Imunisasi belum ada untuk ditampilkan di Statistik",
        //          confirmButtonColor: "#22af47",   
        //     });
    });


</script>




<script type="text/javascript">
   
    Highcharts.chart('tampil_trend', {
        chart: {
            type: 'line'
        },

        title: {
            <?php 
             if ($jenis_vaksin == "9999") {
                $waktu_awal = getBulan(substr($blnl, 5,2))." ".$tahun_1." S/d ". getBulan($bulan)." ".$tahun; 
             } else {
                if ($bulan <> "x") {
                    if ($bulan == "1") {
                        $tahun_1 = $tahun - 1;
                        $waktu_awal = getBulan(substr($blnl, 5,2))." ".$tahun_1." S/d ". getBulan($bulan)." ".$tahun; 
                    } else {
                        if ($tahun <> "x") {
                            $waktu_awal = getBulan(substr($blnl, 5,2))." S/d ". getBulan($bulan)." ".$tahun; 
                        }
                    }
                }
             }
                
            ?>

            text: 'Trend <?php echo $waktu_awal ?><br><?php echo $dusun." ".$vaksin ?>',
        },

        subtitle: {
            
            text: 'Data PWS <?php echo $vaksin ?>'
        },
        
        <?php 
        if ($jenis_vaksin == "9999") {?>
            xAxis: {
                categories: ['<?php echo "01-".substr($blnl, 5,2)."-".$tahun_1 ?> s/d <?php echo date("d")."-".substr($blnl, 5,2)."-".$tahun ?>','<?php echo "01-".$bulan."-".$tahun_1 ?> s/d <?php echo date("d")."-".$bulan."-".$tahun ?>']
           },
        <?php } else {?>
            xAxis: {
               categories: ['<?php echo getBulan(substr($blnl, 5,2)) ?>','<?php echo getBulan($bulan) ?>']
           },
         <?php  } ?>

        



        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.2f} %</b>  </td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true,
        },
        yAxis: {
            title: {
                text: 'Persentase'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true,
                    formatter: function () {
                        return Highcharts.numberFormat(this.y,2)+" %";
                    }
                },
                enableMouseTracking: true
            }
        },
        // colors: ['#D20B66','#9400D3','#D2810B'],
        series: [

      
        <?php 
        ?>
        <?php foreach ($desa->result() as $v) :?>
            {
                name : '<?php echo $v->desa ?>',
                data : [
                <?php $this->db->where("id_desa", $v->id_desa);
                $by = $this->db->get("im_tahun_vaksin_isi")->row();
                $byj = $by->bayi_si_l + $by->bayi_si_p;
                $bysi = 100/$byj;
                if ($jenis_vaksin == "9999") {

                    $this->db->where(array("id_dusun" => $id_dusun, "id_desa" => $v->id_desa)); 
                    $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.$bulan.'-01" and "'. $tahun.'-'.$bulan.'-'.date("d").'"');
                    $this->db->group_by("id_anak");
                    $this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
                    $this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
                    $idla = $this->db->get();
                    $a1 =  ($idla->num_rows() * $bysi);

                    $this->db->where(array("id_dusun" => $id_dusun, "id_desa" => $v->id_desa)); 
                    $this->db->where('tgl_suntik BETWEEN "'. $tahun_1. '-'.substr($blnl, 5,2).'-01" and "'. $tahun.'-'.substr($blnl, 5,2).'-'.date("d").'"');
                    $this->db->group_by("id_anak");
                    $this->db->having("sum(jenis_vaksin) = '1393' or sum(jenis_vaksin) = '1376'");
                    $this->db->select("sum(jenis_vaksin) as idl_ipv, nama,jk,id_anak")->from("imunisasi");
                    $idlb = $this->db->get();
                    $a2 = ($idlb->num_rows() * $bysi);
                    if (is_nan($a2) or is_nan($a1)) {
                        echo "0","0,";
                    } elseif (is_infinite($a2) or is_infinite($a1)) {
                        echo "0,0";
                    }else {
                        echo ($a2.",".$a1).",";
                    }

                } else {
                    if ($jenis_vaksin <> "x") {
                        $this->db->where("jenis_vaksin", $jenis_vaksin);
                    }
                    if ($tahun <> "x") {
                        $this->db->where("year(tgl_suntik)", $tahun);
                    }
                    if ($bulan <> "x") {
                         $this->db->where("month(tgl_suntik)",$bulan);
                    }

                    $this->db->where("id_dusun",$id_dusun);
                    $this->db->where("id_desa", $v->id_desa);
                    $this->db->select("count(jenis_vaksin) as jumlah");
                    $j = $this->db->get("imunisasi")->row();
                    // echo $this->db->last_query();
                
                    $a1 =  ($j->jumlah * $bysi);

                    if ($jenis_vaksin <> "x") {
                        $this->db->where("jenis_vaksin", $jenis_vaksin);
                    }
                    if ($tahun <> "x") {
                        $this->db->where("year(tgl_suntik)", $tahun);
                    }
                    if ($bulan <> "x") {
                         if ($bulan == "1") {
                            $tahun_1 = $tahun - 1;
                            $this->db->where("year(tgl_suntik)", $tahun_1);
                            $this->db->where("month(tgl_suntik)",substr($blnl, 5,2));
                         } else {
                            if ($tahun <> "x") {
                                $this->db->where("year(tgl_suntik)", $tahun);
                                $this->db->where("month(tgl_suntik)",substr($blnl, 5,2));
                            }
                         }
                    }

                    $this->db->where("id_dusun",$id_dusun);
                    $this->db->where("id_desa", $v->id_desa);
                    $this->db->select("count(jenis_vaksin) as jumlah");
                    $j = $this->db->get("imunisasi")->row();
                    // echo $this->db->last_query();
                    $a2 = ($j->jumlah * $bysi);
                    if (is_nan($a2) or is_nan($a1)) {
                        echo "0","0,";
                    } elseif (is_infinite($a2) or is_infinite($a1)) {
                        echo "0,0";
                    } else {
                        echo ($a2.",".$a1).",";
                    }
                }
                 ?>]
            },
        <?php endforeach ;?>
       
        ]
    },function(chart){
        // if(chart.series[0].data.length == 0) 
        //     swal({   
        //          title: "Data tidak ditemukan",   
        //          type: "warning", 
        //          html: "Data Imunisasi belum ada untuk ditampilkan di Statistik",
        //          confirmButtonColor: "#22af47",   
        //     });
    });

</script>

