<link href="<?php echo base_url('assets/admin/datatables/css/dataTables.bootstrap4.min.css'); ?>" rel="stylesheet">

<style>
  .badge { font-size: 0.75rem; }
  .card-elev { border-radius: .5rem; box-shadow: 0 4px 18px rgba(0,0,0,.06); }

  /* Select2 rapi sejajar form-control BS4 */
  .select2-container { width: 100% !important; }
  .select2-container .select2-selection--single { height: 38px; padding: 6px 8px; }
  .select2-container--default .select2-selection--single .select2-selection__rendered { line-height: 24px; }
  .select2-container--default .select2-selection--single .select2-selection__arrow { height: 36px; right: 6px; }
</style>

<div class="container-fluid">
  <div class="row mt-3">
    <div class="col-12">
      <div class="card card-elev">
        <div class="card-body">
          <h4 class="header-title mb-2"><?php echo $title; ?></h4>
          <p class="text-muted mb-3"><?php echo $deskripsi; ?></p>

          <form id="form-filter" onsubmit="return false;" autocomplete="off">
            <div class="form-row">
              <div class="col-md-3 mb-2">
                <label class="small mb-1" for="tanggal_mulai">Tanggal Mulai</label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai" class="form-control">
              </div>
              <div class="col-md-3 mb-2">
                <label class="small mb-1" for="tanggal_selesai">Tanggal Selesai</label>
                <input type="date" id="tanggal_selesai" name="tanggal_selesai" class="form-control">
              </div>
              <div class="col-md-3 mb-2">
                <label class="small mb-1" for="unit_tujuan">Unit Tujuan</label>
                <?php echo form_dropdown('unit_tujuan', $arr_units, '', 'id="unit_tujuan" class="form-control select2"'); ?>
              </div>
              <div class="col-md-3 mb-2">
                <label class="small mb-1" for="form_asal">Form Asal</label>
                <input type="text" id="form_asal" name="form_asal" class="form-control" placeholder="Nama tamu / Instansi">
              </div>

              <div class="col-md-3 mb-2">
                <div class="form-group mb-3">
                  <label class="small mb-1" for="filter_status">Status</label>
                  <select id="filter_status" name="status" class="form-control">
                    <option value="">== Semua Status ==</option>
                    <option value="approved">Approved</option>
                    <option value="checked_in">Checked-in</option>
                    <option value="checked_out">Checked-out</option>
                    <option value="expired">Expired</option>
                    <option value="checked_out">Rejected</option>
                  </select>
                </div>
              </div>

              <div class="col-md-9 mb-2 text-right">
                <button type="button" id="btn-filter" class="btn btn-primary btn-sm mr-1">
                  <i class="fa fa-search"></i> Tampilkan
                </button>
                <button type="button" id="btn-reset" class="btn btn-warning btn-sm mr-1">
                  <i class="fa fa-undo"></i> Reset
                </button>
                <button type="button" id="btn-cetak" class="btn btn-danger btn-sm">
                  <i class="fa fa-file-pdf-o"></i> Cetak PDF
                </button>
              </div>
            </div>
          </form>

          <div class="table-responsive mt-3">
            <table id="tbl_booking" class="table table-striped table-bordered table-sm w-100 align-middle">
              <thead>
                <tr>
                  <th width="4%" class="text-center">No</th>
                  <th>Kode Booking</th>
                  <th>Tanggal/Jam</th>
                  <th>Nama Tamu / Jabatan</th>
                  <th>Asal</th>
                  <th>Unit Tujuan</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody></tbody>
            </table>
          </div>

        </div>
      </div>
    </div>
  </div>
</div>

<script src="<?php echo base_url('assets/admin/datatables/js/jquery.dataTables.min.js'); ?>"></script>
<script src="<?php echo base_url('assets/admin/datatables/js/dataTables.bootstrap4.min.js'); ?>"></script>
<script>
var tbl;

function reloadTable(){
  tbl.ajax.reload(null,false);
}

$(function(){
  // Inisialisasi Select2 jika dipakai
  if ($.fn.select2) {
    $('#unit_tujuan').select2();
  }

  tbl = $('#tbl_booking').DataTable({
    processing: true,
    serverSide: true,
    order: [],
    ajax: {
      url: "<?php echo site_url('admin_permohonan/get_data'); ?>",
      type: "POST",
      data: function(d){
        d.tanggal_mulai   = $('#tanggal_mulai').val();
        d.tanggal_selesai = $('#tanggal_selesai').val();
        d.unit_tujuan     = $('#unit_tujuan').val();
        d.form_asal       = $('#form_asal').val();
        d.status          = $('#filter_status').val(); // << konsisten dengan ID baru
      }
    },
    columns: [
      { data: 'no', className:'text-center' },
      { data: 'kode', className:'text-center' },
      { data: 'tgljam', className:'text-center' },
      { data: 'tamu' },
      { data: 'asal' },
      { data: 'instansi' },
      { data: 'status', className:'text-center' }
    ],
    columnDefs: [
      { targets: [3,4,5,6], orderable: false } // nonaktifkan sort di kolom HTML/badge
    ]
  });

  // Tampilkan
  $('#btn-filter').on('click', function(){ reloadTable(); });

  // Reset
  $('#btn-reset').on('click', function(){
    $('#form-filter')[0].reset();
    $('#unit_tujuan').val('').trigger('change');
    $('#filter_status').val('');
    reloadTable();
  });

  // Cetak PDF (pakai filter yang sama)
  $('#btn-cetak').on('click', function(){
    const qs = new URLSearchParams({
      tanggal_mulai:   $('#tanggal_mulai').val() || '',
      tanggal_selesai: $('#tanggal_selesai').val() || '',
      unit_tujuan:     $('#unit_tujuan').val() || '',
      form_asal:       $('#form_asal').val() || '',
      status:          $('#filter_status').val() || ''
    }).toString();

    window.open('<?php echo site_url('admin_permohonan/cetak_pdf'); ?>?'+qs, '_blank');
  });

  // Cegah submit bawaan (Enter) agar tidak reload page
  $('#form-filter').on('submit', function(e){ e.preventDefault(); });

  // Tekan Enter di input/select = klik "Tampilkan"
  $('#form-filter').on('keydown', 'input,select', function(e){
    if (e.key === 'Enter') {
      e.preventDefault();
      $('#btn-filter').trigger('click');
    }
  });

  // Jika pakai Select2: cegah Enter di kotak search Select2
  $(document).on('keydown', '.select2-search__field', function(e){
    if (e.key === 'Enter') e.preventDefault();
  });
});
</script>
