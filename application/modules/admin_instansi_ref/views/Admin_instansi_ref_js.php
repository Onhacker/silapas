<script>
var table, save_method = 'add';
// Pemetaan kolom & form per jenis (sinkron dengan Model::map)
const CFG = {
  opd: {
    title: 'OPD / Instansi Vertikal',
    pk: 'id_opd',
    cols: [
      {data:'nama_opd', title:'Nama OPD'},
      {data:'jenis', title:'Jenis'},
      {data:'induk', title:'Induk'},
      {data:'singkatan', title:'Singkatan'},
      {data:'aktif', title:'Aktif', className:'text-center', width:'8%'},
      {data:'aksi', title:'Aksi', orderable:false, width:'8%'}
    ],
    form: `
      <div class="form-group"><label>Nama OPD</label><input name="nama_opd" class="form-control" required></div>
      <div class="form-group"><label>Jenis</label>
        <select name="jenis" class="form-control" required>
          <option value="OPD Provinsi">OPD Provinsi</option>
          <option value="Instansi Vertikal">Instansi Vertikal</option>
        </select>
      </div>
      <div class="form-group"><label>Induk</label><input name="induk" class="form-control"></div>
      <div class="form-group"><label>Singkatan</label><input name="singkatan" class="form-control"></div>
      <div class="form-check mt-2"><input type="checkbox" class="form-check-input" id="aktif" name="aktif" checked>
        <label class="form-check-label" for="aktif">Aktif</label></div>
      <input type="hidden" name="id_opd" id="pk">
    `
  },
  pn: {
    title: 'Pengadilan Negeri',
    pk: 'id_pn',
    cols: [
      {data:'nama_pn', title:'Nama PN'},
      {data:'kabkota', title:'Kab/Kota'},
      {data:'provinsi', title:'Provinsi'},
      {data:'aktif', title:'Aktif', className:'text-center', width:'8%'},
      {data:'aksi', title:'Aksi', orderable:false, width:'8%'}
    ],
    form: `
      <div class="form-group"><label>Nama PN</label><input name="nama_pn" class="form-control" required></div>
      <div class="form-group"><label>Kab/Kota</label><input name="kabkota" class="form-control" required></div>
      <div class="form-group"><label>Provinsi</label><input name="provinsi" class="form-control" value="Sulawesi Selatan" required></div>
      <div class="form-check mt-2"><input type="checkbox" class="form-check-input" id="aktif" name="aktif" checked>
        <label class="form-check-label" for="aktif">Aktif</label></div>
      <input type="hidden" name="id_pn" id="pk">
    `
  },
  pa: {
    title: 'Pengadilan Agama',
    pk: 'id_pa',
    cols: [
      {data:'nama_pa', title:'Nama PA'},
      {data:'kabkota', title:'Kab/Kota'},
      {data:'provinsi', title:'Provinsi'},
      {data:'aktif', title:'Aktif', className:'text-center', width:'8%'},
      {data:'aksi', title:'Aksi', orderable:false, width:'8%'}
    ],
    form: `
      <div class="form-group"><label>Nama PA</label><input name="nama_pa" class="form-control" required></div>
      <div class="form-group"><label>Kab/Kota</label><input name="kabkota" class="form-control" required></div>
      <div class="form-group"><label>Provinsi</label><input name="provinsi" class="form-control" value="Sulawesi Selatan" required></div>
      <div class="form-check mt-2"><input type="checkbox" class="form-check-input" id="aktif" name="aktif" checked>
        <label class="form-check-label" for="aktif">Aktif</label></div>
      <input type="hidden" name="id_pa" id="pk">
    `
  },
  ptun: {
    title: 'Pengadilan TUN',
    pk: 'id_ptun',
    cols: [
      {data:'nama_ptun', title:'Nama PTUN'},
      {data:'kabkota', title:'Kab/Kota'},
      {data:'provinsi', title:'Provinsi'},
      {data:'aktif', title:'Aktif', className:'text-center', width:'8%'},
      {data:'aksi', title:'Aksi', orderable:false, width:'8%'}
    ],
    form: `
      <div class="form-group"><label>Nama PTUN</label><input name="nama_ptun" class="form-control" required></div>
      <div class="form-group"><label>Kab/Kota</label><input name="kabkota" class="form-control" required></div>
      <div class="form-group"><label>Provinsi</label><input name="provinsi" class="form-control" value="Sulawesi Selatan" required></div>
      <div class="form-check mt-2"><input type="checkbox" class="form-check-input" id="aktif" name="aktif" checked>
        <label class="form-check-label" for="aktif">Aktif</label></div>
      <input type="hidden" name="id_ptun" id="pk">
    `
  },
  kejari: {
    title: 'Kejaksaan Negeri',
    pk: 'id_kejari',
    cols: [
      {data:'nama_kejari', title:'Nama Kejari'},
      {data:'kabkota', title:'Kab/Kota'},
      {data:'provinsi', title:'Provinsi'},
      {data:'aktif', title:'Aktif', className:'text-center', width:'8%'},
      {data:'aksi', title:'Aksi', orderable:false, width:'8%'}
    ],
    form: `
      <div class="form-group"><label>Nama Kejari</label><input name="nama_kejari" class="form-control" required></div>
      <div class="form-group"><label>Kab/Kota</label><input name="kabkota" class="form-control" required></div>
      <div class="form-group"><label>Provinsi</label><input name="provinsi" class="form-control" value="Sulawesi Selatan" required></div>
      <div class="form-check mt-2"><input type="checkbox" class="form-check-input" id="aktif" name="aktif" checked>
        <label class="form-check-label" for="aktif">Aktif</label></div>
      <input type="hidden" name="id_kejari" id="pk">
    `
  },
  cabjari: {
    title: 'Cabang Kejaksaan Negeri',
    pk: 'id_cabjari',
    cols: [
      {data:'id_kejari', title:'Kejari Induk'},
      {data:'nama_cabang', title:'Nama Cabang'},
      {data:'lokasi', title:'Lokasi'},
      {data:'kabkota', title:'Kab/Kota'},
      {data:'provinsi', title:'Provinsi'},
      {data:'aktif', title:'Aktif', className:'text-center', width:'8%'},
      {data:'aksi', title:'Aksi', orderable:false, width:'8%'}
    ],
    form: `
      <div class="form-group"><label>Kejari Induk</label>
        <select name="id_kejari" id="id_kejari" class="form-control" data-toggle="select2" data-ajax="1" required></select>
      </div>
      <div class="form-group"><label>Nama Cabang</label><input name="nama_cabang" class="form-control" required></div>
      <div class="form-group"><label>Lokasi</label><input name="lokasi" class="form-control" required></div>
      <div class="form-group"><label>Kab/Kota</label><input name="kabkota" class="form-control" required></div>
      <div class="form-group"><label>Provinsi</label><input name="provinsi" class="form-control" value="Sulawesi Selatan" required></div>
      <div class="form-check mt-2"><input type="checkbox" class="form-check-input" id="aktif" name="aktif" checked>
        <label class="form-check-label" for="aktif">Aktif</label></div>
      <input type="hidden" name="id_cabjari" id="pk">
    `
  },
  bnn: {
    title: 'BNN Kab/Kota',
    pk: 'id_bnn',
    cols: [
      {data:'nama_unit', title:'Nama Unit'},
      {data:'tingkat', title:'Tingkat'},
      {data:'kabkota', title:'Kab/Kota'},
      {data:'provinsi', title:'Provinsi'},
      {data:'singkatan', title:'Singkatan'},
      {data:'aktif', title:'Aktif', className:'text-center', width:'8%'},
      {data:'aksi', title:'Aksi', orderable:false, width:'8%'}
    ],
    form: `
      <div class="form-group"><label>Nama Unit</label><input name="nama_unit" class="form-control" required></div>
      <div class="form-group"><label>Tingkat</label>
        <select name="tingkat" class="form-control" required>
          <option value="Kabupaten">Kabupaten</option>
          <option value="Kota">Kota</option>
        </select>
      </div>
      <div class="form-group"><label>Kab/Kota</label><input name="kabkota" class="form-control" required></div>
      <div class="form-group"><label>Provinsi</label><input name="provinsi" class="form-control" value="Sulawesi Selatan" required></div>
      <div class="form-group"><label>Singkatan</label><input name="singkatan" class="form-control" value="BNNK"></div>
      <div class="form-check mt-2"><input type="checkbox" class="form-check-input" id="aktif" name="aktif" checked>
        <label class="form-check-label" for="aktif">Aktif</label></div>
      <input type="hidden" name="id_bnn" id="pk">
    `
  },
  kodim: {
    title: 'Kodim Sulawesi',
    pk: 'id_kodim',
    cols: [
      {data:'nomor_kodim', title:'No Kodim', className:'text-right', width:'10%'},
      {data:'label', title:'Label'},
      {data:'wilayah', title:'Wilayah'},
      {data:'provinsi', title:'Provinsi'},
      {data:'aktif', title:'Aktif', className:'text-center', width:'8%'},
      {data:'aksi', title:'Aksi', orderable:false, width:'8%'}
    ],
    form: `
      <div class="form-group"><label>Nomor Kodim</label><input name="nomor_kodim" type="number" class="form-control" required></div>
      <div class="form-group"><label>Label</label><input name="label" class="form-control" required></div>
      <div class="form-group"><label>Wilayah</label><input name="wilayah" class="form-control" required></div>
      <div class="form-group"><label>Provinsi</label><input name="provinsi" class="form-control" required></div>
      <div class="form-check mt-2"><input type="checkbox" class="form-check-input" id="aktif" name="aktif" checked>
        <label class="form-check-label" for="aktif">Aktif</label></div>
      <input type="hidden" name="id_kodim" id="pk">
    `
  },
  kejati: {
    title: 'Kejaksaan Tinggi',
    pk: 'id_kejati',
    cols: [
      {data:'nama_kejati', title:'Nama Kejati'},
      {data:'provinsi', title:'Provinsi'},
      {data:'aktif', title:'Aktif', className:'text-center', width:'8%'},
      {data:'aksi', title:'Aksi', orderable:false, width:'8%'}
    ],
    form: `
      <div class="form-group"><label>Nama Kejati</label><input name="nama_kejati" class="form-control" required></div>
      <div class="form-group"><label>Provinsi</label><input name="provinsi" class="form-control" value="Sulawesi Selatan" required></div>
      <div class="form-check mt-2"><input type="checkbox" class="form-check-input" id="aktif" name="aktif" checked>
        <label class="form-check-label" for="aktif">Aktif</label></div>
      <input type="hidden" name="id_kejati" id="pk">
    `
  },
   kepolisian: {
    title: 'Kepolisian',
    pk: 'id_kepolisian',
    cols: [
      {data:'nama_kepolisian', title:'Nama kepolisian'},
      {data:'kabkota', title:'Kab/Kota'},
      {data:'provinsi', title:'Provinsi'},
      {data:'aktif', title:'Aktif', className:'text-center', width:'8%'},
      {data:'aksi', title:'Aksi', orderable:false, width:'8%'}
    ],
    form: `
      <div class="form-group"><label>Nama kepolisian</label><input name="nama_kepolisian" class="form-control" required></div>
      <div class="form-group"><label>Kab/Kota</label><input name="kabkota" class="form-control" required></div>
      <div class="form-group"><label>Provinsi</label><input name="provinsi" class="form-control" value="Sulawesi Selatan" required></div>
      <div class="form-check mt-2"><input type="checkbox" class="form-check-input" id="aktif" name="aktif" checked>
        <label class="form-check-label" for="aktif">Aktif</label></div>
      <input type="hidden" name="id_kepolisian" id="pk">
    `
  },
};

