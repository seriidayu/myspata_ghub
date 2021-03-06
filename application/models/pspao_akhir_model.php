<?php

class Pspao_akhir_model extends CI_Model {

function __construct(){
	
    parent::__construct();
    date_default_timezone_set('Asia/Kuala_Lumpur');
	
}
  
public function get_kementerian(){
	$this->db->select('idkem, namakem');
	$this->db->order_by("namakem", "ASC");
	$query = $this->db->get('lkp_kementerian');
	$kementerian = array();
	
	if($query->result()){
    	$kementerian[''] = '- Pilih Kementerian -';
		foreach ($query->result() as $kem){
        	$kementerian[$kem->idkem] = $kem->namakem;
		}
		return $kementerian;
	}
} 
 
public function get_jabatan(){
	$this->db->select('idjab_agensi_myspata1, nama_jab_agensi');
	$this->db->order_by("nama_jab_agensi", "ASC");
	$query = $this->db->get('lkp_jab_agensi');
	$jabatan = array();
	
	if($query->result()){
    	$jabatan[''] = '- Pilih Kementerian -';
		foreach ($query->result() as $jab){
        	$jabatan[$jab->idjab_agensi_myspata1] = $jab->nama_jab_agensi;
		}
		return $jabatan;
	}
} 

public function get_status(){
   	$this->db->select('status_id, nama_status');
   	$this->db->order_by("nama_status", "ASC");
   	$query = $this->db->get('lkp_status');
	$status = array();
	
	if($query->result()){
		$status[''] = '- Pilih Status -';
        foreach ($query->result() as $sta){
        	$status[$sta->status_id] = $sta->nama_status;
        }
      	return $status;
	}
}   

public function get_all_kandungan($id){
   	$this->db->select('*');
	$this->db->from('tbl_pspao');
	$this->db->join('tbl_kandungan','tbl_pspao.pspa_id = tbl_kandungan.pspa_id');
	$this->db->where('tbl_pspao.pspa_id',$id);
   	$query = $this->db->get();
	
	$row = $query->result();
	
	return $row;
	
}

public function get_tahun_mula_pspao($id){
   	$this->db->select('tahun_mula');
	$this->db->from('tbl_pspao');
	$this->db->join('tbl_kandungan','tbl_pspao.pspa_id = tbl_kandungan.pspa_id');
	$this->db->where('tbl_pspao.pspa_id',$id);
   	$query = $this->db->get();
	
	$row = $query->row();
	return $row->tahun_mula;
}
public function get_tahun_akhir_pspao($id){
   	$this->db->select('tahun_akhir');
	$this->db->from('tbl_pspao');
	$this->db->join('tbl_kandungan','tbl_pspao.pspa_id = tbl_kandungan.pspa_id');
	$this->db->where('tbl_pspao.pspa_id',$id);
   	$query = $this->db->get();
	
	$row = $query->row();
	return $row->tahun_akhir;
}
public function get_kementerian_pspao($id){
   	$this->db->select('idkem');
	$this->db->from('tbl_pspao');
	$this->db->join('tbl_kandungan','tbl_pspao.pspa_id = tbl_kandungan.pspa_id');
	$this->db->where('tbl_pspao.pspa_id',$id);
   	$query = $this->db->get();
	
	$row = $query->row();
	return $row->idkem;
}

public function update_kandungan_pspao($id){
	
	$input1 = $this->input->post('kand_id');
	$input2 = $this->input->post('kand_detail');
		
	$datang = array();
	
	for($i=0;$i<count($input1);$i++){
		$datang[$i]['kandungan_id'] = $input1[$i];
		$datang[$i]['kand_utama_detail'] = $input2[$i];
	}
	
	
	//print_r($datang);
	$this->db->update_batch('tbl_kandungan', $datang, 'kandungan_id');
	
	return $datang;
	
		
}


public function get_pspao_akhir_from_segment($id){
   	$this->db->select('*');
	$this->db->from('tbl_pspao');
	$this->db->join('tbl_kandungan','tbl_pspao.pspa_id = tbl_kandungan.pspa_id');
	$this->db->where('tbl_pspao.pspa_id',$id);
   	$query = $this->db->get();
	
	$row = $query->result();
	
	return $row;
	
}

public function get_pspao_awal_from_segment($id){
   	$this->db->select('*');
	$this->db->from('tbl_pspao_awal');
	$this->db->join('tbl_kandungan','tbl_pspao_awal.pspa_awal_id = tbl_kandungan.pspa_awal_id');
	$this->db->where('tbl_pspao_awal.pspa_awal_id',$id);
   	$query = $this->db->get();
	
	$row = $query->result();
	
	return $row;
	
}

public function get_pspao_awal_dpa_from_segment($id){
	$this->db->where('pspa_id',$id);
	$query = $this->db->get('tbl_pspa_akt_urusaset');
	
	return $query->row();
}

public function get_pspao_akhir_from_segment2($id){
   	$this->db->select('*');
	$this->db->from('tbl_pspao');
	$this->db->join('tbl_kandungan','tbl_pspao.pspa_id = tbl_kandungan.pspa_id');
	$this->db->limit(11,6);
	$this->db->where('tbl_pspao.pspa_id',$id);
   	$query = $this->db->get();
	
	$row = $query->result();
	
	return $row;
	
}

public function get_user_list($ukid,$kpid){

	$this->db->select('tbl_myspata_user_to_matrix.*,tbl_myspata_user.*,a.kump_pengguna_id');
	$this->db->where('tbl_myspata_user.idkem',$ukid);
	$this->db->where('a.kump_pengguna_id',$kpid);
	$this->db->from('tbl_myspata_user');
	$this->db->join('tbl_myspata_user_to_matrix', 'tbl_myspata_user_to_matrix.myspata_userid = tbl_myspata_user.myspata_userid', 'inner');
	$this->db->join('tbl_user_matrix as a', 'a.role_pengguna_id = tbl_myspata_user_to_matrix.role_pengguna_id');
	$this->db->group_by('tbl_myspata_user.myspata_userid');
	$this->db->order_by('tbl_myspata_user.nama_user', 'ASC');
	$query = $this->db->get();
	
	$data = array();
	
	if($query->result())
	foreach ($query->result() as $row) {         
		$data[] = $row;
	}
	return $data;   
} 





public function insert_pspao_akhir(){
	$sessionarray = $this->session->all_userdata();
	
	$data = array(
		'tahun_mula' => $this->input->post('tahun_mula'),
		'tahun_akhir' => $this->input->post('tahun_akhir'),
		'idkem' => $sessionarray['user_kemid'],
		'idjab_agensi' => $sessionarray['user_jabid'],
		'idnegeri' => $sessionarray['user_negid'],
		'pspa_sedia_oleh_id' => $sessionarray['user_id'],
		'pspa_semak_oleh_id' => $this->input->post('ptfid'),
		'pspa_lulus_oleh_id' => $this->input->post('ppid'),
		'pspa_tarikh_sedia' => date('Y-m-d')
	);

	$this->db->insert('tbl_pspao', $data);
	$idbaru = $this->db->insert_id();
	//$idbaru = 1;

	$kand_utama_bil = $this->input->post('kand_utama_bil');
	$kand_utama = $this->input->post('kand_utama');
	
	$data2 = array(
	
		array(
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[0],
			'kand_utama' => $kand_utama[0],
			'kand_utama_detail' => $this->input->post('kand_pendahuluan'),
			'node_type' => '0',
			'kand_type' => '1',
			'kand_form' => ''
		),
		array(
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[1],
			'kand_utama' => $kand_utama[1],
			'kand_utama_detail' => $this->input->post('kand_visi'),
			'node_type' => '0',
			'kand_type' => '1',
			'kand_form' => ''
		),
		array(
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[2],
			'kand_utama' => $kand_utama[2],
			'kand_utama_detail' => $this->input->post('kand_misi'),
			'node_type' => '0',
			'kand_type' => '1',
			'kand_form' => ''
		),
		array(
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[3],
			'kand_utama' => $kand_utama[3],
			'kand_utama_detail' => $this->input->post('kand_objektif'),
			'node_type' => '0',
			'kand_type' => '2',
			'kand_form' => 'f1'
		),
		array(
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[4],
			'kand_utama' => $kand_utama[4],
			'kand_utama_detail' => '',
			'node_type' => '0',
			'kand_type' => '3',
			'kand_form' => 'f2'
		),
		array(
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[5],
			'kand_utama' => $kand_utama[5],
			'kand_utama_detail' => $this->input->post('kand_polisi'),
			'node_type' => '0',
			'kand_type' => '2',
			'kand_form' => 'f3'
		),
	
	);
	
	$this->db->insert_batch('tbl_kandungan', $data2);
	
	return $idbaru;
}

public function insert_pspao_akhir_fungsiaset($id){
	
	$data = array(
	   'pspa_id' => $id,
	   'akt_terima_daftar_polisi' => $this->input->post('k1a'),
	   'akt_terima_daftar_output' => $this->input->post('k1b'),
	   'akt_operasi_senggara_polisi' => $this->input->post('k2a'),
	   'akt_operasi_senggara_output' => $this->input->post('k2b'),
	   'akt_penilaian_prestasi_polisi' => $this->input->post('k3a'),
	   'akt_penilaian_prestasi_output' => $this->input->post('k3b'),
	   'akt_pulih_ubah_naiktaraf_polisi' => $this->input->post('k4a'),
	   'akt_pulih_ubah_naiktaraf_output' => $this->input->post('k4b'),
	   'akt_lupus_polisi' => $this->input->post('k5a'),
	   'akt_lupus_output' => $this->input->post('k5b'),
	   'akt_hapuskira_polisi' => $this->input->post('k6a'),
	   'akt_hapuskira_output' => $this->input->post('k6b'),
	);

$this->db->insert('tbl_pspa_akt_urusaset', $data); 	

}



public function insert_pspao_akhir2($idbaru){
	$sessionarray = $this->session->all_userdata();
	
	$kand_utama_bil = $this->input->post('kand_utama_bil');
	$kand_utama = $this->input->post('kand_utama');
	
	$data2 = array(
	
		array(
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[0],
			'kand_utama' => $kand_utama[0],
			'kand_utama_detail' => $this->input->post('kand_pelaksanaan'),
			'node_type' => '0',
			'kand_type' => '1',
			'kand_form' => ''
		),
		array(
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[1],
			'kand_utama' => $kand_utama[1],
			'kand_utama_detail' => $this->input->post('kand_tadbir'),
			'node_type' => '7',
			'kand_type' => '1',
			'kand_form' => ''
		),
		array(
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[2],
			'kand_utama' => $kand_utama[2],
			'kand_utama_detail' => $this->input->post('kand_sistem'),
			'node_type' => '7',
			'kand_type' => '1',
			'kand_form' => ''
		),
		array(
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[3],
			'kand_utama' => $kand_utama[3],
			'kand_utama_detail' => $this->input->post('kand_kaedah_pelaksanaan'),
			'node_type' => '7',
			'kand_type' => '2',
			'kand_form' => 'f4'
		),
		array(
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[4],
			'kand_utama' => $kand_utama[4],
			'kand_utama_detail' => $this->input->post('kand_penyediaan_pelan'),
			'node_type' => '7',
			'kand_type' => '1',
			'kand_form' => ''
		),
		array(
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[5],
			'kand_utama' => $kand_utama[5],
			'kand_utama_detail' => $this->input->post('kand_pen_kep_sumber'),
			'node_type' => '7',
			'kand_type' => '1',
			'kand_form' => ''
		),
		array(
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[6],
			'kand_utama' => $kand_utama[6],
			'kand_utama_detail' => $this->input->post('kand_pemantauan_pel'),
			'node_type' => '7',
			'kand_type' => '1',
			'kand_form' => ''
		),
		array(
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[7],
			'kand_utama' => $kand_utama[7],
			'kand_utama_detail' => $this->input->post('kand_kajian_semula'),
			'node_type' => '0',
			'kand_type' => '1',
			'kand_form' => ''
		),
		array(
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[8],
			'kand_utama' => $kand_utama[8],
			'kand_utama_detail' => $this->input->post('kand_takwim_kpi'),
			'node_type' => '0',
			'kand_type' => '1',
			'kand_form' => ''
		),
		array(
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[9],
			'kand_utama' => $kand_utama[9],
			'kand_utama_detail' => $this->input->post('kand_penutup'),
			'node_type' => '0',
			'kand_type' => '1',
			'kand_form' => ''
		),
		array(
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[10],
			'kand_utama' => $kand_utama[10],
			'kand_utama_detail' => '',
			'node_type' => '0',
			'kand_type' => '3',
			'kand_form' => 'f5'
		),
	
	);
	
	$this->db->insert_batch('tbl_kandungan', $data2);
	
	return $idbaru;
}
public function insert_pspao_akhir2_form1($id){
	
	$kadval = $this->input->post('kaedah_perl');
	if($this->input->post('kaedah_perl')){ $kadval = NULL; }
	
	$data = array(
		'fld_penyataan_polisi' => $this->input->post('kaedah_perl'),
		'pspa_id' => $id,
		'kandungan_id' => '0'
	);
	
	$this->db->insert('tbl_pspa_kaedah_laksana', $data);
}

public function update_pspao_akhir($id){
	$sessionarray = $this->session->all_userdata();
	
	$data = array(
		'tahun_mula' => $this->input->post('tahun_mula'),
		'tahun_akhir' => $this->input->post('tahun_akhir'),
		'idkem' => $sessionarray['user_kemid'],
		'idjab_agensi' => $sessionarray['user_jabid'],
		'idnegeri' => $sessionarray['user_negid'],
		'pspa_sedia_oleh_id' => $sessionarray['user_negid'],
		'pspa_tarikh_sedia' => date('Y-m-d')
	);
	$this->db->where('pspa_id', $id);
	$this->db->update('tbl_pspao', $data);
	//$idbaru = $this->db->insert_id();
	$idbaru = $id;

	$kand_id = $this->input->post('kand_id');
	$kand_utama_bil = $this->input->post('kand_utama_bil');
	$kand_utama = $this->input->post('kand_utama');
	
	$data2 = array(
	
		array(
			'kandungan_id' => $kand_id[0],
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[0],
			'kand_utama' => $kand_utama[0],
			'kand_utama_detail' => $this->input->post('kand_pendahuluan'),
			'node_type' => '0',
			'kand_type' => '1'
		),
		array(
			'kandungan_id' => $kand_id[1],
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[1],
			'kand_utama' => $kand_utama[1],
			'kand_utama_detail' => $this->input->post('kand_visi'),
			'node_type' => '0',
			'kand_type' => '1'
		),
		array(
			'kandungan_id' => $kand_id[2],
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[2],
			'kand_utama' => $kand_utama[2],
			'kand_utama_detail' => $this->input->post('kand_misi'),
			'node_type' => '0',
			'kand_type' => '1'
		),
		array(
			'kandungan_id' => $kand_id[3],
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[3],
			'kand_utama' => $kand_utama[3],
			'kand_utama_detail' => $this->input->post('kand_objektif'),
			'node_type' => '0',
			'kand_type' => '2'
		),
		array(
			'kandungan_id' => $kand_id[4],
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[4],
			'kand_utama' => $kand_utama[4],
			'kand_utama_detail' => '',
			'node_type' => '0',
			'kand_type' => '3'
		),
		array(
			'kandungan_id' => $kand_id[5],
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[5],
			'kand_utama' => $kand_utama[5],
			'kand_utama_detail' => $this->input->post('kand_polisi'),
			'node_type' => '0',
			'kand_type' => '2'
		),
	
	);
	
	$this->db->update_batch('tbl_kandungan', $data2, 'kandungan_id');
	
	return $idbaru;

}
public function update_pspao_akhir2_form1($id){
	
	$kadval = $this->input->post('kaedah_perl');
	if($this->input->post('kaedah_perl')){ $kadval = NULL; }
	
	$data = array(
		'fld_penyataan_polisi' => $this->input->post('kaedah_perl')
	);
	
	if($this->update_pspao_akhir2_form1_cekdata($id)){
		$this->db->where('pspa_id',$id);
		$this->db->update('tbl_pspa_kaedah_laksana', $data);
	}else{
		$this->insert_pspao_akhir2_form1($id);
	}
	
}
public function update_pspao_akhir2_form1_cekdata($id){
	$this->db->where('pspa_id',$id);
	$query = $this->db->get('tbl_pspa_kaedah_laksana');
	if($query->row()){
		return TRUE;
	}else{return FALSE;}
}

public function get_kaedah_perlaksanaan($id){
	$this->db->where('pspa_id',$id);
	$query = $this->db->get('tbl_pspa_kaedah_laksana');
	if($query->num_rows() > 0){
		$row = $query->row(); 
		return $row->fld_penyataan_polisi;
	}else{
		return NULL;
	}
}

public function get_dokumenrujukan($id){
	
	$this->db->where('pspao_id', $id);
	$getDokumenrujukan = $this->db->get('tbl_lampiran');
	return $getDokumenrujukan->result();
}

public function tambah_dokumenrujukan($file){
	$data = array(  
	   'nama_fail' => $file[0],
       'nama_fail_asal' => $file[1],
       'lokasi_fail' =>$file[2],
       'jenis_fail' =>$file[3],
       'tarikh_upload' => date('Y-m-d H:i:s'),
       'pspao_id' => $file[4]
    );
    
    $panel = $this->db->insert('tbl_lampiran', $data);
}

public function hapus_pspao_akhir_lampiran($id){
	$this->db->where('lampiran_id', $id);
	$this->db->delete('tbl_lampiran'); 
	
	//echo $this->get_pspao_akhir_lampiran_fail($id);
}

public function get_pspao_akhir_lampiran_fail($lampiran_id){
    $this->db->where('lampiran_id', $lampiran_id);
	$retrieveDoc = $this->db->get('tbl_lampiran');
    $ret = $retrieveDoc->row();

    $docInfo = $ret->lokasi_fail;
    return $docInfo;
  }



public function update_pspao_akhir_fungsiaset($id){
	$data = array(
	   'akt_terima_daftar_polisi' => $this->input->post('k1a'),
	   'akt_terima_daftar_output' => $this->input->post('k1b'),
	   'akt_operasi_senggara_polisi' => $this->input->post('k2a'),
	   'akt_operasi_senggara_output' => $this->input->post('k2b'),
	   'akt_penilaian_prestasi_polisi' => $this->input->post('k3a'),
	   'akt_penilaian_prestasi_output' => $this->input->post('k3b'),
	   'akt_pulih_ubah_naiktaraf_polisi' => $this->input->post('k4a'),
	   'akt_pulih_ubah_naiktaraf_output' => $this->input->post('k4b'),
	   'akt_lupus_polisi' => $this->input->post('k5a'),
	   'akt_lupus_output' => $this->input->post('k5b'),
	   'akt_hapuskira_polisi' => $this->input->post('k6a'),
	   'akt_hapuskira_output' => $this->input->post('k6b'),
	);
	$this->db->where('pspa_id', $id);
	$this->db->update('tbl_pspa_akt_urusaset', $data);
}

public function update_pspao_akhir2($id){

	$idbaru = $id;

	$kand_id = $this->input->post('kand_id');
	$kand_utama_bil = $this->input->post('kand_utama_bil');
	$kand_utama = $this->input->post('kand_utama');
	
	$data2 = array(
	
		array(
			'kandungan_id' => $kand_id[0],
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[0],
			'kand_utama' => $kand_utama[0],
			'kand_utama_detail' => $this->input->post('kand_pelaksanaan'),
			'node_type' => '0',
			'kand_type' => '1'
		),
		array(
			'kandungan_id' => $kand_id[1],
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[1],
			'kand_utama' => $kand_utama[1],
			'kand_utama_detail' => $this->input->post('kand_tadbir'),
			'node_type' => '7',
			'kand_type' => '1'
		),
		array(
			'kandungan_id' => $kand_id[2],
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[2],
			'kand_utama' => $kand_utama[2],
			'kand_utama_detail' => $this->input->post('kand_sistem'),
			'node_type' => '7',
			'kand_type' => '1'
		),
		array(
			'kandungan_id' => $kand_id[3],
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[3],
			'kand_utama' => $kand_utama[3],
			'kand_utama_detail' => $this->input->post('kand_kaedah_pelaksanaan'),
			'node_type' => '7',
			'kand_type' => '2'
		),
		array(
			'kandungan_id' => $kand_id[4],
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[4],
			'kand_utama' => $kand_utama[4],
			'kand_utama_detail' => $this->input->post('kand_penyediaan_pelan'),
			'node_type' => '7',
			'kand_type' => '1'
		),
		array(
			'kandungan_id' => $kand_id[5],
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[5],
			'kand_utama' => $kand_utama[5],
			'kand_utama_detail' => $this->input->post('kand_pen_kep_sumber'),
			'node_type' => '7',
			'kand_type' => '1'
		),
		array(
			'kandungan_id' => $kand_id[6],
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[6],
			'kand_utama' => $kand_utama[6],
			'kand_utama_detail' => $this->input->post('kand_pemantauan_pel'),
			'node_type' => '7',
			'kand_type' => '1'
		),
		array(
			'kandungan_id' => $kand_id[7],
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[7],
			'kand_utama' => $kand_utama[7],
			'kand_utama_detail' => $this->input->post('kand_kajian_semula'),
			'node_type' => '0',
			'kand_type' => '1'
		),
		array(
			'kandungan_id' => $kand_id[8],
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[8],
			'kand_utama' => $kand_utama[8],
			'kand_utama_detail' => $this->input->post('kand_takwim_kpi'),
			'node_type' => '0',
			'kand_type' => '1'
		),
		array(
			'kandungan_id' => $kand_id[9],
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[9],
			'kand_utama' => $kand_utama[9],
			'kand_utama_detail' => $this->input->post('kand_penutup'),
			'node_type' => '0',
			'kand_type' => '1'
		),
		array(
			'kandungan_id' => $kand_id[10],
			'kump_kand_id' => '7',
			'pspa_id' => $idbaru,
			'kand_utama_bil' => $kand_utama_bil[10],
			'kand_utama' => $kand_utama[10],
			'kand_utama_detail' => '',
			'node_type' => '0',
			'kand_type' => '3'
		)
	
	);
	
	$this->db->update_batch('tbl_kandungan', $data2, 'kandungan_id');
	
	return $idbaru;

}

/////// FUNCTION UNTUK UKURAN DAN SASARAN //////////////




//get kandungan detail base on kandungan id

