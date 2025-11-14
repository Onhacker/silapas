<link href="<?= base_url('assets/admin/datatables/css/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css"/>

<style>
  /* Paksa lebar select status full width (hindari kotak kecil) */
  #full-width-modal .status-select{
    display:block;
    width:100% !important;
    max-width:100%;
  }

  #foto-preview{
    width:60px;
    height:60px;
    object-fit:cover;
  }
</style>

<div class="container-fluid">

  <!-- Page Title -->
  <div class="row">
    <div class="col-12">
      <div class="page-title-box">
        <div class="page-title-right">
          <ol class="breadcrumb m-0">
            <li class="breadcrumb-item">
              <a href="<?= site_url('admin_kamar'); ?>">Master Kamar</a>
            </li>
            <li class="breadcrumb-item active"><?= $subtitle; ?></li>
          </ol>
        </div>
        <h4 class="page-title"><?= $subtitle; ?></h4>
        <p class="text-dark mb-2">
          Kapasitas: <?= (int)$kamar->kapasitas; ?>
          | Token QR: <code><?= html_escape($kamar->qr_token); ?></code>
        </p>
      </div>
    </div>
  </div>
  <!-- /Page Title -->

  <!-- Tabel Data -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">

          <div class="button-list mb-2">
          <button type="button" onclick="kembali()" class="btn btn-warning btn-xs waves-effect waves-light">
  <span class="btn-label"><i class="fe-arrow-left"></i></span>Kembali
</button>

<button type="button" onclick="add()" class="btn btn-success btn-xs waves-effect waves-light">
  <span class="btn-label"><i class="fe-plus-circle"></i></span>Tambah Tahanan
</button>
<button type="button" onclick="refresh()" class="btn btn-info btn-xs waves-effect waves-light">
  <span class="btn-label"><i class="fe-refresh-ccw"></i></span>Refresh
</button>
<button type="button" onclick="hapus_data()" class="btn btn-danger btn-xs waves-effect waves-light">
  <span class="btn-label"><i class="fa fa-trash"></i></span>Hapus
</button>

          </div>

          <hr>

          <table id="datable_1" class="table table-striped table-bordered w-100">
            <thead>
              <tr>
                <th class="text-center" width="5%">
                  <div class="checkbox checkbox-primary checkbox-single">
                    <input id="check-all" type="checkbox">
                    <label></label>
                  </div>
                </th>
                <th width="5%">No.</th>
                <th>Identitas</th>
                <th width="16%">Putusan</th>
                <th width="10%">Expirasi</th>
                <th width="10%">Status</th>
                <th width="14%">Aksi</th>
              </tr>
            </thead>
          </table>

        </div>
      </div>
    </div>
  </div>
  <!-- /Tabel Data -->

  <!-- Modal -->
  <div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">

        <div class="modal-header">
          <h4 class="mymodal-title">Tambah Tahanan</h4>
          <button type="button" class="close" onclick="close_modal()" aria-hidden="true">×</button>
        </div>

        <div class="modal-body">
          <form id="form_app" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id_detail" id="id_detail">
            <input type="hidden" name="id_kamar" id="id_kamar" value="<?= (int)$kamar->id_kamar; ?>">

            <!-- Foto -->
            <div class="form-group mb-2">
              <label>Foto</label>
              <div class="d-flex align-items-center">
                <div class="mr-3">
                  <img id="foto-preview"
                       src=""
                       alt="Foto tahanan"
                       class="rounded-circle border"
                       style="display:none;">
                </div>
                <div class="flex-grow-1">
                  <input type="file" class="form-control-file" name="foto" id="foto" accept="image/*">
                  <small class="form-text text-muted">
                    Kosongkan jika tidak ingin mengubah foto. Format: JPG/PNG, maks 1MB.
                  </small>
                </div>
              </div>
            </div>

            <!-- Nama -->
            <div class="form-group mb-2">
              <label class="text-primary">Nama</label>
              <input type="text" class="form-control" name="nama" id="nama" required>
            </div>

            <!-- Status -->
         <div class="form-group mb-3">
  <label for="status_tahanan">Status</label>
  <select name="status" id="status_tahanan" class="form-control" required>
    <option value="">-- Pilih Status --</option>
    <option value="aktif">Aktif</option>
    <option value="pindah">Pindah</option>
    <option value="bebas">Bebas</option>
    <option value="lainnya">Lainnya</option>
  </select>
