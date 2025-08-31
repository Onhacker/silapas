<script type="text/javascript">
$(document).ready(function(){
    // Inisialisasi dropify
    $('.dropify').dropify();

    // if (!window.hasReloadedOnce) {
    //     window.hasReloadedOnce = true;

    //     if (!window.location.search.includes('_=')) {
    //         const url = new URL(window.location.href);
    //         url.searchParams.set('_', Date.now());
    //         window.location.replace(url.toString());
    //     }
    // }
});

// function hardReload() {
//     const url = new URL(window.location.href);
//     url.searchParams.set('_', Date.now());
//     window.location.replace(url.toString());
// }

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

function loader() {
    Swal.fire({
        title: "Prosess...",
        html: "Jangan tutup halaman ini",
        allowOutsideClick: false,
        didOpen: function() {
            Swal.showLoading();
        }
    })
}

function hapus_file(id_paket, kolom_file, id_input) {
    Swal.fire({
        title: "Yakin ingin menghapus file ini?",
        text: "Anda tidak dapat mengembalikan data yang sudah dihapus.",
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
                url: "<?= site_url(strtolower($controller).'/hapus_file_upload/'.$table_name) ?>",
                data: {
                    id_paket: id_paket,
                    kolom_file: kolom_file,
                },
                cache : false,
                dataType: "json",
                success: function(result) {
                    Swal.close();
                    if(result.success == false){
                        Swal.fire(result.title,result.pesan, "error");
                        return false;
                    } else {
                        Swal.fire(result.title,result.pesan, "success");
                        // alert(kolom_file);
                        document.getElementById("btn_preview_" + result.btn_preview).style.display = "none";
                        document.getElementById("ukuran_" + result.btn_preview).style.display = "none";
                        // const ukuranEl = document.getElementById("ukuran_" + result.btn_preview);
                        // if (ukuranEl) {
                        //     ukuranEl.innerHTML = `Ukuran file: <strong>${res.ukuran}</strong>`;
                        //     ukuranEl.style.display = "none"; // Pastikan elemen tampil
                        // }
                        // document.getElementById("ukuran_"+res.btn_preview).innerHTML = "Ukuran file:<strong>"+res.ukuran+"</strong>";
                        if (id_input) {
                            let dropifyInput = $('#' + id_input).dropify({
                                messages: {
                                    'default': '<span class="badge bg-soft-danger text-danger">* Wajib diisi</span>',
                                    'replace': 'Ganti file',
                                    'remove': 'Hapus file',
                                    'error': 'Oops, terjadi kesalahan saat mengunggah file.'
                                }
                            });

                            dropifyInput = dropifyInput.data('dropify');
                            dropifyInput.resetPreview();
                            dropifyInput.clearElement();
                        }


                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    alert("fucks");
                }
            });
        } else {

        }
    })
}


