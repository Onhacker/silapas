<link href="<?php echo base_url("assets/admin") ?>/libs/dropify/dropify.min.css" rel="stylesheet" type="text/css" />
<div class="container-fluid">

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item"><?php echo $title ?></li>
                        <li class="breadcrumb-item active"><?php echo $subtitle ?></li>
                    </ol>
                </div>
                <h4 class="page-title"><?php echo $subtitle ?></h4>
            </div>
        </div>
    </div>     

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <form id="form_app" method="post"  enctype="multipart/form-data" >

                             

                                <div class="form-group mb-3">
                                    <label class="text-primary" for="simpleinput">Tahun Imunisasi</label>
                                    <?php 
                                    $tahun_akhir = isset($record->tahun_akhir)?$record->tahun_akhir:"";
                                    echo form_dropdown("tahun_akhir",$this->om->arr_tahun_manual_imunisasi(),$tahun_akhir,'id="tahun_akhir" class="form-control"') ;
                                    ?>
                                    <code>Masukkan Tahun Imunisasi</code>
                                </div>
                                 
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="simpleinput">Nama System</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->nama_website))?$record->nama_website:"";  ?>"  id="nama_website" name="nama_website" placeholder="">
                                </div>

                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Provinsi</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->propinsi))?$record->propinsi:"";  ?>"  id="propinsi" name="propinsi" placeholder="">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Kabupaten</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->kabupaten))?$record->kabupaten:"";  ?>"  id="kabupaten" name="kabupaten" placeholder="">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Ibu Kota</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->alamat))?$record->alamat:"";  ?>"  id="alamat" name="alamat" placeholder="">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Nama Kepala Dinas</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->kadis))?$record->kadis:"";  ?>"  id="kadis" name="kadis" placeholder="">
                                </div>
                                 <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">NIP Kepala Dinas</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->nip_kadis))?$record->nip_kadis:"";  ?>"  id="nip_kadis" name="nip_kadis" placeholder="">
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Nama Ka. Seksi surveilans dan imunisasis</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->kepala_seksi))?$record->kepala_seksi:"";  ?>"  id="kepala_seksi" name="kepala_seksi" placeholder="">
                                </div>
                                 <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">NIP Ka. Seksi surveilans dan imunisasis</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->nip_kepala_seksi))?$record->nip_kepala_seksi:"";  ?>"  id="nip_kepala_seksi" name="nip_kepala_seksi" placeholder="">
                                </div>
                                 <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Nama Kabid P2P</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->kabid))?$record->kabid:"";  ?>"  id="kabid" name="kabid" placeholder="">
                                </div>
                                 <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">NIP Kabid P2P</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->nip_kabid))?$record->nip_kabid:"";  ?>"  id="nip_kabid" name="nip_kabid" placeholder="">
                                </div>
                                <!-- <label class="text-primary" for="example-email">Social Network</label>
                                <small><code>Kosongkan jika tidak ada</code></small>
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="social-fb">Url Akun Facebook</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fab fa-facebook-square"></i></span>
                                                </div>
                                                <input type="text" value="<?php echo (isset($record->facebook))?$record->facebook:"";  ?>" class="form-control" name = "facebook" id="social-fb" placeholder="Url">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="social-tw">Url Akun Twitter</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fab fa-twitter"></i></span>
                                                </div>
                                                <input type="text" name="twitter" value="<?php echo (isset($record->twitter))?$record->twitter:"";  ?>" class="form-control" id="social-tw" placeholder="Url">
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="social-insta">Url Akun Instagram</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fab fa-instagram"></i></span>
                                                </div>
                                                <input type="text" name="instagram" value="<?php echo (isset($record->instagram))?$record->instagram:"";  ?>" class="form-control" id="social-insta" placeholder="Url">
                                            </div>
                                        </div>
                                    </div>
                                     <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="social-insta">Url Channel Youtube</label>
                                            <div class="input-group">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text"><i class="fab fa-youtube"></i></span>
                                                </div>
                                                <input type="text" name="youtube" value="<?php echo (isset($record->youtube))?$record->youtube:"";  ?>" class="form-control" id="social-insta" placeholder="Url">
                                            </div>
                                        </div>
                                    </div>
                                </div> -->
                              <!--   <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Kode Pos</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->rekening))?$record->rekening:"";  ?>"  id="rekening" name="rekening" placeholder="">
                                </div> -->
                                <!--  <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">No. Telepon</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->telp))?$record->telp:"";  ?>"  id="telp" name="telp" placeholder="">
                                    <small class="text-info">Contoh : (0411) 8977333</small>
                                </div> -->
                                 <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">No. HP/ Whatsapp</label>
                                    <input type="text" class="form-control" value="<?php echo (isset($record->no_telp))?$record->no_telp:"";  ?>"  id="no_telp" name="no_telp" placeholder="">
                                    <small class="text-info">Contoh : 085203954888. Isikan no hp agar Puskesmas dapat melihat informasi kontak anda</small>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Email</label>
                                     <input type="text" class="form-control" value="<?php echo (isset($record->email))?$record->email:"";  ?>"  id="email" name="email" placeholder="">
                                    <small class="text-info">Email ini digunakan sebagai pengirim pesan otomatis (Seperti mengirim link reset password otomatis) .</small>
                                </div>
                               <!--  <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Kata Kunci Pencarian</label>
                                    <textarea class="form-control" id="meta_keyword" name="meta_keyword" rows="2"><?php echo (isset($record->meta_keyword))?$record->meta_keyword:"";  ?></textarea>
                                    <small class="text-info">Masukkan kata kunci untuk pencarian web. Pisahkan dengan tanda koma</small>
                                </div>
                                 <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Alamat Lengkap</label>
                                    <textarea class="form-control" id="alamat" name="alamat" rows="2"><?php echo (isset($record->alamat))?$record->alamat:"";  ?></textarea>
                                </div>
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Lokasi Kantor di Maps</label>
                                    <textarea class="form-control" id="maps" name="maps" rows="4"><?php echo (isset($record->maps))?$record->maps:"";  ?></textarea>
                                    <small class="text-info">Masukkan titik/ lokasi sesuai google map. <a href="javascript:void(0)" onclick="modal()">Klik disini untuk cara mendapatkan kode titik lokasi</a> </small>
                                </div> -->
                                <div class="form-group mb-3">
                                    <label class="text-primary" for="example-email">Waktu Lokasi</label>
                                    <?php    
                                    $arr_waktu = array("Asia/Jakarta"=>"WIB",
                                      "Asia/Makassar" => "WITA",
                                      "Asia/Jayapura" => "WIT");
                                    $waktu = isset($record->waktu)?$record->waktu:"";
                                    echo form_dropdown("waktu",$arr_waktu,$waktu,'class="form-control"') ?>
                                 
                                </div>