function loader(on=true){
  if (on) Swal.fire({title:"Proses...", html:"Jangan tutup halaman ini", allowOutsideClick:false, didOpen:()=>Swal.showLoading()});
  else Swal.close();
}

function currentJenis(){ return $('#jenis').val(); }

function buildColumns(){
  const cfg = CFG[currentJenis()];
  let cols = [
    {data:'cek', orderable:false, width:'5%'},
    {data:'no', orderable:false, width:'5%'},
  ];
  cols = cols.concat(cfg.cols);
  return cols;
}

function buildThead(){
  const cfg = CFG[currentJenis()];
  const $thead = $('#datable_1 thead tr');
  $thead.find('th:gt(1)').remove(); // hapus kolom setelah No.
  cfg.cols.forEach(c => {
    $('<th>').text(c.title).appendTo($thead);
  });
}

function initTable(){
  if (table) { table.destroy(); $('#datable_1').find('tbody').empty(); }
  buildThead();

  $.fn.dataTableExt.oApi.fnPagingInfo = function(o){
    return {iStart:o._iDisplayStart, iEnd:o.fnDisplayEnd(), iLength:o._iDisplayLength, iTotal:o.fnRecordsTotal(), iFilteredTotal:o.fnRecordsDisplay(), iPage:Math.ceil(o._iDisplayStart/o._iDisplayLength), iTotalPages:Math.ceil(o.fnRecordsDisplay()/o._iDisplayLength)};
  };

  table = $('#datable_1').DataTable({
    lengthMenu: [[10,25,50,100,-1],[10,25,50,100,'All']],
    oLanguage:{
      sProcessing:"Memuat Data...",
      sSearch:"<i class='ti-search'></i> Cari Data :",
      sZeroRecords:"Maaf Data Tidak Ditemukan",
      sLengthMenu:"Tampil _MENU_ Data",
      sEmptyTable:"Data Tidak Ada",
      sInfo:"Menampilkan _START_ - _END_ dari _TOTAL_ Total Data",
      sInfoEmpty:"Tidak ada data ditampilkan",
      sInfoFiltered:"(Filter dari _MAX_ total Data)",
      oPaginate:{ sNext:"<i class='fe-chevrons-right'></i>", sPrevious:"<i class='fe-chevrons-left'></i>"}
    },
    processing:true, serverSide:true, scrollX:true,
    ajax:{
      url:"<?= site_url('admin_instansi_ref/get_data') ?>",
      type:"POST",
      data:function(d){ d.jenis = currentJenis(); }
    },
    columns: buildColumns(),
    order: [],
    rowCallback:function(row, data, iDisplayIndex){
      var info = this.fnPagingInfo();
      var idx  = info.iPage * info.iLength + (iDisplayIndex + 1);
      $('td:eq(1)', row).html(idx);
    }
  });

  $("#check-all").off('click').on('click', function(){ $(".data-check").prop('checked', $(this).prop('checked')); });
}