function proses(mode) {
    let isAdmin = "<?= $this->session->userdata('admin_level') ?>" === "admin";
    let btnId, defaultLabel, title, text, cancelButtonText, confirmButtonText, input;
    
    // Tentukan tombol, label, dan teks konfirmasi
    if (mode === 'kirim') {
        if (isAdmin) {
            btnId = "btn-setujui";
            defaultLabel = "Setujui";
            title = "Yakin ingin Menyetujui?";
            text = "Permohonan ini akan disetujui.";
        } else {
            btnId = "btn-user-kirim";
            defaultLabel = "Kirim";
            title = "Yakin ingin Mengirim ke Dukcapil?";
            text = "Pastikan data sudah benar. Setelah dikirim, tidak dapat diubah.";
        }
        confirmButtonText = `Yakin`;
        cancelButtonText = "Periksa Dulu";
        input = "checkbox";
    } else {
        if (isAdmin) {
            btnId = "btn-setujui";
            defaultLabel = "Setujui";
            title = "Yakin ingin Menyetujui?";
            text = "Data ini akan disetujui.";
            confirmButtonText = `Yakin`;
            input = "checkbox";
        } else {
            btnId = "btn-simpan-user";
            defaultLabel = "Simpan";
            title = "Yakin ingin Menyimpan?";
            text = "Data akan disimpan (belum dikirim ke Dukcapil).";
            confirmButtonText = "Ya, Simpan";
            input = null;
        }
        cancelButtonText = "Batal";
    }

    const btn = document.getElementById(btnId);
    if (btn) {
        btn.dataset.original = btn.innerHTML; // simpan isi awal
        btn.innerHTML = `<span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span> Memproses...`;
        btn.disabled = true;
        btn.style.pointerEvents = 'none';
        btn.style.opacity = '0.6';
    }


    Swal.fire({
        title: title,
        text: text,
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "primary",
        cancelButtonColor: "warning",
        cancelButtonText: cancelButtonText,
        allowOutsideClick: false,
        input: input,
        inputValue: 0,
        inputPlaceholder: "Ceklis Ya, saya sangat yakin !!!",
        confirmButtonText: confirmButtonText,
            inputValidator: (result) => {
                return !result && "SiDia Butuh Keyakinan Anda";
            }
        }).then((result) => {
        if (result.value) {
            $('#form_app').form('submit', {
                url: '<?php echo site_url(strtolower($controller) . "/update_paket/") ?>' + mode,
                onSubmit: function () {
                    loader(); // Tampilkan loader
                    return $(this).form('validate');
                },
                dataType: 'json',
                success: function (result) {
                    let obj = (typeof result === 'string') ? JSON.parse(result) : result;

                    if (!obj.success) {
                        Swal.fire({
                            title: obj.title || "Gagal",
                            icon: "error",
                            html: obj.pesan || "Terjadi kesalahan.",
                            allowOutsideClick: false,
                            customClass: {
                                confirmButton: "btn btn-confirm mt-2"
                            },
                            buttonsStyling: false
                        });
                        if (btn) {
                            btn.disabled = false;
                            btn.style.pointerEvents = 'auto'; // jika sebelumnya pakai pointerEvents: none
                            btn.style.opacity = '1'; // mengembalikan opasitas jika sebelumnya dikurangi

                            // Kembalikan label asli
                            btn.innerHTML = btn.dataset.original || `<i class="mdi mdi-check-circle mr-1"></i> ${defaultLabel}`;
                        }
                    } else {
                        Swal.fire({
                            title: obj.title || "Berhasil",
                            icon: "success",
                            html: obj.pesan || "Data berhasil diproses!",
                            allowOutsideClick: false,
                            customClass: {
                                confirmButton: "btn btn-confirm mt-2"
                            },
                            buttonsStyling: false
                        }).then(() => {
                             <?php if ($this->session->userdata("admin_level") == "admin") { ?>
                                window.location.href = "<?= site_url(strtolower($controller) . "/all") ?>";
                            <?php } else { ?>
                                window.location.href = "<?= site_url(strtolower($controller) . "/detail_paket/" . $table_name) ?>";
                            <?php } ?>

                            if (mode === 'kirim') {
                                let id_paket = $('#id_paket').val();
                                let id_permohonan = $('#id_permohonan').val();
                                let isAdmin = "<?= $this->session->userdata('admin_level') ?>" === "admin";
                                let targetUrl = isAdmin
                                ? "<?= site_url(strtolower($controller) . "/kirim_wa_paket_dukcapil") ?>"
                                : "<?= site_url(strtolower($controller) . "/kirim_wa_paket") ?>";

                                $.post(targetUrl, {
                                    id_paket: id_paket,
                                    id_permohonan: id_permohonan
                                }, function (res) {
                                    let response = (typeof res === 'string') ? JSON.parse(res) : res;
                                    console.log("WA Response:", response);
                                });
                            }
                        });
                    }
                }
            });
        } else {
         if (btn) {
            // Aktifkan kembali tombol
            btn.disabled = false;
            btn.style.pointerEvents = 'auto'; // jika sebelumnya pakai pointerEvents: none
            btn.style.opacity = '1'; // mengembalikan opasitas jika sebelumnya dikurangi

            // Kembalikan label asli
            btn.innerHTML = btn.dataset.original || `<i class="mdi mdi-check-circle mr-1"></i> ${defaultLabel}`;
        }

        }
    })
}