</div>


            <!-- No Reg -->
            <div class="form-group mb-2">
              <label>No.Reg</label>
              <input type="text" class="form-control" name="no_reg" id="no_reg" required>
            </div>

            <!-- Perkara -->
            <div class="form-group mb-2">
              <label>Perkara</label>
              <input type="text" class="form-control" name="perkara" id="perkara" required>
            </div>

            <!-- Putusan -->
            <div class="form-row mb-2">
              <div class="form-group col-md-4">
                <label>Putusan Tahun</label>
                <input type="number" class="form-control" name="putusan_tahun" id="putusan_tahun" value="0" min="0">
              </div>
              <div class="form-group col-md-4">
                <label>Putusan Bulan</label>
                <input type="number" class="form-control" name="putusan_bulan" id="putusan_bulan" value="0" min="0">
              </div>
              <div class="form-group col-md-4">
                <label>Putusan Hari</label>
                <input type="number" class="form-control" name="putusan_hari" id="putusan_hari" value="0" min="0">
              </div>
            </div>

            <!-- Expirasi -->
            <div class="form-group mb-2">
              <label>Expirasi (Tanggal)</label>
              <input type="date" class="form-control" name="expirasi" id="expirasi">
            </div>

            <!-- Data Lain -->
            <div class="form-row mb-2">
              <div class="form-group col-md-4">
                <label>Jenis Kelamin</label>
                <select name="jenis_kelamin" id="jenis_kelamin" class="form-control">
                  <option value="">- pilih -</option>
                  <option value="L">Laki-laki</option>
                  <option value="P">Perempuan</option>
                </select>
              </div>
              <div class="form-group col-md-4">
                <label>Tempat Lahir</label>
                <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir">
              </div>
              <div class="form-group col-md-4">
                <label>Tanggal Lahir</label>
                <input type="date" class="form-control" name="tanggal_lahir" id="tanggal_lahir">
              </div>
            </div>

            <!-- Alamat -->
            <div class="form-group mb-2">
              <label>Alamat</label>
              <textarea class="form-control" name="alamat" id="alamat" rows="2"></textarea>
            </div>

            <!-- Deskripsi -->
            <div class="form-group mb-2">
              <label>Deskripsi</label>
              <textarea class="form-control" name="deskripsi" id="deskripsi" rows="3" placeholder="catatan tambahan"></textarea>
            </div>

          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-secondary waves-effect" onclick="close_modal()">Batal</button>
          <button type="button" onclick="simpan()" class="btn btn-primary waves-effect waves-light">Simpan</button>
        </div>

      </div>
    </div>
  </div>
  <!-- /Modal -->

  <?php $this->load->view("backend/global_css"); ?>
</div>

<script type="text/javascript">
let table;
let saveUrl = "<?= site_url('admin_kamar_detail/add'); ?>";
const kamarId = <?= (int)$kamar->id_kamar; ?>;

$(document).ready(function () {
  table = $('#datable_1').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: {
      url: "<?= site_url('admin_kamar_detail/get_data/'.$kamar->id_kamar); ?>",
      type: "POST"
    },
    columns: [
      { data: 'cek',      orderable: false, searchable: false, className: 'text-center' },
      { data: 'no',       orderable: false, searchable: false },
      { data: 'identitas' },
      { data: 'putusan',  className: 'text-center' },
      { data: 'expirasi', className: 'text-center' },
      { data: 'status',   className: 'text-center' },
      { data: 'aksi',     orderable: false, searchable: false, className: 'text-center' }
    ],
    order: [[2, 'asc']],
    rowCallback: function (row, data, displayIndex) {
      const info = this.api().page.info();
      $('td:eq(1)', row).html(info.start + displayIndex + 1);
    }
  });

  $('#check-all').on('click', function () {
    $('.data-check').prop('checked', this.checked);
  });
});

/* Helpers SweetAlert */
function swalToast(icon = 'success', title = 'Berhasil', text = '') {
  return Swal.fire({
    icon: icon,
    title: title,
    text: text,
    toast: true,
    position: 'center',
    showConfirmButton: false,
    timer: 2500,
    timerProgressBar: true
  });
}

function swalErr(msg, title = 'Gagal') {
  return Swal.fire({ icon: 'error', title: title, html: msg });
}

