<script type="text/javascript">
    var table;
    $(document).ready(function () {
        if (window.innerWidth > 767.98) { 
            $('#id_desa_cari, #tahun, #id_dusun_cari, #id_kecamatan, #filterStatus').select2({
            });
        }
        <?php if ($this->session->userdata('admin_level') !== 'admin') : ?>
            get_dusun(null, '#id_dusun_cari', 1);
            $('#id_dusun_cari').prop('disabled', false); 
        <?php endif; ?>
        $('#id_desa_cari').prop('disabled', true);
        $('#id_dusun_cari').prop('disabled', true);
        resetFormFilter(); 

        $.fn.dataTableExt.oApi.fnPagingInfo = function (oSettings) {
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };
        
        table = $('#datable_1').DataTable({
         "lengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
         initComplete: function () {
            var api = this.api();
            $('#datatable-buttons_filter input')
            .off('.DT')
            .on('input.DT', function () {
                api.search(this.value).draw();
            });
        },
        drawCallback: function () {
            tippy('[data-plugin="tippy"]', {
                animation: 'perspective',
                inertia: true,
                duration: [600, 300],
                arrow: true,
                placement: 'top'
            });
            $('html, body').animate({ scrollTop: 0 }, 'fast');
        },

        order: [],
        processing: true,
        serverSide: true,
        scrollX: true,
        responsive: true,
        bFilter:false,
        
        ajax: {
            "url": "<?php echo site_url(strtolower($controller) . '/get_data/'.$function_name) ?>",
            "type": "POST",
            "data": function (data) {
                data.id_kecamatan = $('#id_kecamatan').val();
                data.id_desa = $('#id_desa_cari').val();
                data.id_dusun = $('#id_dusun_cari').val();
                data.nama = $('#nama_cari').val();
                data.tahun = $('#tahun').val();
                data.status = $('#filterStatus').val();
            },
            "cache": false 
        },
        columns: [

        {
            data: null,
            orderable: false,
            className: "text-center",
            render: function (data, type, row) {
                return `
                <div class="d-flex justify-content-center align-items-center gap-1">
                <button class="btn btn-sm btn-primary btn-expand d-md-none" title="Lihat Detail">
                <i class="fas fa-eye"></i>
                </button>&nbsp;
                ${row.cek}
                </div>
                `;
            }
        },

        {
            data: null,
            orderable: false,
            className: "text-center d-none d-md-table-cell",
            render: function (data, type, row, meta) {
                return meta.row + meta.settings._iDisplayStart + 1;
            }
        },
        { "data": "nama", className: "d-none d-md-table-cell" },
        { "data": "nik" , className: "d-none d-md-table-cell" },
        { "data": "no_kk", className: "d-none d-md-table-cell" },
        { "data": "nama_pemohon" },
        { "data": "nama_dusun", className: "d-none d-md-table-cell" },
        <?php if ($this->session->userdata("admin_level") == "admin") { ?>
            { "data": "desa", className: "d-none d-md-table-cell" },
        <?php } ?>
        { "data": "update_time", className: "d-none d-md-table-cell" },
        { "data": "statusnya" }
        ],

        rowCallback: function (row, data, iDisplayIndex) {
         const info = table.page.info();
         const index = info.page * info.length + (iDisplayIndex + 1);
         $('td:eq(1)', row).html(index);
         if (data.is_status_row) {
            $(row).html(`
             
                <td style="text-align: center;">${data.cek}</td>
                <td class='d-none d-md-table-cell' style="text-align: center;">${index}</td>
                <td colspan="7" class="bg-soft-warning">${data.merge}</td>


                `);
        } else {

            $('td:eq(2)', row).html(data.nama);
            $('td:eq(3)', row).html(data.nik);
            $('td:eq(4)', row).html(data.no_kk);
            $('td:eq(5)', row).html(data.nama_pemohon);
            $('td:eq(6)', row).html(data.nama_dusun);
            <?php if ($this->session->userdata("admin_level") == "admin") : ?>
                $('td:eq(7)', row).html(data.desa);
                $('td:eq(8)', row).html(data.update_time);
            <?php endif; ?>
            $('td:eq(9)', row).html(data.statusnya);
        }
    },
    language: {
        sProcessing: "<i class='fas fa-spinner fa-spin text-primary'></i> Memuat...",
        sLengthMenu: "<i class='fas fa-list'></i> _MENU_",
        sZeroRecords: "<i class='fas fa-exclamation-circle text-danger'></i> Tidak ada data",
        sInfo: "<i class='fas fa-info-circle'></i> _START_ - _END_ dari _TOTAL_",
        sInfoEmpty: "<i class='fas fa-info-circle'></i> 0 - 0 dari 0",
        sInfoFiltered: "<i class='fas fa-filter'></i> dari _MAX_",
        sSearch: "<i class='fas fa-search'></i>",
        oPaginate: {
          sFirst: "<i class='fas fa-angle-double-left'></i>",
          sPrevious: "<i class='fas fa-angle-left'></i>",
          sNext: "<i class='fas fa-angle-right'></i>",
          sLast: "<i class='fas fa-angle-double-right'></i>"
      }
  }

});


function format(data) {
  return `
  <div class="card-box">
  <div class="row align-items-center">

  <div class="col-sm-10">
  <p class="mb-1 mt-sm-0">
  <i class="mdi mdi-account-circle-outline mr-1"></i>
  Nama Kepala Keluarga : ${data.nama || '-'}
  </p>
  <p class="mb-1 mt-sm-0">
  <i class="mdi mdi-account-card-details mr-1"></i>
  NIK : ${data.nik || '-'}
  </p>
  <p class="mb-1 mt-sm-0">
  <i class="mdi mdi-file-document-outline mr-1"></i>
  No. KK : ${data.no_kk || '-'}
  </p>
  <p class="mb-1 mt-sm-0">
  <i class="mdi mdi-account-outline mr-1"></i>
  Nama Pemohon : ${data.nama_pemohon || '-'}
  </p>
  <p class="mb-1 mt-sm-0">
  <i class="mdi mdi-home-city-outline mr-1"></i>
  Dusun : ${data.nama_dusun || '-'}
  </p>
  <?php if ($this->session->userdata("admin_level") == "admin") : ?>
    <p class="mb-1 mt-sm-0">
    <i class="mdi mdi-map-outline mr-1"></i>
    Desa : ${data.desa || '-'}
    </p>
<?php endif; ?>
<p class="mb-1 mt-sm-0">
<i class="mdi mdi-calendar mr-1"></i>
Tanggal : ${data.update_time || '-'}
</p>
<p class="mb-1 mt-sm-0">
<i class="mdi mdi-check-circle-outline mr-1"></i>
Status : ${data.statusnya || '-'}
</p>
</div>

<div class="col-sm-2">
<div class="text-center mt-1 mt-sm-0">
<!-- Aksi atau tombol tambahan -->
</div>
</div>

</div>
</div>
`;
}

$('#datable_1 tbody').on('click', '.btn-expand', function () {
    const tr = $(this).closest('tr');
    const row = table.row(tr);
    const icon = $(this).find('i');

    if (row.child.isShown()) {
      row.child.hide();
      tr.removeClass('shown');
      icon.removeClass('fa-eye-slash').addClass('fa-eye');
  } else {
      row.child(format(row.data())).show();
      tr.addClass('shown');
      icon.removeClass('fa-eye').addClass('fa-eye-slash');
  }
});


$('#btn-filter').click(function () {
    reload_table();
});


$('#btn-reset').on('click', function() {
    resetFormFilter()
    reload_table();
});

});