function tolak(mode) {
   const btn = document.getElementById("btn-tolak");
   if (btn) {
        btn.dataset.original = btn.innerHTML; // simpan isi awal
        btn.innerHTML = `<span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span> Memproses...`;
        btn.disabled = true;
        btn.style.pointerEvents = 'none';
        btn.style.opacity = '0.6';
    }

   // btn.disabled = true;
   // btn.innerHTML = `<span class="spinner-border spinner-border-sm mr-1" role="status" aria-hidden="true"></span> Memproses...`;

    let isAdmin = "<?= $this->session->userdata('admin_level') ?>" === "admin";
    Swal.fire({
        title: 'Yakin ingin Menolak?',
        text: 'Permohonan ini akan ditolak',
        icon: "question",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        cancelButtonText: "Periksa lagi",
        allowOutsideClick: false,
        input: "checkbox",
        inputValue: 0,
        inputPlaceholder: "Ceklis Ya, saya sangat yakin !!!",
        confirmButtonText: `Yakin&nbsp;<i class="fa fa-arrow-right"></i>`,
        inputValidator: (result) => {
            return !result && "SiDia Butuh Keyakinan Anda";
        }
        }).then((result) => {
        if (result.value) {
            Swal.fire({
                title: "Alasan Penolakan",
                input: "textarea",
                inputLabel: "Tulis alasan Anda",
                inputPlaceholder: "Contoh: Dokumen tidak lengkap atau tidak sesuai...",
                inputAttributes: {
                    "aria-label": "Type your message here"
                },
                showCancelButton: true,
                confirmButtonText: "Kirim Penolakan",
                inputValidator: (value) => {
                    if (!value) {
                        return "Alasan penolakan tidak boleh kosong!";
                    }
                }
                }).then((res) => {
                    if (res.value) {
                        // alert("Isi alasan: " + res.value);
                        $('#alasan_penolakan').val(res.value); // Pastikan input hidden ini ada di form
                        $('#form_app').form('submit', {
                        url: '<?php echo site_url(strtolower($controller) . "/update_tolak/") ?>' + mode,
                        onSubmit: function () {
                        loader(); // Tampilkan loader
                        return $(this).form('validate');
                    },
                    dataType: 'json',
                    success: function (result) {
                        let obj = (typeof result === 'string') ? JSON.parse(result) : result;
                        if (!obj.success) {
                            Swal.fire({
                            title: obj.title || "Gagal",
                            icon: "error",
                            html: obj.pesan || "Terjadi kesalahan.",
                            allowOutsideClick: false,
                            customClass: {
                                confirmButton: "btn btn-confirm mt-2"
                            },
                            buttonsStyling: false
                        });

                        } else {
                            Swal.fire({
                                title: obj.title || "Berhasil",
                                icon: "success",
                                html: obj.pesan || "Data berhasil diproses!",
                                allowOutsideClick: false,
                                customClass: {
                                    confirmButton: "btn btn-confirm mt-2"
                                },
                                buttonsStyling: false
                            }).then(() => {
                            <?php if ($this->session->userdata("admin_level") == "admin") { ?>
                                window.location.href = "<?= site_url(strtolower($controller) . "/all") ?>";
                            <?php } else { ?>
                                window.location.href = "<?= site_url(strtolower($controller) . "/detail_paket/" . $table_name) ?>";
                            <?php } ?>
                                if (mode === 'kirim') {
                                    let id_paket = $('#id_paket').val();
                                    let id_permohonan = $('#id_permohonan').val();
                                    let alasan_penolakan = $('#alasan_penolakan').val();
                                    let isAdmin = "<?= $this->session->userdata('admin_level') ?>" === "admin";
                                    let targetUrl = isAdmin
                                    ? "<?= site_url(strtolower($controller) . "/kirim_wa_paket_dukcapil") ?>"
                                    : "<?= site_url(strtolower($controller) . "/kirim_wa_paketxxxxxxx") ?>";

                                    $.post(targetUrl, {
                                        id_paket: id_paket,
                                        id_permohonan: id_permohonan,
                                        alasan_penolakan: alasan_penolakan
                                    }, function (res) {
                                        let response = (typeof res === 'string') ? JSON.parse(res) : res;
                                        console.log("WA Response:", response);
                                    });
                                }
                            });
                        }
                    }
                });
                    } else {
                         btn.disabled = false;
                            btn.style.pointerEvents = 'auto'; // jika sebelumnya pakai pointerEvents: none
                            btn.style.opacity = '1'; // mengembalikan opasitas jika sebelumnya dikurangi

                            // Kembalikan label asli
                            btn.innerHTML = btn.dataset.original || `<i class="mdi mdi-check-circle mr-1"></i> ${defaultLabel}`;
                    }
                });

           
        } else {// Jika user memilih 'Periksa lagi'
             btn.disabled = false;
                            btn.style.pointerEvents = 'auto'; // jika sebelumnya pakai pointerEvents: none
                            btn.style.opacity = '1'; // mengembalikan opasitas jika sebelumnya dikurangi

                            // Kembalikan label asli
                            btn.innerHTML = btn.dataset.original || `<i class="mdi mdi-check-circle mr-1"></i> ${defaultLabel}`;
        }
    })
}