function refresh(){ table.ajax.reload(null,false); }

function add(){
  save_method='add';
  const cfg = CFG[currentJenis()];
  $('#form_fields').html(cfg.form);
  $('#form_jenis').val(currentJenis());
  $('#pk').val('');
  $('.mymodal-title').text('Tambah ' + cfg.title);
  initSelects();
  $('#full-width-modal').modal('show');
}

function edit(jenis, id){
  save_method='update';
  const cfg = CFG[jenis];
  $('#form_fields').html(cfg.form);
  $('#form_jenis').val(jenis);
  $('#pk').val(id);
  $('.mymodal-title').text('Edit ' + cfg.title + ' #' + id);
  initSelects();

  loader(true);
  $.getJSON("<?= site_url('admin_instansi_ref/get_one/') ?>"+jenis+"/"+id)
    .done(function(res){
      loader(false);
      if (!res.success){ Swal.fire('Gagal', res.pesan || 'Data tidak ditemukan', 'error'); return; }
      const d = res.data;
      // isi form
      $('#form_fields [name]').each(function(){
        const nm = this.name;
        if (this.type === 'checkbox' && nm === 'aktif'){ this.checked = (parseInt(d.aktif) === 1); }
        else if (nm === 'id_kejari' && $('#id_kejari').data('select2')){
          if (d.id_kejari){
            const text = d.id_kejari + ' - (muat saat submit)';
            const opt = new Option(text, d.id_kejari, true, true);
            $('#id_kejari').append(opt).trigger('change');
          }
        } else {
          $(this).val(d[nm] ?? '');
        }
      });
      $('#full-width-modal').modal('show');
    })
    .fail(function(){ loader(false); Swal.fire('Error','Gagal mengambil data','error'); });
}