function reload_table() {
    table.ajax.reload();  // reload DataTable dengan data terbaru
}

function resetFormFilter() {
        $('#form-filter')[0].reset(); // reset form biasa

        $('#id_kecamatan').val(null).trigger('change');
        $('#id_desa_cari').val(null).trigger('change');
        $('#id_dusun_cari').val(null).trigger('change');
        $('#tahun').val(null).trigger('change');
        $('#filterStatus').val(null).trigger('change');
        $('#nama_cari').val('');
    }



    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });

    function reset_select(){
     $('#tahun,#id_desa_cari,#id_dusun_cari,#id_kecamatan').val('').trigger('change');
 }

 function loader() {
    Swal.fire({
        title: "Prosess...",
        html: "Jangan tutup halaman ini",
        allowOutsideClick: false,
        onBeforeOpen: function() {
            Swal.showLoading()
        },
        onClose: function() {
            clearInterval(t)
        }
    })
}

function add(){ 
    save_method = 'add';
    $('#form_app')[0].reset(); 
    reset_select();
    $('#id_paket').val("");
    $('#full-width-modal').modal('show'); 
    $('.mymodal-title').text('Tambah Data'); 
}

function simpan() {
    var tabel = "<?php echo $nama_tabel ?>";
    var url = (save_method === 'add')
    ? "<?php echo site_url(strtolower($controller) . '/add/') ?>" + tabel
    : "<?php echo site_url(strtolower($controller) . '/update/') ?>" + tabel;

    $('#form_app').form('submit', {
        url: url,
        onSubmit: function () {
            loader(); 
            return $(this).form('validate');
        },
        success: function(result){
            let obj;
            try {
                obj = (typeof result === 'object') ? result : $.parseJSON(result);
            } catch (e) {
                console.error("Gagal parsing response:", result);
                swal.fire({
                    title: "Error",
                    icon: "error",
                    html: "Gagal memproses data dari server."
                });
                return;
            }

            if (!obj.success){
                swal.fire({
                    title: obj.title || "Gagal",
                    icon: "error",
                    html: obj.pesan || "Terjadi kesalahan."
                });
                return;
            }

            Swal.fire({
                title: obj.title,
                html: obj.pesan,
                icon: "success",
            }).then(() => {
                $("#full-width-modal").modal("hide");
                reload_table();

                if (save_method === 'add' && obj.data_wa) {
                    $.post('<?php echo site_url(strtolower($controller).'/kirim_wa') ?>', obj.data_wa, function(waRes){
                        if (waRes.success){
                            console.log("WA terkirim");
                        } else {
                            console.warn("Gagal kirim WA");
                        }
                    }, 'json');
                    var id_paket = (obj.data_wa.id_paket || "").trim();
                    var tabel = (obj.data_wa.tabel || "").trim();


                    window.location.href = "<?php echo site_url(strtolower($controller).'/proses_detail_paket/') ?>" + obj.data_wa.tabel + "/" + obj.data_wa.id_paket;
                }
            });
        }
    });
}