function uploadFileCustom(fileInputId, idPaket, uploadUrl, previewBtnId = null, statusId = null, progressId = null) {
    // Ambil elemen input file, status upload, progress bar, dan tombol preview
    const fileInput = document.getElementById(fileInputId);
    const statusEl = statusId ? document.getElementById(statusId) : null;
    const progressWrapper = progressId ? document.getElementById(progressId + 'Wrapper') : null;
    const progressBar = progressId ? document.getElementById(progressId + 'Bar') : null;
    const previewBtn = previewBtnId ? document.getElementById(previewBtnId) : null;

    // Ambil file yang dipilih
    const file = fileInput?.files?.[0];
    if (!file) return; // Jika tidak ada file, hentikan

    // Siapkan form data untuk dikirim lewat AJAX
    const formData = new FormData();
    formData.append(fileInputId, file); // Nama input jadi nama field
    formData.append('id_paket', idPaket); // Sertakan id_paket

    // Tampilkan progress wrapper jika ada
    if (progressWrapper) progressWrapper.style.display = 'block';
    if (progressBar) {
        progressBar.style.width = '0%';
        progressBar.innerText = '0%';
    }

    // Bersihkan status dan sembunyikan tombol preview
    if (statusEl) statusEl.innerHTML = '';
    if (previewBtn) previewBtn.style.display = 'none';

    // Siapkan request AJAX
    const xhr = new XMLHttpRequest();
    xhr.open('POST', uploadUrl, true);

    // Event saat proses upload berjalan
    xhr.upload.addEventListener("progress", function (e) {
        if (e.lengthComputable && progressBar) {
            const percent = Math.round((e.loaded / e.total) * 100);
            progressBar.style.width = percent + '%';
            progressBar.innerText = percent + '%';
        }
    });

    // Event saat upload selesai
    xhr.onload = function () {
        if (progressWrapper) progressWrapper.style.display = 'none';

        let res;
        try {
            res = JSON.parse(xhr.responseText); // Coba parsing hasil JSON
        } catch (e) {
            if (statusEl) statusEl.innerHTML = `<div class="alert alert-danger"><i class="mdi mdi-block-helper mr-2"></i> Gagal memproses respons</div>`;
            return;
        }

        if (res.success) {
            // Tampilkan pesan sukses dan hilangkan setelah 3 detik
            if (statusEl) {
                $(statusEl).html(`<div class="alert alert-success"><i class="mdi mdi-check-all mr-2"></i> ${res.pesan}</div>`).fadeIn();
                setTimeout(() => {
                    $(statusEl).fadeOut(() => $(statusEl).html(''));
                }, 3000);
            }

            // Ganti file input dengan preview file baru
            const newFilePath = `<?= site_url('admin_permohonan/show_file/') ?>${res.nama_file}`;
            const $oldInput = $('#' + fileInputId);
            const dropifyInstance = $oldInput.data('dropify');
            if (dropifyInstance) dropifyInstance.destroy();

            const newInputHtml = `
            <input type="file" name="${fileInputId}" id="${fileInputId}" class="dropify"
            data-default-file="${newFilePath}" onchange="uploadFileCustom('${fileInputId}', '${idPaket}', '${uploadUrl}', '${previewBtnId}', '${statusId}', '${progressId}')" />
            `;
            $oldInput.replaceWith(newInputHtml);
            $('#' + fileInputId).dropify();

            // Tampilkan tombol preview jika ada info nama tombol dari response
            // Tampilkan tombol preview jika ada
            const previewBtn = document.getElementById("btn_preview_" + res.btn_preview);
            if (previewBtn) {
                previewBtn.style.display = "inline-block";
            }

            // Tampilkan ukuran file jika ada
            const ukuranEl = document.getElementById("ukuran_" + res.btn_preview);
            if (ukuranEl) {
                ukuranEl.innerHTML = `Ukuran file: <strong>${res.ukuran}</strong>`;
                ukuranEl.style.display = "inline-block"; // Atau 'block' tergantung gaya tampilannya
            }


        } else {
            // Jika gagal, tampilkan pesan error dan reset preview dropify
            if (statusEl) statusEl.innerHTML = `<div class="alert alert-danger"><i class="mdi mdi-block-helper mr-2"></i> ${res.pesan}</div>`;
        }
    };


    // Event jika terjadi error saat mengirim request
    xhr.onerror = function () {
        if (progressWrapper) progressWrapper.style.display = 'none';
        if (statusEl) statusEl.innerHTML = `<div class="alert alert-danger"><i class="mdi mdi-block-helper mr-2"></i> Terjadi kesalahan saat upload</div>`;
    };

    // Kirim form data
    xhr.send(formData);
}

