<script type="text/javascript">
    var table;
    $(document).ready(function(){
        
        $('#id_desa_cari,#tahun_cari,#id_dusun_cari').select2();

        $('#id_desa').select2({
            dropdownParent: $('#full-width-modal')
        });
        // $("#tgl_lahir").datepicker({minDate:"2020-01",maxDate:"2020-03"})
        $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings){
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
            "lengthMenu": [ [10, 25, 50, 100, -1], [10, 25, 50, 100, "All"] ],
            initComplete: function() {
                var api = this.api();
                $('#datatable-buttons_filter input')
                .off('.DT')
                .on('input.DT', function() {
                    api.search(this.value).draw();
                });
            },
            oLanguage: {
                sProcessing     :   '<button class="btn btn-primary" type="button"><span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span> Memuat... </button>',
                sSearch         :   "<i class='ti-search'></i>",
                sSearchPlaceholder: 'Cari Nama/No. WA',
                sZeroRecords    :   "Maaf Data Tidak Ditemukan",
                sLengthMenu     :   "Tampil _MENU_ Data",
                sEmptyTable     :   "Data Tidak Ada",
                sInfo           :   "Menampilkan _START_ -  _END_ dari _TOTAL_ Total Data",
                sInfoEmpty      :   "Tidak ada data ditampilkan",
                sInfoFiltered   :   "",
                "oPaginate"     :   {
                    "sNext": "<i class='fe-chevrons-right'></i>",
                    "sPrevious": "<i class='fe-chevrons-left'></i>"
                },
            },
            "scrollX": true,
            processing: true,
            serverSide: true,
            // bFilter: false,
            ajax: {
                "url": "<?php echo site_url(strtolower($controller)."/get_data")?>", 
                "type": "POST",
            },

            columns: [
            {"data": "cek","orderable": false},
            {"data": "id","orderable": false},
            {"data": "nama"}, 
            {"data": "no_wa"},
            {"data": "nama_permohonan"},
            {"data": "nama_dusun"},
            <?php if ($this->session->userdata("admin_level") == "admin") {?>
                {"data": "desa"},
            <?php } ?>
            {"data": "tgl_reg"},
            ],

            "order": [],
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(1)', row).html(index); // masukkan index untuk menampilkan no urut
            }
        });

        $('#btn-filter').click(function(){ //button filter event click
           reload_table()  //just reload table
       });
        $('#btn-reset').click(function(){ //button reset event click
            $('#form-filter')[0].reset();
            reset_select();
            reload_table(); //just reload table
        });
    });

    function load_profil(){
        $.ajax({
            url : " <?php echo site_url(strtolower($controller)."/get_data/") ?>",
            cache:false,
            type : "POST",
            data : function ( data ) {
                data.id_desa = $('#id_desa_cari').val();
                data.nama = $('#nama_cari').val();
                data.no_kk = $('#no_kk_cari').val();
                data.jk = $('#jk_cari').val();
            },
            dataType : "json",
            success : function(result){
                $("#nama_f").text("Nama "+result.nama);
            }
        })
    }
    

    function reload_table() {
        table.ajax.reload(null,false); 
    }

    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });

    function reset_select(){
     $('#id_agama,#id_desa,#id_pekerjaan_ayah,#id_pekerjaan_ibu,#id_desa_cari,#id_dusun').val('').trigger('change');
     $('#tahun_cari').val(<?php echo date("Y"); ?>).trigger('change');
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
    $('#id_reg').val("");
    $('#full-width-modal').modal('show'); 
    $('.mymodal-title').text('Tambah Data'); 
}