function swalWarn(msg, title = 'Perhatian') {
  return Swal.fire({ icon: 'warning', title: title, html: msg });
}

/* Reload tabel */
function refresh() {
  table.ajax.reload(null, false);
}

/* Tambah data */
function add() {
  saveUrl = "<?= site_url('admin_kamar_detail/add'); ?>";

  $('#form_app')[0].reset();
  $('#id_detail').val('');
  $('#id_kamar').val(kamarId);
  $('#status_tahanan').val('aktif');

  $('#foto').val('');
  $('#foto-preview').hide().attr('src', '');

  $('.mymodal-title').text('Tambah Tahanan');
  $('#full-width-modal').modal('show');
}

/* Edit data */
function edit(id) {
  $('#form_app')[0].reset();
  $('#foto-preview').hide().attr('src', '');
  $('#foto').val('');

  $.getJSON("<?= site_url('admin_kamar_detail/get_one/'); ?>" + id, function (res) {
    if (res.success) {
      const d = res.data;

      $('#id_detail').val(d.id_detail);
      $('#id_kamar').val(d.id_kamar);
      $('#nama').val(d.nama);
      $('#no_reg').val(d.no_reg);
      $('#perkara').val(d.perkara);
      $('#putusan_tahun').val(d.putusan_tahun);
      $('#putusan_bulan').val(d.putusan_bulan);
      $('#putusan_hari').val(d.putusan_hari);
      $('#expirasi').val(d.expirasi);
      $('#jenis_kelamin').val(d.jenis_kelamin);
      $('#tempat_lahir').val(d.tempat_lahir);
      $('#tanggal_lahir').val(d.tanggal_lahir);
      $('#alamat').val(d.alamat);

      const st = (d.status || '').toLowerCase();
      $('#status_tahanan').val(st || 'aktif');

      $('#deskripsi').val(d.deskripsi);

      if (d.foto) {
        $('#foto-preview')
          .attr('src', "<?= base_url('uploads/kamar_tahanan/'); ?>" + d.foto)
          .show();
      } else {
        $('#foto-preview').hide().attr('src', '');
      }

      saveUrl = "<?= site_url('admin_kamar_detail/update'); ?>";
      $('.mymodal-title').text('Edit Tahanan');
      $('#full-width-modal').modal('show');
    } else {
      swalErr(res.pesan || 'Data tidak ditemukan');
    }
  }).fail(function () {
    swalErr('Terjadi kesalahan koneksi');
  });
}

/* Tutup modal */
function close_modal() {
  $('#full-width-modal').modal('hide');
}

/* Simpan (add/update) */
function simpan() {
  const formEl   = document.getElementById('form_app');
  const formData = new FormData(formEl);

  $.ajax({
    url: saveUrl,
    type: "POST",
    dataType: "json",
    data: formData,
    processData: false,
    contentType: false,
    success: function (res) {
      if (res.success) {
        close_modal();
        swalToast('success', 'Berhasil', res.pesan || 'Data tersimpan');
        refresh();
      } else {
        swalErr(res.pesan || 'Gagal memproses');
      }
    },
    error: function () {
      swalErr('Terjadi kesalahan koneksi');
    }
  });
}

/* Hapus data terpilih */
function hapus_data(){
  var id = [];
  $('.data-check:checked').each(function(){
    id.push($(this).val());
  });

  if (!id.length){
    Swal.fire('Info', 'Tidak ada data yang dipilih', 'info');
    return;
  }

  $.ajax({
    url  : "<?= site_url('admin_kamar_detail/hapus_data'); ?>",
    type : "POST",
    dataType: "json",
    data : {
      id: id // <-- WAJIB "id", sama dengan input->post('id')
      // kalau pakai CSRF:
      // '<?= $this->security->get_csrf_token_name(); ?>' : '<?= $this->security->get_csrf_hash(); ?>'
    },
    success: function(r){
      Swal.fire(r.title, r.pesan, r.success ? 'success' : 'error');
      if (r.success) {
        table.ajax.reload(null, false); // reload DataTables
      }
    },
    error: function(){
      Swal.fire('Error', 'Gagal menghubungi server', 'error');
    }
  });
}

function kembali(){
  window.location.href = "<?= site_url('admin_kamar'); ?>";
}

</script>
