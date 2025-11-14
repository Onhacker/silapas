<link href="<?= base_url('assets/admin/datatables/css/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet" type="text/css"/>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="page-title-box">
        <div class="page-title-right">
          <ol class="breadcrumb m-0">
            <li class="breadcrumb-item active"><?= $subtitle; ?></li>
          </ol>
        </div>
        <h4 class="page-title"><?= $subtitle; ?></h4>
      </div>
    </div>
  </div>

  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <div class="button-list mb-2">
            <button type="button" onclick="add()" class="btn btn-success btn-rounded btn-sm waves-effect waves-light">
              <span class="btn-label"><i class="fe-plus-circle"></i></span>Tambah Kamar
            </button>
            <button type="button" onclick="refresh()" class="btn btn-info btn-rounded btn-sm waves-effect waves-light">
              <span class="btn-label"><i class="fe-refresh-ccw"></i></span>Refresh
            </button>
            <button type="button" onclick="hapus_data()" class="btn btn-danger btn-rounded btn-sm waves-effect waves-light">
              <span class="btn-label"><i class="fa fa-trash"></i></span>Hapus
            </button>
          </div>
          <hr>
          <table id="datable_1" class="table table-striped table-bordered w-100">
            <thead>
            <tr>
              <th class="text-center" width="5%">
                <div class="checkbox checkbox-primary checkbox-single">
                  <input id="check-all" type="checkbox"><label></label>
                </div>
              </th>
              <th width="5%">No.</th>
              <th>Kamar</th>
              <th width="8%">Kapasitas</th>
              <th width="8%">Terisi</th>
              <th width="8%">Status</th>
              <th width="22%">Aksi</th>
            </tr>
            </thead>
          </table>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div id="full-width-modal" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" aria-hidden="true">
    <div class="modal-dialog  modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="mymodal-title">Tambah Kamar</h4>
          <button type="button" class="close" onclick="close_modal()" aria-hidden="true">×</button>
        </div>
        <div class="modal-body">
          <form id="form_app" method="post">
            <input type="hidden" name="id_kamar" id="id_kamar">

            <div class="form-group mb-2">
              <label class="text-primary">Nama Kamar</label>
              <input type="text" class="form-control" name="nama" id="nama" autocomplete="off" required placeholder="mis: Kamar G 1 Blok 2">
            </div>
<!-- 
            <div class="form-group mb-2">
              <label>Blok</label>
              <input type="text" class="form-control" name="blok" id="blok" autocomplete="off" placeholder="mis: Blok 2">
            </div> -->

            <div class="form-group mb-2">
              <label>Lantai</label>
              <input type="text" class="form-control" name="lantai" id="lantai" autocomplete="off" placeholder="mis: Lantai 1">
            </div>

            <div class="form-group mb-2">
              <label>Kapasitas</label>
              <input type="number" class="form-control" name="kapasitas" id="kapasitas" min="0" value="0">
            </div>

            <div class="form-group mb-2">
              <label>Status</label>
              <select name="status" id="status_pesanan" class="form-control">
                <option value="aktif">Aktif</option>
                <option value="nonaktif">Nonaktif</option>
              </select>
            </div>

            <div class="form-group mb-2">
              <label>Keterangan</label>
              <textarea class="form-control" name="keterangan" id="keterangan" rows="3" placeholder="catatan tambahan kamar"></textarea>
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

  <?php
    $this->load->view("backend/global_css");
  ?>
</div>

<script type="text/javascript">
let table;
let saveUrl = "<?= site_url(strtolower($controller).'/add'); ?>";