function simpan(){
  const url = (save_method==='add')
    ? "<?= site_url('admin_instansi_ref/add') ?>"
    : "<?= site_url('admin_instansi_ref/update') ?>";

  // kirim form via AJAX
  const form = $('#form_app');
  const fd = form.serialize();

  loader(true);
  $.ajax({
    url: url, type:'POST', data: fd, dataType:'json'
  }).done(function(res){
    loader(false);
    if (!res.success){ Swal.fire(res.title||'Gagal', res.pesan||'Validasi gagal', 'error'); return; }
    Swal.fire(res.title, res.pesan, 'success');
    $('#full-width-modal').modal('hide');
    refresh();
  }).fail(function(){
    loader(false);
    Swal.fire('Gagal','Tidak dapat mengirim data','error');
  });
}

function hapus_data(){
  const list_id = [];
  $(".data-check:checked").each(function(){ list_id.push(this.value); });
  if (list_id.length === 0) { Swal.fire("Info","Pilih minimal satu data","warning"); return; }

  Swal.fire({
    title:"Yakin ingin menghapus "+list_id.length+" data?",
    icon:"warning",
    showCancelButton:true,
    confirmButtonColor:"#d33",
    cancelButtonColor:"#3085d6",
    confirmButtonText:"Ya, Hapus",
    cancelButtonText:"Batal",
    allowOutsideClick:false
  }).then((res)=>{
    if (!res.value) return;
    loader(true);
    $.ajax({
      url:"<?= site_url('admin_instansi_ref/hapus_data') ?>",
      type:"POST",
      data:{id:list_id, jenis: currentJenis()},
      dataType:"json"
    }).done(function(r){
      loader(false);
      if (!r.success){ Swal.fire(r.title||'Gagal', r.pesan||'Gagal menghapus', 'error'); }
      else { Swal.fire(r.title, r.pesan, 'success'); refresh(); }
    }).fail(function(){
      loader(false); Swal.fire("Gagal","Koneksi bermasalah","error");
    });
  });
}

function close_modal(){
  Swal.fire({ title:"Tutup formulir?", icon:"warning", showCancelButton:true, confirmButtonText:"Tutup", cancelButtonText:"Batal" })
    .then(r=>{ if(r.value) $('#full-width-modal').modal('hide'); });
}

function initSelects(){
  if ($.fn.select2){
    $('[data-toggle="select2"]').select2({ width: '100%' });
    // Select2 AJAX untuk Kejari (Cabjari)
    if ($('#id_kejari').length && $('#id_kejari').data('ajax') === 1){
      $('#id_kejari').select2({
        width: '100%',
        allowClear: true,
        placeholder: 'Pilih Kejari Induk',
        ajax: {
          delay: 150,
          url: "<?= site_url('admin_instansi_ref/opsi_kejari') ?>",
          data: params => ({ q: params.term || '' }),
          processResults: data => ({ results: data })
        }
      });
    }
  }
}

$(function(){
  if ($.fn.select2) $('#jenis').select2({ width: '100%' });
  $('#jenis').on('change', initTable);
  initTable();
});
</script>