function previewFileCustomxx(id_paket, previewUrl, judul = 'Preview File') {
    loader();
    const modalEl = document.getElementById("modalPreviewFile");
    const content = document.getElementById("previewFileContent");
    const title = document.getElementById("modalPreviewFileLabel");
    const downloadBtn = document.getElementById("downloadFileBtn");

    if (!modalEl || !content || !title || !downloadBtn) {
        console.warn("Modal, kontainer preview, title, atau tombol download tidak ditemukan!");
        return;
    }

    const modal = new bootstrap.Modal(modalEl);
    title.textContent = judul;
    content.innerHTML = '<p>⏳ Memuat file...</p>';
    downloadBtn.style.display = 'none'; // Sembunyikan dulu sampai file valid

    fetch(previewUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ id_paket })
    })
    .then(res => res.json())
    .then(res => {
        Swal.close();
        if (res.success && res.file_url) {
            const url = res.file_url;
            const ext = url.split('.').pop().toLowerCase();
            let previewHTML = '';

            if (ext === 'pdf') {
                previewHTML = `<iframe src="${url}" width="100%" height="600px" style="border:1px solid #ccc;"></iframe>`;
            } else if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
                previewHTML = `<img src="${url}" class="img-fluid rounded border" alt="Preview Dokumen">`;
            } else {
                previewHTML = `<p class="text-danger">❌ Format file tidak didukung: .${ext}</p>`;
            }

            content.innerHTML = previewHTML;
            downloadBtn.href = url;
            downloadBtn.style.display = 'inline-block'; // Tampilkan tombol download
        } else {
            content.innerHTML = `<p class="text-danger">❌ ${res.pesan || 'File tidak ditemukan.'}</p>`;
            downloadBtn.style.display = 'none';
        }

        modal.show();
    })
    .catch(err => {
        Swal.close();
        console.error("Gagal memuat file:", err);
        content.innerHTML = `<p class="text-danger">❌ Terjadi kesalahan saat memuat file.</p>`;
        downloadBtn.style.display = 'none';
        modal.show();
    });
}


function previewFileCustom(id_paket, previewUrl, judul = 'Preview File') {

    loader(); 
    const modalEl = document.getElementById("modalPreviewFile");
    const content = document.getElementById("previewFileContent");
    const title = document.getElementById("modalPreviewFileLabel");
    const downloadBtn = document.getElementById("downloadFileBtn");

    if (!modalEl || !content || !title || !downloadBtn) {
        console.warn("Modal, kontainer preview, title, atau tombol download tidak ditemukan!");
        return;
    }

    const modal = new bootstrap.Modal(modalEl);
    title.textContent = judul;
    content.innerHTML = '<p>⏳ Memuat file...</p>';
    downloadBtn.style.display = 'none'; 

    fetch(previewUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded',
        },
        body: new URLSearchParams({ id_paket })
    })
    .then(res => res.json())
    .then(res => {
        Swal.close(); 
        if (res.success && res.file_url) {
            const url = res.file_url;
            const ext = url.split('.').pop().toLowerCase(); 
            let previewHTML = '';

            if (ext === 'pdf') {
                previewHTML = `<object data="${url}" type="application/pdf" width="100%" height="600px">
                                    <p>Browser Anda tidak mendukung PDF, silakan <a href="${url}" target="_blank">Lihat disini </a>atau klik tombol download</p>
                                </object>`;
            } else if (['jpg', 'jpeg', 'png', 'gif'].includes(ext)) {
                
                previewHTML = `<img src="${url}" class="img-fluid rounded border" alt="Preview Dokumen">`;
            } else {
                
                previewHTML = `<p class="text-danger">❌ Format file tidak didukung: .${ext}</p>`;
                downloadBtn.style.display = 'none'; 
            }
            content.innerHTML = previewHTML;
            downloadBtn.href = url;
            downloadBtn.style.display = 'inline-block'; 
        } else {
            content.innerHTML = `<p class="text-danger">❌ ${res.pesan || 'File tidak ditemukan.'}</p>`;
            downloadBtn.style.display = 'none';
        }

        
        modal.show();
    })
    .catch(err => {
        Swal.close(); 
        console.error("Gagal memuat file:", err);
        content.innerHTML = `<p class="text-danger">❌ Terjadi kesalahan saat memuat file.</p>`;
        downloadBtn.style.display = 'none';
        modal.show();
    });
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