<!-- 
                                <div class="row">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group mb-3">
                                                    <label class="text-primary" for="example-email">Favicon</label>
                                                    <input type="file" name="favicon" id="favicon" onchange="return validasiFile()" class="dropify" data-default-file="<?php echo base_url() ?>assets/images/<?php echo(isset($record->favicon))?$record->favicon:""; ?>" />
                                                 
                                                </div>
                                            </div> 

                                        </div> 
                                    </div>
                                </div> -->

                                <div class="row">
                                  <div class="col-6">
                                    <a href="javascript:;" onclick="update()" id="btn-login" class="btn btn-primary btn-block">Update</a>
                                </div>
                                <div class="col-6">
                                    <button type="reset" onclick="home()" class="btn btn-block  btn-secondary waves-effect m-l-5">
                                        Batal
                                    </button>
                                </div>
                            </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $this->load->view($controller."_js"); ?>

<div id="md" class="modal fade " tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog border border-primary  modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="video-title" id="myModalLabel">Cara mendapatkan kode lokasi di maps</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body">
                <ol type="1">
                    <li>Buka <a href="https://www.google.com/maps/preview" target="_BLANK">Google Maps</a> </li>
                    <li>Pada kotak pencarian, masukkan lokasi yang ingin dicari</li>
                    <li>Di kiri atas, Klik menu atau icon <i class="fa fa-bars"></i> </li>
                    <li>Klik Bagikan</li>
                    <li>Klik Sematkan Peta</li>
                    <li>Klik Salin HTML</li>
                    <li>Terakhir, Paste kode yang disalin tadi ke form isian </li>
                </ol> 
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary waves-effect waves-light" data-dismiss="modal">Tutup</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

   


    
</div>
