<script type="text/javascript">
    var table;
    $(document).ready(function(){
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
                sProcessing     :   "Memuat Data...",
                sSearch         :   "<i class='ti-search'></i> Cari :",
                sZeroRecords    :   "Maaf Data Tidak Ditemukan",
                sLengthMenu     :   "Tampil _MENU_ Data",
                sEmptyTable     :   "Data Tidak Ada",
                sInfo           :   "Tampil _START_ -  _END_ dari _TOTAL_ Total Data",
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
            responsive: true,
            ajax: {"url": "<?php echo site_url(strtolower($controller)."/get_data_faskes")?>", "type": "POST"},

            columns: [
                {"data": "cek","orderable": false},
                {"data": "id","orderable": false},
                {"data": "foto","orderable": false},
                {"data": "username"}, 
               
                {"data": "nama_lengkap"}, 
                {"data": "fasilitas_kesehatan"}, 
                
                {"data": "no_telp"}, 
               
                // {"data": "identitas","orderable": false}, 
            ],
            columnDefs: [
                { targets: 2, className: 'text-left' } // Indeks 2 adalah kolom "foto"
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
    });

    function reload_table() {
        table.ajax.reload(null,false); 
    }

    $("#check-all").click(function () {
        $(".data-check").prop('checked', $(this).prop('checked'));
    });

    function refresh(){
        reload_table();
    }

    function loader() {
        Swal.fire({
            title: "Prosess...",
            html: "Jangan tutup halaman ini",
            allowOutsideClick: false,
            didOpen: function() {
                Swal.showLoading()
            }
        })
    }


    function pub(id){
        loader();
        $.ajax({
            type: "POST",
            url : "<?php echo site_url(strtolower($controller).'/pub')?>/" + id,
            cache : false,
            dataType: "json",
            success: function(result) {
                Swal.close();
                reload_table();
                if(result.success == false){
                    // Swal.fire(result.title,result.pesan, "error");
                    return false;
                } else {
                    // Swal.fire(result.title,result.pesan, "success");
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {

            }
        });
    }

    

    function add(){ 
        $('#form_app')[0].reset(); 
        save_method = 'add';
        $("#add_member").show();
        $('#full-width-modal').modal('show'); 
        $('.mymodal-title').text('Invite User '); 
    }

    

    function simpan(){
        var url;
        if(save_method == 'add') {
            url = "<?php echo site_url(strtolower($controller).'/add_faskes')?>/";
        } else {
            url = "<?php echo site_url(strtolower($controller).'/update_faskes')?>/";
        }   

        $('#form_app').form('submit',{
            url: url,
            onSubmit: function(){
                loader();
                return $(this).form('validate');
        },
        dataType:'json',
        success: function(result){
            console.log(result);
            obj = $.parseJSON(result);
            if (obj.success == false ){
                Swal.fire({   
                    title: obj.title,   
                    icon: "error", 
                    html: obj.pesan,
                    allowOutsideClick: false,
                    customClass: {
                        confirmButton: 'btn btn-danger mt-2'
                    }   
                });
                return false;
            } else {
                Swal.fire({
                    title: obj.title,  
                    html: obj.pesan,   
                    icon: "success",
                    allowOutsideClick: false,
                    customClass: {
                        confirmButton: 'btn btn-danger mt-2'
                      },
                    showCancelButton: false,
                    confirmButtonColor: "#d33",
                    cancelButtonColor: "#3085d6",
                    confirmButtonText: "Ok",
                    cancelButtonText: "Batal",
                    allowOutsideClick: false,

                })

               
                $("#full-width-modal").modal("hide"); 
                reload_table();
            }   
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
                icon: "warning",
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

    function det(id){
        document.location.href = "<?php echo site_url(strtolower($controller)."/detail_profil_faskes/") ?>" + id;
    }
    
</script>