function back() {
    Swal.fire({
        title: "Yakin membatalkan proses ini",
        text: "Anda tidak dapat mengembalikan data yang sementara diproses tanpa disimpan terlabih dahulu",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#3085d6",
        confirmButtonText: "Ya",
        cancelButtonText: "Batal",
        allowOutsideClick: false,
    }).then((result) => {
        if (result.value) {
            <?php if ($this->session->userdata("admin_level") == "admin") { ?>
                window.location.href = "<?= site_url(strtolower($controller) . "/all") ?>";
            <?php } else { ?>
                window.location.href = "<?= site_url(strtolower($controller) . "/detail_paket/" . $table_name) ?>";
            <?php } ?>
            // window.location.href = baseUrl;
        } else {

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
<?php if ($this->uri->segment(2) == "proses_detail_paket") {?>
document.addEventListener('DOMContentLoaded', function () {
    const checkbox = document.getElementById('copyDataPemohon');

    // Ubah data berikut sesuai dengan data dari server (record)
    const dataPemohon = {
        nama: "<?= $record->nama_pemohon ?>",
    };

    // Pastikan event listener untuk 'change' menambahkan passive: true jika perlu
    checkbox.addEventListener('change', function () {
        if (this.checked) {
            document.getElementById('nama').value = dataPemohon.nama;
        } else {
            document.getElementById('nama').value = '';
        }
    }, { passive: true });
});

<?php } ?>

// menampilkan tombol preview jika ada file
<?php 
$files = [];

// Data dari master_syarat
if ($dataFile && $dataFile->num_rows() > 0) {
    foreach ($dataFile->result() as $row) {
        $kode = strtolower($row->kode_file);
        $files[$kode] = $id_preview->{'file_' . $kode} ?? '';
    }
}

// Tambahan dari file_balasan (jika ada)
if (!empty($file_balasan_map)) {
    foreach ($file_balasan_map as $kode => $nama_file) {
        $kode = strtolower($kode);
        if (!isset($files[$kode])) {
            $files[$kode] = $id_preview->{'file_' . $kode} ?? '';
        }
    }
}
?>

document.addEventListener("DOMContentLoaded", function () {
    <?php 
    foreach ($files as $key => $filename): 
        if (!empty($filename)) : ?>
            let btn_<?= $key ?> = document.getElementById("btn_preview_<?= $key ?>");
            let ukuran_<?= $key ?> = document.getElementById("ukuran_<?= $key ?>");
            if (btn_<?= $key ?>) {
                btn_<?= $key ?>.style.display = "inline-block";
                ukuran_<?= $key ?>.style.display = "inline-block";
            }
        <?php endif; ?>
    <?php endforeach; ?>
}, { passive: true });  // Menambahkan opsi passive di sini


function prosesUlang(id_paket, tabel) {
    Swal.fire({
        title: 'Proses Ulang Permohonan?',
        text: "Permohonan akan dikembalikan ke proses awal.",
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, proses ulang!'
    }).then((result) => {
        if (result.value) {
            window.location.href = "<?= base_url('admin_permohonan/proses_detail_paket') ?>/" + tabel + "/" + id_paket;
        }
    });
}

    

</script>