function edit() {
    $('#form_app')[0].reset(); 
    reset_select();
    loader();
    var list_id = [];
    $(".data-check:checked").each(function() {
        list_id.push(this.value);
    });
    
    if(list_id.length == 1) { 
        save_method = 'update';
        $.ajax({
            url : "<?php echo site_url(strtolower($controller).'/edit')?>/" + list_id,
            type: "GET",
            dataType: "JSON",
            success: function(data) {
                Swal.close();
                $('#id_reg').val(data.id_reg);
                $('#nama').val(data.nama);
                $('#id_dusun').val(data.id_dusun).trigger('change');
                $('#no_wa').val(data.no_wa);
                $('#id_permohonan').val(data.id_permohonan);
                $('#full-width-modal').modal('show'); 
                $('.mymodal-title').html('Edit Data <code>'+ data.nama+'</code>'); 
            },
            error: function (jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });
    } else if (list_id.length >= 2) {
        Swal.fire("Info","Tidak dapat mengedit "+list_id.length+" data sekaligus, Pilih satu data saja", "warning");
    } else {
        Swal.fire("Info","Pilih Satu Data", "warning");
    }
}

function simpan() {
    var url = (save_method === 'add') 
    ? "<?php echo site_url(strtolower($controller).'/add') ?>"
    : "<?php echo site_url(strtolower($controller).'/update') ?>";

    $('#form_app').form('submit', {
        url: url,
        onSubmit: function () {
                loader(); // Tampilkan loader
                return $(this).form('validate');
            },
            dataType: 'json',
            success: function(result){
                obj = $.parseJSON(result);
                if (!obj.success){
                    swal.fire({
                        title: obj.title,
                        type: "error",
                        html: obj.pesan
                    });
                    return;
                }

                Swal.fire({
                    title: obj.title,
                    html: obj.pesan,
                    type: "success",
                }).then(() => {
                    // Langsung tutup modal dan reload table dulu
                    $("#full-width-modal").modal("hide");
                    reload_table();
                    // Hanya kirim WA jika save_method === 'add'
                    if (save_method === 'add' && obj.data_wa) {
                        $.post('<?php echo site_url(strtolower($controller).'/kirim_wa') ?>', obj.data_wa, function(waRes){
                            if(waRes.success){
                                console.log("Pesan WA berhasil dikirim");
                            } else {
                                console.warn("Gagal kirim WA");
                            }
                            // console.log("Response kirim_wa:", waRes); // optional debug
                        }, 'json');
                    }
                    
                });
            }
        });
}



function hapus_data() {
    var list_id = [];
    $(".data-check:checked").each(function() {
      list_id.push(this.value);
  });
    if(list_id.length > 0) { 
        Swal.fire({
            title: "Yakin ingin menghapus "+list_id.length+" data ?",
            text: "Anda tidak dapat mengembalikan data terhapus",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Ya Hapus",
            cancelButtonText: "Batal",
            allowOutsideClick: false,
        }).then((result) => {
            if (result.value) {
                loader();
                $.ajax({
                    type: "POST",
                    url : "<?php echo site_url(strtolower($controller).'/hapus_data')?>/",
                    data: {id:list_id},
                    cache : false,
                    dataType: "json",
                    success: function(result) {
                        Swal.close();
                        reload_table();
                        if(result.success == false){
                            Swal.fire(result.title,result.pesan, "error");
                            return false;
                        } else {
                            Swal.fire(result.title,result.pesan, "success");
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        alert("fucks");
                    }
                });
            } else {
                    // $('#summernote').summernote("insertImage", src);
                }
            })
    } else {
        Swal.fire("Info","Pilih Satu Data", "warning");
    }
}

function cetak() {
    var list_id = [];
    $(".data-check:checked").each(function() {
      list_id.push(this.value);
  });
    if(list_id.length == 1) { 
        window.open("<?php echo site_url(strtolower($controller)."/pdf/") ?>"+list_id)
    } else if (list_id.length >= 2) {
        Swal.fire("Info","Tidak dapat Mencetak "+list_id.length+" data sekaligus, Pilih satu data saja", "warning");
    } else {
        Swal.fire("Info","Pilih Satu Data", "warning");
    }
}



function close_modal(){
    Swal.fire({
        title: "Yakin ingin menutup ?",
        text: "Anda tidak dapat mengembalikan data yang belum tersimpan",
        type: "warning",
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


<?php if ($this->session->userdata("admin_level") == "admin") {?>
    function get_desa(id,target,dropdown){
        $("#loading").html('Loading data....');
        console.log('id kecamatan' + $(id).val() );
        $.ajax({
            url:'<?php echo site_url(strtolower($controller)."/get_desa"); ?>/'+$(id).val()+'/'+dropdown,
            success: function(data){
                $("#loading").hide();
                $(target).html('').append(data);
            }
        });
    }
<?php  } ?>

function handleCardClick(id) {
    window.location.href = "<?php echo site_url('admin_permohonan/handle_card_click/') ?>" + id;
}

function showToast(el) {
    const toast = el.nextElementSibling;
    toast.style.display = "block";
}

function hideToast(el) {
    const toast = el.nextElementSibling;
    toast.style.display = "none";
}

$('#searchBtn').click(function () {
    const keyword = $('#searchInput').val().trim();
    if (keyword === '') {
        Swal.fire("Info", "Masukkan kata kunci pencarian", "warning");
        return;
    }
    $('#resultContainer').html(
        '<div class="col-12 text-center">' +
        '<div class="spinner-grow avatar-md text-primary" role="status">' +
        '<span class="sr-only">Loading...</span>' +
        '</div>' +
        '<p class="mt-3">Sedang mencari <code>'+keyword+'</code>, harap tunggu...</p>' +
        '</div>'
        ).show();

    $.ajax({
        url: '<?= base_url("admin_permohonan/search") ?>',
        type: 'POST',
        data: { keyword: keyword },
        success: function (res) {
            var keyword = $('#searchInput').val().trim();
            $('#searchTitle').show();
            $('#searchTitle').html("<h4>Hasil Pencarian untuk: <strong><code>" + keyword + "</code></strong></h4>");
            $('#defaultContainer').fadeOut('400', function() {
                $('#resultContainer').fadeIn('400').html(res);
            });

            // Menunggu rendering selesai sebelum menghitung elemen
            setTimeout(function() {
                // Menghitung jumlah elemen yang sesuai (misalnya .card-box)
                let totalResults = $('#resultContainer').find('.card-box').length;

                console.log("Jumlah hasil pencarian: " + totalResults);  // Cek jumlah hasil di console

                if (totalResults < 10) {  // Sesuaikan dengan jumlah minimum yang kamu inginkan
                    $('#loadMoreBtn').hide();  // Menyembunyikan tombol "Load More" jika hasil pencarian kurang dari 5
                } else {
                    $('#loadMoreBtn').show();  // Menampilkan tombol "Load More" jika hasil pencarian >= 5
                }
            }, 500);  // Memberikan delay kecil untuk memastikan rendering selesai
        },
        error: function () {
            $('#resultContainer').html(
                '<div class="col-12 text-center text-danger">Terjadi kesalahan saat mencari.</div>'
                ).show();
        }
    });
});



$('#searchInput').on('keypress', function (e) {
    if (e.which === 13) {
        $('#searchBtn').click();
    }
});

$('#resetBtn').click(function () {
    $('#searchInput').val('');                  
    $('#searchTitle').hide();                   
    $('#resultContainer').hide().empty();       
    $('#defaultContainer').fadeIn();  
    $('#loadMoreBtn').show();     
});



</script>