$(document).ready(function(){
  table = $('#datable_1').DataTable({
    processing: true,
    serverSide: true,
    responsive: true,
    ajax: {
      url: "<?= site_url(strtolower($controller).'/get_data'); ?>",
      type: "POST"
    },
    columns: [
      { data: 'cek', orderable: false, searchable: false, className:'text-center' },
      { data: 'no',  orderable: false, searchable: false },
      { data: 'nama' },
      { data: 'kapasitas', className:'text-center' },
      { data: 'terisi',    className:'text-center' },
      { data: 'status',    className:'text-center' },
      { data: 'aksi', orderable: false, searchable: false, className:'text-center' },
    ],
    order: [[2,'asc']],
    rowCallback: function(row, data, displayIndex) {
      const info = this.api().page.info();
      $('td:eq(1)', row).html(info.start + displayIndex + 1);
    }
  });

  $('#check-all').on('click', function(){
    $('.data-check').prop('checked', this.checked);
  });
});

/* ==== SweetAlert helpers ==== */
function swalToast(icon='success', title='Berhasil', text='') {
  return Swal.fire({
    icon, title, text,
    toast: true, position: 'center',
    showConfirmButton: false, timer: 2500, timerProgressBar: true
  });
}
function swalErr(msg, title='Gagal'){   return Swal.fire({icon:'error',   title, html: msg}); }
function swalWarn(msg, title='Perhatian'){ return Swal.fire({icon:'warning', title, html: msg}); }

function refresh(){ table.ajax.reload(null,false); }

function add(){
  saveUrl = "<?= site_url(strtolower($controller).'/add'); ?>";
  $('#form_app')[0].reset();
  $('#id_kamar').val('');
  $('#status_pesanan').val('aktif');
  $('.mymodal-title').text('Tambah Kamar');
  $('#full-width-modal').modal('show');
}

function edit(id){
  $('#form_app')[0].reset();
  $.getJSON("<?= site_url(strtolower($controller).'/get_one/'); ?>"+id, function(res){
    if(res.success){
      const d = res.data;
      $('#id_kamar').val(d.id_kamar);
      $('#nama').val(d.nama);
      $('#blok').val(d.blok);
      $('#lantai').val(d.lantai);
      $('#kapasitas').val(d.kapasitas);
      $('#keterangan').val(d.keterangan);
      $('#status_pesanan').val(d.status);
      saveUrl = "<?= site_url(strtolower($controller).'/update'); ?>";
      $('.mymodal-title').text('Edit Kamar');
      $('#full-width-modal').modal('show');
    } else {
      swalErr(res.pesan || 'Data tidak ditemukan');
    }
  }).fail(function(){
    swalErr('Terjadi kesalahan koneksi');
  });
}

function close_modal(){ $('#full-width-modal').modal('hide'); }

function simpan(){
  const form = $('#form_app');
  $.ajax({
    url: saveUrl,
    type: "POST",
    dataType: "json",
    data: form.serialize(),
    success: function(res){
      if(res.success){
        close_modal();
        swalToast('success','Berhasil',res.pesan || 'Data tersimpan');
        refresh();
      } else {
        swalErr(res.pesan || 'Gagal memproses');
      }
    },
    error: function(){
      swalErr('Terjadi kesalahan koneksi');
    }
  });
}

function hapus_data(){
  const ids = [];
  $('.data-check:checked').each(function(){ ids.push($(this).val()); });
  if(ids.length === 0){ swalWarn('Tidak ada data dipilih'); return; }

  Swal.fire({
    title: 'Hapus kamar terpilih?',
    text: 'Tindakan ini tidak bisa dibatalkan.',
    icon: 'warning',
    showCancelButton: true,
    confirmButtonText: 'Ya, hapus',
    cancelButtonText: 'Batal'
  }).then(function(result){
    if(!result.isConfirmed) return;

    $.ajax({
      url: "<?= site_url(strtolower($controller).'/hapus_data'); ?>",
      type: "POST",
      dataType: "json",
      data: { id: ids }, // jQuery (tanpa traditional) => id[]=1&id[]=2
      success: function(res){
        if(res.success){
          swalToast('success','Berhasil',res.pesan || 'Data terhapus');
          refresh();
        } else {
          swalErr(res.pesan || 'Gagal menghapus');
        }
      },
      error: function(){
        swalErr('Terjadi kesalahan koneksi');
      }
    });
  });
}

</script>
