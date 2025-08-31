<?php if ($wk->num_rows() == 0) {
   echo "Data tidak ditemukan. Belum ada pelaporan Minggu ke ".($mg)." Tahun ".$tg;
} else {?>


<script type="text/javascript">
   Highcharts.chart('tren_terkini_w_dua', {
    chart: {
        type: 'column'
    },
    title: {
        text: 'Pantauan Pelaporan W2 Minggu ke <?php echo $ming ?>. Bulan <?php echo getBulan($wakti->bulan). " Tahun ".$wakti->tahun ?>'
    },
      subtitle: {
            text: '<?php echo $jml ?> Data belum dilaporkan'
        },
    xAxis: {
    categories: [<?php  
            foreach ($resi->result() as $row) : 
             
                        echo "' ".$this->om->bentuk_admin($row->id_dusuna,"l")." ".(($row->nama_dusun))."',";
                   
            endforeach;
            ?>]
        },
    yAxis: {
        min: 0,
        title: {
            text: 'Progress'
        }
    },
    tooltip: {
        pointFormat: '<span style="color:{series.color}">{series.name}</span><br/>',
        shared: true
    },
    plotOptions: {
        column: {
            stacking: 'normal',
            dataLabels: {
                    enabled: false
                },
        },
       
    },
    colors: ['#2C66F6', '#e7515a','#F633FF'],
    series: [
    {
        name: 'Selesai',
        data: [<?php foreach($resi->result() as $row) : 
            $dcf = $this->db->query("select * from w_dua where id_dusun = ".$row->id_dusuna."  and  tahun  = '".$wakti->tahun."' and minggu_ke = '".$ming."'  GROUP by id_dusun");
            // echo $this->db->last_query();
            if ($dcf->num_rows() > 0) {
                 echo "50,";
            }else {
                 echo "0,";
            }
               
                endforeach;
         ?>]
    }
    ]
});
        
</script>
<?php } ?>