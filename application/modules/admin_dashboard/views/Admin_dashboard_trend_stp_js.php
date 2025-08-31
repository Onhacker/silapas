<script type="text/javascript">
    Highcharts.chart('tren_new_stp', {
        chart: {
            type: 'line'
        },

        title: {
            text: 'Trend Bulanan STP. <?php echo " Tahun ".date("Y") ?> ',
        },

        subtitle: {
            text: 'RS dan dusun, Rawat Inap dan Jalan Semua Penyakit '
        },
        xAxis: {
         categories: [<?php  
            foreach ($isi_stp->result() as $row) : 
                echo "'".(getBulan($row->bulan))."',";
            endforeach;
            ?>]
        },



        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0"> {series.name}: </td>' +
            '<td style="padding:0"><b>{point.y:.0f} Orang</b>  </td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        yAxis: {
            title: {
                text: 'Orang'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: true
            }
        },
        colors: ['#28a745', '#e2a03f', '#e7515a','#F633FF'],
        series: [
        {
          name: 'Semua Umur',
          data: [<?php  foreach ($isi_stp->result() as $row) : 
            echo ($row->suma).",";
            endforeach; ?>]
        },
        {
          name: 'Laki - Laki',
          data: [<?php  foreach ($isi_stp->result() as $row) : 
            echo ($row->l).",";
            endforeach; ?>]
        },
        {
          name: 'Perempuan',
          data: [<?php  foreach ($isi_stp->result() as $row) : 
            echo ($row->p).",";
            endforeach; ?>]
        },
        {
          name: 'Kasus Baru',
          data: [<?php  foreach ($isi_stp->result() as $row) : 
            echo ($row->kasus_baru).",";
            endforeach; ?>]
        },


        ]
    });
</script>