  function get_kandungan_form($kandid){
	  $this->db->where('kandungan_id',$kandid);
	  $query = $this->db->get('tbl_kandungan');
	  
	  $row = $query->row();
	  
	  return $row->kand_utama_detail;
  }
  
  function update_kandungan_form($kandid){
	
	
	$data = array(
	   'kand_utama_detail' => $this->input->post('kand_detail')
	);
	
	$this->db->where('kandungan_id',$kandid);
	$this->db->update('tbl_kandungan', $data);
  }
  
  function get_detail_form1(){
	  return 'Helo';
  }

  function get_ukuran_value($id){

   	$query=$this->db->query('
		SELECT po.pspa_obj_id,uk.node_type, po.utiliti_ukuran_id, uk.ukuran_tajuk, uk.sort, po.kandungan_sasaran, po.kandungan_kenyataan
		FROM tbl_pspa_objektif AS po
		LEFT JOIN lkp_utiliti_ukuran AS uk ON uk.utiliti_ukuran_id = po.utiliti_ukuran_id
		WHERE po.pspa_id ='.$id.'
		GROUP BY po.`utiliti_ukuran_id`
	');
    
    $row = $query->result();
  
    return $row;

  }

  function get_awal_ukuran_value($id){

   	$query=$this->db->query('
		SELECT po.pspa_obj_id,uk.node_type, po.utiliti_ukuran_id, uk.ukuran_tajuk, uk.sort, po.kandungan_sasaran, po.kandungan_kenyataan
		FROM tbl_pspa_awal_objektif AS po
		LEFT JOIN lkp_utiliti_ukuran AS uk ON uk.utiliti_ukuran_id = po.utiliti_ukuran_id
		WHERE po.pspa_id ='.$id.'
		GROUP BY po.`utiliti_ukuran_id`
	');
    
    $row = $query->result();
  
    return $row;

  }

  
  function get_ukuran_data(){

    $this->db->select('*');
    $this->db->from('lkp_utiliti_ukuran');
    //$this->db->where('pspa_awal_id',$id);
    $query = $this->db->get();

    $row = $query->result();
  
    return $row;

  }

  function get_ukuran_data_title(){

    $this->db->select('*');
    $this->db->from('lkp_utiliti_ukuran');
    $this->db->where('sort',0);
    $query = $this->db->get();

    $row = $query->result();
  
    return $row;


  }
  
	function insert_ukuran(){


		$sasaran = $this->input->post('sasaran');
		//print_r($sasaran);
		$kenyataan = $this->input->post('kenyataan');
		//print_r($kenyataan);

		$data = array();
  

		foreach($sasaran as $key => $datas){
			$data[$key]['pspa_id'] = $this->uri->segment(3);
			$data[$key]['utiliti_ukuran_id'] = $key;
			$data[$key]['kandungan_sasaran'] = $datas;

		}
		foreach($kenyataan as $key2 => $datas2){
			$data[$key2]['kandungan_kenyataan'] = $datas2;
		}
  
		//print_r($data);
		$this->db->insert_batch('tbl_pspa_objektif', $data);


	}
  
	function update_ukuran(){


		$pspa_obj_id = $this->input->post('pspa_obj_id');
		//print_r($sasaran);
		$sasaran = $this->input->post('sasaran');
		//print_r($sasaran);
		$kenyataan = $this->input->post('kenyataan');
		//print_r($kenyataan);
	
		$data = array();
  

		foreach($sasaran as $key => $datas){
			//$data[$key]['pspa_id'] = $this->uri->segment(3);
			//$data[$key]['utiliti_ukuran_id'] = $key;
			$data[$key]['kandungan_sasaran'] = $datas;
		}
		foreach($kenyataan as $key2 => $datas2){
			$data[$key2]['kandungan_kenyataan'] = $datas2;
		}

		foreach($pspa_obj_id as $key3 => $datas3){
			$data[$key3]['pspa_obj_id'] = $datas3;
		}

  
		//print_r($data);
		$this->db->update_batch('tbl_pspa_objektif', $data,'pspa_obj_id');


	}

  

///////	END FUNCTION UNTUK UKURAN DAN SASARAN //////////


public function get_data_dummy(){
	
	$data_1 =   array(
					array('1','PSPAO000001','2013','Kementerian','Mohd Kamil bin Ibrahim<br>(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge">Deraf</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href=""><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  	array('2','PSPAO000002','2013','Jabatan','Mohd Qoha bin Salehudin<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-info">Sah</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('3','PSPAO000003','2013','Jabatan','Mohd Saleh bin Yaakob<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-inverse">Pembetulan</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('4','PSPAO000004','2013','Kementerian','Mohd Khairul bin Ramli<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-warning">Semak</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('5','PSPAO000005','2013','Agensi','Mohd Kamil bin Ibrahim<br>(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge">Deraf</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('6','PSPAO000006','2013','Agensi','Mohd Qoha bin Salehudin<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-info">Sah</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('7','PSPAO000007','2013','Kementerian','Mohd Saleh bin Yaakob<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-inverse">Pembetulan</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('8','PSPAO000008','2013','Kementerian','Mohd Khairul bin Ramli<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-warning">Semak</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('9','PSPAO000009','2013','Jabatan','Mohd Kamil bin Ibrahim<br>(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge">Deraf</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('10','PSPAO000010','2013','Jabatan','Mohd Qoha bin Salehudin<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-info">Sah</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('11','PSPAO000011','2013','Jabatan','Mohd Saleh bin Yaakob<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-inverse">Pembetulan</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('12','PSPAO000012','2013','Agensi','Mohd Khairul bin Ramli<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-warning">Semak</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('13','PSPAO000013','2013','Agensi','Mohd Kamil bin Ibrahim<br>(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge">Deraf</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('14','PSPAO000014','2013','Kementerian','Mohd Qoha bin Salehudin<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-info">Sah</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('15','PSPAO000015','2013','Jabatan','Mohd Saleh bin Yaakob<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-inverse">Pembetulan</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('16','PSPAO000016','2013','Agensi','Mohd Khairul bin Ramli<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-warning">Semak</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('17','PSPAO000017','2013','Jabatan','Mohd Kamil bin Ibrahim<br>(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge">Deraf</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('18','PSPAO000018','2013','Jabatan','Mohd Qoha bin Salehudin<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-info">Sah</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('19','PSPAO000019','2013','Jabatan','Mohd Saleh bin Yaakob<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-inverse">Pembetulan</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('20','PSPAO000020','2013','Jabatan','Mohd Khairul bin Ramli<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-warning">Semak</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  
                  );

	return $data_1;
	
}



public function get_data_dummy_ketua_jabatan(){
	
	$data_1 =   array(
					array('1','PSPAO000001','2013','Kementerian','Mohd Kamil bin Ibrahim<br>(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge">Deraf</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  	array('2','PSPAO000002','2013','Jabatan','Mohd Qoha bin Salehudin<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-info">Sah</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  array('3','PSPAO000003','2013','Jabatan','Mohd Saleh bin Yaakob<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-inverse">Pembetulan</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  array('4','PSPAO000004','2013','Kementerian','Mohd Khairul bin Ramli<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-warning">Semak</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  array('5','PSPAO000005','2013','Agensi','Mohd Kamil bin Ibrahim<br>(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge">Deraf</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  array('6','PSPAO000006','2013','Agensi','Mohd Qoha bin Salehudin<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-info">Sah</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  array('7','PSPAO000007','2013','Kementerian','Mohd Saleh bin Yaakob<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-inverse">Pembetulan</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  array('8','PSPAO000008','2013','Kementerian','Mohd Khairul bin Ramli<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-warning">Semak</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  array('9','PSPAO000009','2013','Jabatan','Mohd Kamil bin Ibrahim<br>(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge">Deraf</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  array('10','PSPAO000010','2013','Jabatan','Mohd Qoha bin Salehudin<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-info">Sah</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  array('11','PSPAO000011','2013','Jabatan','Mohd Saleh bin Yaakob<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-inverse">Pembetulan</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  array('12','PSPAO000012','2013','Agensi','Mohd Khairul bin Ramli<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-warning">Semak</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  array('13','PSPAO000013','2013','Agensi','Mohd Kamil bin Ibrahim<br>(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge">Deraf</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  array('14','PSPAO000014','2013','Kementerian','Mohd Qoha bin Salehudin<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-info">Sah</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  array('15','PSPAO000015','2013','Jabatan','Mohd Saleh bin Yaakob<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-inverse">Pembetulan</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  array('16','PSPAO000016','2013','Agensi','Mohd Khairul bin Ramli<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-warning">Semak</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  array('17','PSPAO000017','2013','Jabatan','Mohd Kamil bin Ibrahim<br>(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge">Deraf</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  array('18','PSPAO000018','2013','Jabatan','Mohd Qoha bin Salehudin<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-info">Sah</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  array('19','PSPAO000019','2013','Jabatan','Mohd Saleh bin Yaakob<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-inverse">Pembetulan</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  array('20','PSPAO000020','2013','Jabatan','Mohd Khairul bin Ramli<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-warning">Semak</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ketuajab_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  
                  );

	return $data_1;
	
}

public function get_asetkhusus(){
	
	$data_1 =   array('Blok A','Blok B','Blok C','Blok D','Blok Kantin');

	return $data_1;
	
}

public function get_data_dummy_jkrpata2a(){
	
	$data_1 =   array(
					array('1','2,000.00','2,000.00','2,000.00','16,000.00','4,000.00','<ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
					array('2','10,000.00','10,000.00','12,000.00','5,000.00','2,000.00','<ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
					array('3','2,000.00','2,000.00','20,000.00','2,000.00','7,000.00','<ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
					array('4','2,000.00','2,000.00','23,000.00','16,000.00','2,000.00','<ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
					array('5','12,000.00','9,000.00','29,000.00','34,000.00','8,000.00','<ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
					array('6','2,000.00','2,000.00','2,000.00','6,000.00','4,000.00','<ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
					array('7','2,000.00','2,000.00','2,000.00','16,000.00','4,000.00','<ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
					array('8','10,000.00','10,000.00','12,000.00','5,000.00','2,000.00','<ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
					array('9','2,000.00','2,000.00','20,000.00','2,000.00','7,000.00','<ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
					array('10','2,000.00','2,000.00','23,000.00','16,000.00','2,000.00','<ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
					array('11','12,000.00','9,000.00','29,000.00','34,000.00','8,000.00','<ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
					array('12','2,000.00','2,000.00','2,000.00','6,000.00','4,000.00','<ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
					array('13','2,000.00','2,000.00','2,000.00','16,000.00','4,000.00','<ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
					array('14','10,000.00','10,000.00','12,000.00','5,000.00','2,000.00','<ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
					array('15','2,000.00','2,000.00','20,000.00','2,000.00','7,000.00','<ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
					array('16','2,000.00','2,000.00','23,000.00','16,000.00','2,000.00','<ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
					array('17','12,000.00','9,000.00','29,000.00','34,000.00','8,000.00','<ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
					array('18','2,000.00','2,000.00','2,000.00','6,000.00','4,000.00','<ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul>' ),
                  
                  );

	return $data_1;
	
}




public function get_data_dummy_all(){
	
	$data_1 =   array(
					array('1','PSPAO000001','2013','Kementerian','Mohd Kamil bin Ibrahim<br>(PP)','02/01/2013','<span class="badge">Deraf</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_pp_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href=""><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  	array('2','PSPAO000002','2013','Jabatan','Mohd Qoha bin Salehudin<br />(PTF)','02/01/2013','<span class="badge badge-info">Sah</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('3','PSPAO000003','2013','Jabatan','Mohd Saleh bin Yaakob<br />(PPD)','02/01/2013','<span class="badge badge-inverse">Pembetulan</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ppd_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('4','PSPAO000004','2013','Kementerian','Mohd Khairul bin Ramli<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-warning">Semak</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('5','PSPAO000005','2013','Agensi','Mohd Kamil bin Ibrahim<br>(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge">Deraf</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('6','PSPAO000006','2013','Agensi','Mohd Qoha bin Salehudin<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-info">Sah</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('7','PSPAO000007','2013','Kementerian','Mohd Saleh bin Yaakob<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-inverse">Pembetulan</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('8','PSPAO000008','2013','Kementerian','Mohd Khairul bin Ramli<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-warning">Semak</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('9','PSPAO000009','2013','Jabatan','Mohd Kamil bin Ibrahim<br>(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge">Deraf</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('10','PSPAO000010','2013','Jabatan','Mohd Qoha bin Salehudin<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-info">Sah</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('11','PSPAO000011','2013','Jabatan','Mohd Saleh bin Yaakob<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-inverse">Pembetulan</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('12','PSPAO000012','2013','Agensi','Mohd Khairul bin Ramli<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-warning">Semak</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('13','PSPAO000013','2013','Agensi','Mohd Kamil bin Ibrahim<br>(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge">Deraf</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('14','PSPAO000014','2013','Kementerian','Mohd Qoha bin Salehudin<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-info">Sah</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('15','PSPAO000015','2013','Jabatan','Mohd Saleh bin Yaakob<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-inverse">Pembetulan</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('16','PSPAO000016','2013','Agensi','Mohd Khairul bin Ramli<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-warning">Semak</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('17','PSPAO000017','2013','Jabatan','Mohd Kamil bin Ibrahim<br>(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge">Deraf</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('18','PSPAO000018','2013','Jabatan','Mohd Qoha bin Salehudin<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-info">Sah</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('19','PSPAO000019','2013','Jabatan','Mohd Saleh bin Yaakob<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-inverse">Pembetulan</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  array('20','PSPAO000020','2013','Jabatan','Mohd Khairul bin Ramli<br />(Pegawai Teknikal Fasiliti)','02/01/2013','<span class="badge badge-warning">Semak</span>','<ul class="icomoon-icons-container"><a href="'.site_url('pspao/senarai_pspao_akhir_ptf_2').'"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe026;"></span> </li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe027;"></span></li></a></ul><ul class="icomoon-icons-container"><a href="#"><li class="rounded"><span class="fs1" aria-hidden="true" data-icon="&#xe0a7;"></span></li></a></ul>' ),
                  
                  );

	return $data_1;
	
}

   function get_senarai_ptf_pspao_akhir()

   {
        

       $this->db->select('*');
      // $this->db->where('status',0);
       $this->db->where('tbl_pspao.idkem', $this->session->userdata('user_kemid'));
       $this->db->where_not_in('tbl_pspao.pspa_tarikh_sedia','0000-00-00 00:00:00');

/*	   
	   if($this->session->userdata('user_rolegroupid')==8) {

        $this->db->where('tbl_statuslog.status_id',1);
        $this->db->or_where('tbl_statuslog.status_id', 2); 
        //$this->db->where('tbl_statuslog.status_id',2);
          
          }elseif($this->session->userdata('user_rolegroupid')==4){

           $this->db->where('tbl_statuslog.status_id',3);
           $this->db->or_where('tbl_statuslog.status_id', 2); 
        //$this->db->where('tbl_statuslog.status_id',6);

          }elseif($this->session->userdata('user_rolegroupid')==3){

         $this->db->where('tbl_statuslog.status_id',4);
         $this->db->or_where('tbl_statuslog.status_id', 6); 
        //$this->db->where('tbl_statuslog.status_id',6);

          }
      	$this->db->join('tbl_statuslog', 'tbl_pspao.pspa_id = tbl_statuslog.pspa_id', 'inner'); 
	  
	  
		$this->db->order_by('tbl_statuslog.status_tarikh','DESC');
      	//$this->db->group_by('tbl_pspao.pspa_id');	   
*/	
	   
       $this->db->from('tbl_pspao');
       $query = $this->db->get();

       $data = array();

       if($query->result())
       foreach ($query->result() as $row) {
         
         $data[] = $row;
       }

       return $data;

    
   }
   
	function get_kementerian_name($user_kemid){

        $this->db->select('namakem');
        $this->db->where('idkem', $user_kemid);
        $get_namakem = $this->db->get('lkp_kementerian');

             $row = $get_namakem->row();
          
       return $row->namakem;
        
        //return $get_namakem->result();

	}

    function get_nama_pemilik_doc($userid){

       $this->db->select('*');
       $this->db->where('myspata_userid',$userid);
       $this->db->from('tbl_myspata_user');
       $query = $this->db->get();

       $userdata = array();

       if($query->result())
       foreach ($query->result() as $row) {
         
         $userdata[] = $row;
       }

       return $userdata;


    }

function get_pspao_id($userid){

        $this->db->select('pspa_id');
        $this->db->where('pspa_sedia_oleh_id', $userid);
        $this->db->where('pspa_sedia_oleh_id', 0);
        
        $get_pspa_id = $this->db->get('tbl_pspao');


          
        $row = $get_pspa_id->row();

       if ($get_pspa_id->num_rows() > 0){
          
       return $row->pspa_id;

        }else{

          return 0;
        }
}

   function get_senarai_pspao()

   {
       
    $mu = $this->session->all_userdata();
       $this->db->select('*');
       // $this->db->where('status',0);
       $this->db->where('idkem', $this->session->userdata('user_kemid'));
	   //$this->db->where('', $mu['user_id']);
       $this->db->where_not_in('pspa_tarikh_sedia','0000-00-00 00:00:00');
       $this->db->from('tbl_pspao_awal');
       $this->db->order_by("pspa_awal_id", "DESC");



       $query = $this->db->get();

       $data = array();

       if($query->result())
       foreach ($query->result() as $row) {
         
         $data[] = $row;
       }

       return $data;

    
   }


public function updatepspaoakhir($userid,$lastid,$jabagensi,$idnegeri){

    $data = array(
              'idjab_agensi' => $jabagensi,
               'idnegeri' => $idnegeri,
               'pspa_semak_oleh_id' => $userid
               
            );

  $this->db->where('pspa_id', $lastid);
  $data = $this->db->update('tbl_pspao', $data); 

  return $data;



  }


  

public function insert_status_log($id,$idcek){

	$sessionarray = $this->session->all_userdata();
	
	  $data = array(
		'status_id' => $idcek,
		'status_tarikh' => date('Y-m-d H:i:s'),
		'myspata_userid' => $sessionarray['user_id'],
		'pspa_id' => $id,
		'kump_kand_id' => 7,
		'status_ulasan' => $this->input->post('alasanbelaka'),
		'rekod_pelan_id' => 0
	  );
	
	  $this->db->insert('tbl_statuslog', $data);
	
	}
	
	
	
	
	
  public function insert_sessionkey($ppid,$ptfid,$pspaoid,$seskey){
	$data = array(
	   'sess_ppid' => $ppid ,
	   'sess_ptfid' => $ptfid ,
	   'sess_pspao_awal_id' => $pspaoid, //kusang update
	   'sess_key' => $seskey
	);
	
	$this->db->insert('tbl_pspao_sessionid', $data); 	
  }
  
  public function get_pspao_awal_from_key($key){ //kusang update
	$this->db->select('sess_pspao_awal_id');
	$this->db->where('sess_key', $key);
	$query = $this->db->get('tbl_pspao_sessionid');
	
	if ($query->num_rows() > 0){
	   $row = $query->row(); 
	   return $row->sess_pspao_awal_id;
	}	
  }

  public function update_sessionkey($ppdid,$seskey){
	$data = array(
	   'sess_ppdid' => $ppdid
	);
	$this->db->where('sess_key', $seskey);
	$this->db->update('tbl_pspao_sessionid', $data); 	
  }
  
  public function get_ulasan_terbaru($pspaid,$kump){
	$this->db->select('status_ulasan');
	$this->db->where('pspa_id', $pspaid);
	$this->db->where('kump_kand_id', $kump);
	$this->db->order_by('statuslog_id', 'DESC');
	
	$query = $this->db->get('tbl_statuslog');
	
	if($query->row()){ 
	  
	  $row = $query->row();
	  return $row->status_ulasan;
	}else{
	  return FALSE;
	}
  }
  
  public function get_ppid_pspao($id){
	$this->db->select('pspa_lulus_oleh_id');
	$this->db->where('pspa_id', $id);
	$query = $this->db->get('tbl_pspao');
	
	if ($query->num_rows() > 0){
	   $row = $query->row(); 
	   return $row->pspa_lulus_oleh_id;
	}	
  }
  public function get_ptfid_pspao($id){
	$this->db->select('pspa_semak_oleh_id');
	$this->db->where('pspa_id', $id);
	$query = $this->db->get('tbl_pspao');
	
	if ($query->num_rows() > 0){
	   $row = $query->row(); 
	   return $row->pspa_semak_oleh_id;
	}	
  }
  public function get_ppdid_pspao($id){
	$this->db->select('pspa_sedia_oleh_id');
	$this->db->where('pspa_id', $id);
	$query = $this->db->get('tbl_pspao');
	
	if ($query->num_rows() > 0){
	   $row = $query->row(); 
	   return $row->pspa_sedia_oleh_id;
	}	
  }
  
	function update_pspao_date_sah($id){
	
		$data = array(
	
		'pspa_tarikh_semak' => date('Y-m-d')
	  );
	  $this->db->where('pspa_id', $id);
	  $this->db->update('tbl_pspao', $data);
	
	}
	
	function update_pspao_date_lulus($id){
	
		$data = array(
	
		'pspa_tarikh_lulus' => date('Y-m-d')
	  	);
	  	$this->db->where('pspa_id', $id);
	  	$this->db->update('tbl_pspao', $data);
	
	}

  
  
  ######### yann ###########
    // function untuk cari session key ptf pp ppd
   function get_session_key($sess_key)
    {
        //$this->db->select('utiliti_sumber_man_id');
        $this->db->where('sess_key', $sess_key);
        $getSess = $this->db->get('tbl_pspao_sessionid');
        
        return $getSess->result();
    }
    
  
 

   function get_pspaoid(){   /// get pspao id yg dh di create

    $sessionarray = $this->session->all_userdata();

    $this->db->select('pspa_id');
    $this->db->from('tbl_pspao');
    $this->db->where('pspa_sedia_oleh_id',$sessionarray['user_id']);
    $this->db->where('pspa_tarikh_sedia','0000-00-00');
    $query = $this->db->get();
  
    $row = $query->row();

    if($row){
  
    return $row->pspa_id;
    
    }else{

    return 0;

    }

   }
   
   function get_pspao_akhir_ptf_id($id){  /// get ptf id utk pspao 

		$sessionarray = $this->session->all_userdata();
	
		$this->db->select('pspa_semak_oleh_id');
		$this->db->from('tbl_pspao');
		$this->db->where('pspa_id',$id);
		$query = $this->db->get();
	  
		$row = $query->row();
	
		if($row){
			return $row->pspa_semak_oleh_id;
		}else{
			return 0;
		}

   }
   function get_pspao_akhir_pp_id($id){  /// get ptf id utk pspao 

    $sessionarray = $this->session->all_userdata();

    $this->db->select('pspa_lulus_oleh_id');
    $this->db->from('tbl_pspao');
    $this->db->where('pspa_id',$id);
    $query = $this->db->get();
  
    $row = $query->row();

    if($row){
  
    return $row->pspa_lulus_oleh_id;
    
    }else{

    return 0;

    }

   }
   
     function get_pspaoawal_key($pspa_awal_id)
    {
        //$this->db->select('utiliti_sumber_man_id');
        $this->db->where('pspa_awal_id', $pspa_awal_id);
        $getSessPawal = $this->db->get('tbl_pspao_awal');
        
        return $getSessPawal->result();
    }
	
	
	function get_pspao_sah_value($id){

		$this->db->select('pspa_tarikh_semak');
		$this->db->from('tbl_pspao');
		$this->db->where('pspa_id',$id);
		
		$query = $this->db->get();
		$row = $query->row();
	
		return $row->pspa_tarikh_semak;
	}	
	
   function get_senarai_status($pspa_id,$kump_kand_id)

   {
       
    
       $this->db->select('*');
      $this->db->from('tbl_statuslog');
       $this->db->where('pspa_id', $pspa_id);
       $this->db->where('kump_kand_id', $kump_kand_id);
       $this->db->join('lkp_status','lkp_status.status_id= tbl_statuslog.status_id');
       $this->db->join('tbl_myspata_user','tbl_myspata_user.myspata_userid= tbl_statuslog.myspata_userid');
      
         $this->db->order_by("statuslog_id", "DESC");



       $query = $this->db->get();

       $data = array();

       if($query->result())
       foreach ($query->result() as $row) {
         
         $data[] = $row;
       }

       return $data;

    
   }

   function get_namakategoristatus($kump_kand_id)
    {
        $this->db->select('*');
        $this->db->where('kump_kand_id', $kump_kand_id);
        $get_namasta = $this->db->get('lkp_kump_kand');
        
        return $get_namasta->result();
    }
	
	
	
	////////////// FUNCTION UNTUK CEK STATUS CONTENT DETAIL JER DLM PSPAO AKHIR //////////////////
	
	function cek_status_f1($id){
		$this->db->where('pspa_id',$id);
		$query = $this->db->get('tbl_pspa_objektif');
		
		if ($query->num_rows() > 0){
		   $chek = 1;
		   foreach ($query->result() as $row){
			  if($row->kandungan_sasaran == 0 || $row->kandungan_kenyataan == NULL){
			  	$chek = 0;
			  }
		   }
		   if($chek == 0){
			   return FALSE;
		   }else{
			   return TRUE;
		   }
		}else{
			return FALSE;
		}
				
	}
	function cek_status_f3($id){
		$this->db->where('pspa_id',$id);
		$query = $this->db->get('tbl_pspa_akt_urusaset');
		
		if ($query->num_rows() > 0){
		   $chek = 1;
		   $row = $query->row();
			  if($row->akt_terima_daftar_polisi == NULL || $row->akt_terima_daftar_output == NULL || $row->akt_operasi_senggara_polisi == NULL || $row->akt_operasi_senggara_output == NULL || $row->akt_penilaian_prestasi_polisi == NULL || $row->akt_penilaian_prestasi_output == NULL || $row->akt_pulih_ubah_naiktaraf_polisi == NULL || $row->akt_pulih_ubah_naiktaraf_output == NULL || $row->akt_lupus_polisi == NULL || $row->akt_lupus_output == NULL || $row->akt_hapuskira_polisi == NULL || $row->akt_hapuskira_output == NULL){
			  	$chek = 0;
			  }
		   if($chek == 0){
			   return FALSE;
		   }else{
			   return TRUE;
		   }
		}else{
			return FALSE;
		}
				
	}
	function cek_status_f4($id){
		$this->db->where('pspa_id',$id);
		$query = $this->db->get('tbl_pspa_kaedah_laksana');
		
		if ($query->num_rows() > 0){
			$row = $query->row(); 
			if($row->fld_penyataan_polisi != NULL){
				return TRUE;
			}else{
				return FALSE;
			}
		}else{
			return FALSE;
		}
	}
	function cek_status_f5($id){
		$this->db->where('pspao_id',$id);
		$query = $this->db->get('tbl_lampiran');
		
		if ($query->num_rows() > 0){
			return TRUE;
		}else{
			return FALSE;
		}
	}


}

