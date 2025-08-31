<html>
<head>

	<title>
		<?php echo $title ?>
	</title>
	<link rel="shortcut icon" href="<?php echo base_url('assets/admin/img/favicon.ico') ?>">
	<style>
	
		.judul {
			font-size:12px;
			font-weight:bold;
		}
		
		

		.tabel {
			border-collapse: collapse;
			border-spacing: 0px;
		}

		.tabel th {
			border: 1px solid #000;
			padding: 2px;
			font-family: "Times New Roman", Times, serif; 
			font-size : 11px;
			text-align: center;
			font-weight: bold;
		}


		.head th {
			/*border: 1px solid #000;*/
			/*padding: 2px;*/
			font-family: "Times New Roman", Times, serif; 
			font-size : 11px;
			text-align: left;
			font-weight: bold;
		}



		.tabel td {
			border: 1px solid #000;
			padding: 2px;
			font-family: "Times New Roman", Times, serif; 
			font-size : 10px;
		}

		.ttd {
			/*border: 1px solid #000;*/
			padding: 2px;
			font-family: "Times New Roman", Times, serif; 
			font-size : 10px;
		}

	</style> 
</head>

<body>
	<?php 
	if ($jk == "L") {
		$re = "LAKI-LAKI";
	} elseif ($jk == "P") {
		$re = "PEREMPUAN";
	} else {
		$re = "";
	}

	if ($id_dusun != "") {
		$jdl = "DATA ANAK " .$re." ".strtoupper($this->om->bentuk_admin($id_dusun,"p")) ." ".strtoupper($this->om->identitas_general($id_dusun)->nama_dusun);

	} 
	if ($id_desa != "x") {
		$this->db->where("id_desa",$id_desa);
		$s = $this->db->get("master_desa")->row();

	

		$this->db->where("id_kecamatan", $s->id_kecamatan);
		$as = $this->db->get("master_kecamatan")->row();

		$de = strtoupper("<br>Desa ".$s->desa." Kecamatan ".$as->kecamatan);


	}
	
	?>
	<p align="center" class="judul"><strong><?php echo $jdl.$de." KABUPATEN ".$this->om->web_me()->kabupaten ?><br>TAHUN <?php echo $tahun ?></strong></p>

	<table width="100%" class="head">
		<?php if ($jum_l > 0) {?>
		
		<tr>
			<th width="10%">Laki-Laki</th>
			<th width="2%">:</th>
			<th width="50%"><?php echo $jum_l ?></th>
			
			
		</tr>
		<?php } ?>
		<?php if ($jum_p > 0) {?>
		<tr>
			<th width="10%">Perempuan</th>
			<th width="2%">:</th>
			<th width="50%"><?php echo $jum_p ?></th>
		
		</tr>
		<?php } ?>
		<tr>
			<th width="10%">Total</th>
			<th width="2%">:</th>
			<th width="50%"><?php echo $jum_p+$jum_l ?></th>
		
			
		</tr>
	</table>


	<br><br>
	<table id="basic-datatable" class="tabel" width="100%">
		<thead>
			<tr>
				<th width="3%">No.</th>
				<th width="7%">Tgl. Reg</th>
				<th width="10%">Nama/No.KIA</th>
				<th width="3%">JK</th>
				<th width="14%">Tempat, Tgl Lahir</th>
				<!-- <th width="7%">Umur</th> -->
				
				<th width="6%">Agama</th>
				<th width="10%">Nama/NIK Ayah</th>
				<th width="10%">Pekerjaan Ayah</th>
				<th width="10%">Nama/NIK IBU</th>
				<th width="10%">Pekerjaan Ibu</th>
				<th width="18%">Alamat</th>
			</tr>
		</thead>
			<?php 
			$i = 0;
			foreach ($res->result() as $row) :
			$i++; ?>
			<tr>
				<td align="center" width="3%"><?php echo $i ?>.</td>
				<td width="7%" align="center" ><?php echo tgl_view($row->create_date) ?></td>
				<td width="10%" ><strong><?php echo ucwords(strtolower($row->nama))."</strong><br>".$row->no_kia ?></td>
				<td width="3%" align="center"><?php echo $row->jk ?></td>
				<td width="14%"><?php echo ucwords(strtolower($row->tempat_lahir)).", ".tgl_view($row->tgl_lahir) ?></td>
				<!-- <td width="7%" align="left" ><?php echo umur_cetak($row->tgl_lahir) ?></td> -->
				
				<?php 
					$this->db->where("id_agama",$row->id_agama);
					$ag = $this->db->get("im_agama")->row();
				 ?>
				<td width="6%"><?php echo ucwords(strtolower($ag->agama)) ?></td>
				<td width="10%" align="left" ><?php echo ucwords(strtolower($row->nama_ayah)) ?><br><?php echo $row->nik_ayah ?></td>
				<!-- <td width="10%" align="left" ></td> -->
				<?php 
					$this->db->where("id_pekerjaan",$row->id_pekerjaan_ayah);
					$ag = $this->db->get("im_pekerjaan")->row();
				 ?>
				<td width="10%"><?php echo ucwords(strtolower($ag->pekerjaan)) ?></td>
				<td width="10%" align="left" ><?php echo ucwords(strtolower($row->nama_ibu)) ?><br><?php echo $row->nik_ibu ?></td>
				<?php 
					$this->db->where("id_pekerjaan",$row->id_pekerjaan_ibu);
					$ag = $this->db->get("im_pekerjaan")->row();
				 ?>
				 <?php 
					$this->db->where("id_desa",$row->id_desa);
					$agg = $this->db->get("master_desa")->row();
				 ?>

				  <?php 
					$this->db->where("id_desa",$row->id_desa);
					$as = $this->db->get("master_desa")->row();

					$this->db->where("id_kecamatan", $as->id_kecamatan);
					$as = $this->db->get("master_kecamatan")->row();
				 ?>
				<td width="10%"><?php echo ucwords(strtolower($ag->pekerjaan)) ?></td>
				<td width="18%"><?php echo ucwords(strtolower($row->alamat)).", "  ?> <?php echo "Desa ".ucwords(strtolower($agg->desa))." Kec. ".ucwords(strtolower($as->kecamatan)) ?></td>
				
				
			</tr>
		<?php endforeach; ?>
	
	</table>
<p></p>
<?php echo $this->load->view("ttd_dusun") ?>
</body>

</html>