function edit_data() {
    var tabel = "<?php echo $nama_tabel ?>";
    $('#form_app')[0].reset(); 
    reset_select();
    loader();
    var list_id = [];
    var blocked = false;  
    
    $(".data-check:checked").each(function() {
        var status = $(this).data("status");
        if (status == 2) {
            Swal.fire("Info", "⏳ Permohonan ini telah diproses dan saat ini dalam tahap verifikasi oleh Dinas Dukcapil.", "warning");
            blocked = true;
            return false; 
        }
        if (status == 3) {
            Swal.fire("Info", "✅ Permohonan yang telah disetujui tidak dapat di edit lagi.", "warning");
            blocked = true;
            return false; 
        }

        list_id.push(this.value);
    });
    if (blocked) return;
    
    if(list_id.length == 1) { 
        save_method = 'update';
        $.ajax({
            url : "<?php echo site_url(strtolower($controller).'/edit_data')?>/"+ tabel +"/" + list_id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                Swal.close();
                $('#id_paket').val(data.id_paket);
                $('#nama_pemohon').val(data.nama_pemohon);
                $('#id_dusun').val(data.id_dusun).trigger('change');
                $('#no_wa_pemohon').val(data.no_wa_pemohon);
                $('#alasan_permohonan').text(data.alasan_permohonan); // untuk textarea, .text() juga bisa
                $('#full-width-modal').modal('show'); 
                $('.mymodal-title').html('Edit Data <code>'+ data.nama_pemohon+'</code>'); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    } else if (list_id.length >= 2) {
        Swal.fire("Info", "Tidak dapat mengedit " + list_id.length + " data sekaligus, Pilih satu data saja", "warning");
    } else {
        Swal.fire("Info", "Pilih Satu Data", "warning");
    }
}


function edit() {

    loader();

    var list_id = [];
    var blocked = false;

    $(".data-check:checked").each(function() {
        var status = $(this).data("status");

        if (status == 2) {
            Swal.fire("Info", "⏳ Permohonan ini telah diproses dan saat ini dalam tahap verifikasi oleh Dinas Dukcapil.", "warning");
            blocked = true;
            return false; 
        }

        if (status == 3) {
            Swal.fire("Info", "✅ Permohonan yang telah disetujui tidak dapat diproses lagi.", "warning");
            blocked = true;
            return false; 
        }

        list_id.push(this.value);
    });

    if (blocked) return;

    if (list_id.length == 1) {
        window.location.href = "<?php echo site_url(strtolower($controller) . '/proses_detail_paket/' . $nama_tabel) ?>/" + list_id[0];
    } else if (list_id.length >= 2) {
        Swal.fire("Info", "Tidak dapat mengedit " + list_id.length + " data sekaligus, Pilih satu data saja", "warning");
    } else {
        Swal.fire("Info", "Pilih Satu Data", "warning");
    }
}

function detail() {
    loader();
    var list_id = [];

    $(".data-check:checked").each(function() {
        list_id.push(this.value);
    });

    if (list_id.length == 1) {
        window.location.href = "<?php echo site_url(strtolower($controller) . '/detail_pemohon/' . $nama_tabel) ?>/" + list_id[0];
    } else if (list_id.length >= 2) {
        Swal.fire("Info", "Tidak dapat melihat " + list_id.length + " data sekaligus, Pilih satu data saja", "warning");
    } else {
        Swal.fire("Info", "Pilih Satu Data", "warning");
    }
}

function hapus_data() {
    var list_id = [];
    var blocked = false;

    $(".data-check:checked").each(function () {
        var status = $(this).data("status");
        var id = this.value;

        if (status == 2) {
            Swal.fire("Info", "⏳ Permohonan tidak dapat dihapus.<br>Sedang menunggu verifikasi dari Dukcapil.", "warning");
            blocked = true;
            return false; // stop loop
        }

        if (status == 3) {
            Swal.fire("Info", "✅ Permohonan yang telah disetujui tidak dapat dihapus.", "warning");
            blocked = true;
            return false; // stop loop
        }

        list_id.push(id);
    });

    if (blocked) return;

    if (list_id.length > 0) {
        Swal.fire({
            title: "Yakin ingin menghapus " + list_id.length + " data?",
            text: "Anda tidak dapat mengembalikan data terhapus.",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya, Hapus",
            cancelButtonText: "Batal",
            allowOutsideClick: false,
        }).then((result) => {
            if (result.value) {
                loader();
                $.ajax({
                    type: "POST",
                    url: "<?= site_url(strtolower($controller).'/hapus_data/'.$function_name) ?>",
                    data: { id: list_id },
                    dataType: "json",
                    success: function (result) {
                        Swal.close();
                        reload_table();
                        if (result.success == false) {
                            Swal.fire(result.title, result.pesan, "error");
                        } else {
                            Swal.fire(result.title, result.pesan, "success");
                        }
                    },
                    error: function () {
                        Swal.fire("Error", "Terjadi kesalahan saat menghapus data.", "error");
                    }
                });
            }
        });
    } else {
        Swal.fire("Info", "Pilih satu data terlebih dahulu.", "warning");
    }
}


function close_modal(){
    Swal.fire({
        title: "Yakin ingin menutup ?",
        text: "Anda tidak dapat mengembalikan data yang belum tersimpan",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Tutup",
        cancelButtonText: "Batal",
        allowOutsideClick: false,
    }).then((result) => {
        if (result.value) {
            $("#full-width-modal").modal("hide");
        } 
    })
}

function get_desa(el, target, init = 0) {
    const id_kecamatan = $(el).val();
    $(target).html('<option value="">Memuat...</option>').prop('disabled', true);

    if (id_kecamatan !== "") {
        $.post("<?= site_url('admin_permohonan/get_desa') ?>", { id_kecamatan }, function(response) {
            $(target).html(response).prop('disabled', false);
        });
    } else {
        $(target).html('<option value="">- Semua Desa -</option>').prop('disabled', true);
    }
}

function get_dusun(el = null, target = '#id_dusun_cari', init = 0) {
    let id_desa;

    <?php if ($this->session->userdata('admin_level') === 'admin') : ?>
        id_desa = $(el).val();
        <?php else : ?>
            id_desa = "<?= $this->session->userdata('id_desa') ?>";
        <?php endif; ?>

        $(target).html('<option value="">Memuat...</option>').prop('disabled', true);

        if (id_desa !== "") {
            $.post("<?= site_url('admin_permohonan/get_dusun') ?>", { id_desa }, function(response) {
                $(target).html(response).prop('disabled', false);
            });
        } else {
            $(target).html('<option value="">- Semua Dusun -</option>').prop('disabled', true);
        }
    }

    $(document).on('keydown', 'input', function(event) {
        if (event.key === "Enter") {
            event.preventDefault(); 
            return false;
        }
    });
    
    window.addEventListener("pageshow", function(event) {
        if (event.persisted || (window.performance && window.performance.navigation.type === 2)) {
            Swal.close(); 
        }
    });
</script>
