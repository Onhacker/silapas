<html>
<head>
	<title>
		Laporan
	</title>
	<style>
		* {
			font-size:12px;
		}
		.judul {
			font-size:14px;
			font-weight:bold;
			text-align: center;
		}
		
		
		
		.tabel {
			border-collapse: collapse;
			border-spacing: 0px;
		}

		.tabel th, .tabel td {
			border: 0px solid #000;
			padding: 2px;
			font-family: "Times New Roman", Times, serif; 
		}

		.tabel th {
			text-align: center;
		}

		.foot {
			font-size: 10px !important;
		}



	</style> 
</head>
<?php 
$desa = $this->om->identitas_general_l_a($res->id_dusun)->bentuk;
if ($this->session->userdata("admin_level") == "admin") {
	$yi = $this->om->identitas_general_l_a($res->id_dusun);
	$xi = $this->om->user_general($res->id_dusun);
} else {
	$yi = $this->om->identitas_general_l_a($this->session->userdata("admin_dusun"));
	$xi = $this->om->user();
}
if ($yi->bentuk == "1") {
	$er = strtoupper($this->om->bentuk_admin($res->id_dusun,"p"));
} else {
	$er = "RUMAH SAKIT";
}
?>
<body>
	<?php $this->load->view("kop"); ?>
	<hr>
	<p  class="judul"><strong>KARTU IMUNISASI RUTIN<br><?php echo strtoupper($res->nama) ?></strong></p>
	
	<table width="100%" cellspacing="4">
		<tr>
			<td colspan="3"><strong>Data Bayi</strong></td>
		</tr>
		<tr>
			<td width="30%">No. Registrasi KIA</td>
			<td width="2%">:</td>
			<td width="68%"><?php echo $res->no_kia  ?></td>
		</tr>
		<tr>
			<td >Tanggal Registrasi</td>
			<td >:</td>
			<td ><?php echo tgl_indo($res->create_date)  ?></td>
		</tr>
		<tr>
			<td >Nama</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->nama))  ?></td>
		</tr>
		
		<tr>
			<td >Jenis Kelamin</td>
			<td >:</td>
			<td ><?php  if ($res->jk == "L") {
				echo "Laki-Laki";
			} else {
				echo "Perempuan";
			}  ?></td>
		</tr>
		<tr>
			<td >Tempat, Tanggal Lahir</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->tempat_lahir)).", ".tgl_indo($res->tgl_lahir)  ?></td>
		</tr>
		<!-- <tr>
			<td >Umur</td>
			<td >:</td>
			<td ><?php echo umur($res->tgl_lahir)  ?></td>
		</tr> -->
		<tr>
			<td >Golongan Darah</td>
			<td >:</td>
			<td ><?php echo ($res->golda)  ?></td>
		</tr>
		<tr>
			<td >Alamat</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->alamat)).", "  ?> <?php echo "Desa ".ucwords(strtolower($res->desa))." Kecamatan ".ucwords(strtolower($kec->kecamatan)) ." Kabupaten ". ucwords(strtolower($this->om->web_me()->kabupaten)) ?></td>
		</tr>
		<tr>
			<td colspan="3"><strong></strong></td>
		</tr>
		<tr>
			<td colspan="3"><strong>Data Orang Tua Bayi</strong></td>
		</tr>
		<tr>
			<td >NIK Ayah</td>
			<td >:</td>
			<td ><?php if ($res->nik_ayah == 0) {
				echo "";
			} else {
				echo $res->nik_ayah;
			}  ?></td>
		</tr>
		<tr>
			<td >Nama Ayah</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->nama_ayah))  ?></td>
		</tr>
		<tr>
			<td >Pekerjaan Ayah</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($pekerjaan_ayah))  ?></td>
		</tr>
		<tr>
			<td >NIK Ibu</td>
			<td >:</td>
			<td ><?php if ($res->nik_ibu == 0) {
				echo "";
			} else {
				echo $res->nik_ibu;
			}  ?></td>
		</tr>
		<tr>
			<td >Nama Ibu</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($res->nama_ibu))  ?></td>
		</tr>
		<tr>
			<td >Pekerjaan Ibu</td>
			<td >:</td>
			<td ><?php echo ucwords(strtolower($pekerjaan_ibu))  ?></td>
		</tr>
	</table>


	
	<p></p>
	<table width="100%" border="0" cellspacing="4" cellpadding="0" class="ttd">

		<tr>

			<td width="60%">Mengetahui,</td>
			<td width="40%" align="left"><?php echo $this->om->identitas_general($res->id_dusun)->nama_dusun ?>, <?php echo tgl_indo($res->create_date) ?></td>
		</tr>
		<tr>

			<td>Kepala <?php echo $this->om->bentuk_admin($res->id_dusun,"p")." ".$this->om->identitas_general($res->id_dusun)->nama_dusun ?></td>
			<td align="left">Pengelola Imunisasi,</td>
		</tr>
		<tr>

			<td></td>
			<td align="left">&nbsp;</td>

		</tr>
		<tr>

			<td>&nbsp;</td>
			<td align="left">&nbsp;</td>
		</tr>

		<tr>
			<td></td>
			<td></td>
		</tr>

		<tr>

			<td style="font-weight: bold;"><?php echo $this->om->user_general($res->id_dusun)->pimpinan ?></td>
			<td style="font-weight: bold;"><?php echo $this->om->user_general($res->id_dusun)->nama_lengkap ?></td>
		</tr>
		<tr>

			<?php if (empty($this->om->user_general($res->id_dusun)->nip_pimpinan)) {?>
				<td></td>
			<?php } else {?>
				<td>NIP.<?php echo $this->om->user_general($res->id_dusun)->nip_pimpinan ?></td>
			<?php } ?>
			<?php if (empty($this->om->user_general($res->id_dusun)->nip_operator_dinas)) {?>
				<td></td>
			<?php } else {?>
				<td>NIP.<?php echo $this->om->user_general($res->id_dusun)->nip_operator_dinas ?></td>
			<?php } ?>

			<td></td>
		</tr>

	</table>
	<p></p>
	<p></p>
	<p style="color: red; font-size: 10px"><i>Catatan : Harap membawa kartu ini saat imunisasi</i></p>
</body>

</html>