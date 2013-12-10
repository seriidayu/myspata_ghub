<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

class Pspao_model extends CI_Model {

  function __construct(){
  
    parent::__construct();
    date_default_timezone_set('Asia/Kuala_Lumpur');
  
}


function get_kementerian_name($user_kemid){

         $this->db->select('namakem');
        $this->db->where('idkem', $user_kemid);
        $get_namakem = $this->db->get('lkp_kementerian');


          
       $row = $get_namakem->row();



          
       return $row->namakem;
        
        //return $get_namakem->result();

}
   
  function get_jabatan_name($user_jabid){


        $this->db->select('nama_jab_agensi');
        $this->db->where('idjab_agensi', $user_jabid);
        $get_namakem = $this->db->get('lkp_jab_agensi');
        
        return $get_namakem->result();


  }

  function tambahpspaotahun($user_kemid)

  {

 $sessionarray = $this->session->all_userdata();

   $data = array('tahun_mula' => $this->input->post('tempoh_mula'),
                 'tahun_akhir' => $this->input->post('tempoh_akhir'),
                 'idkem' => $user_kemid,
                 'pspa_lulus_oleh_id' =>$sessionarray['user_id']
                );
        
      $tempoh = $this->db->insert('tbl_pspao_awal', $data);
      $lastid = $this->db->insert_id();

      
           
      return $lastid;
    
        

  }


   function get_user_list($user_kemid,$kump_pengguna_id)  //dapatkan senarai user
 {

      $this->db->select('tbl_myspata_user_to_matrix.*,tbl_myspata_user.*,a.kump_pengguna_id');
       $this->db->where('tbl_myspata_user.idkem',$user_kemid);
       $this->db->where('a.kump_pengguna_id',$kump_pengguna_id);
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
  
function get_detail_user($userid)  //dapatkan ppd kementerian
 {

       $this->db->select('*');
       $this->db->where('myspata_userid ',$userid);
       $this->db->from('tbl_myspata_user');
      $query = $this->db->get();

       $data = array();


      if ($query->result())
     {
   foreach ($query->result() as $row)
   {
      $data[] = $row;
      
   }
}

    
       return $data;

       
    
   
   } 


function get_pspao_awal_id($userid){

        $this->db->select('pspa_awal_id');
        $this->db->where('pspa_semak_oleh_id', $userid);
        $this->db->where('pspa_sedia_oleh_id', 0);
        
        $get_pspa_awal_id = $this->db->get('tbl_pspao_awal');


          
        $row = $get_pspa_awal_id->row();

       if ($get_pspa_awal_id->num_rows() > 0){
          
       return $row->pspa_awal_id;

        }else{

          return 0;
        }
}

 function updatepspaoawalptf($userid,$lastid){

    $data = array(
          
               'pspa_semak_oleh_id' => $userid,
          
            );

  $this->db->where('pspa_awal_id', $lastid);
  $data = $this->db->update('tbl_pspao_awal', $data); 

  return $data;



  }


   
  function updatepspaoawal($userid,$lastid,$jabagensi,$idnegeri){

    $data = array(
              'idjab_agensi' => $jabagensi,
               'idnegeri' => $idnegeri,
               'pspa_sedia_oleh_id' => $userid
               
            );

  $this->db->where('pspa_awal_id', $lastid);
  $data = $this->db->update('tbl_pspao_awal', $data); 

  return $data;



  }



  function getuserdetail($userid){

        $this->db->select('nama_jab_agensi');
        $this->db->where('idjab_agensi', $user_jabid);
        $get_namakem = $this->db->get('lkp_jab_agensi');
        
        return $get_namakem->result();

  }

   
   
   
   function get_senarai_pp_pspao()
   {
      $this->db->select('*');
      // $this->db->where('status',0);
      // $this->db->where('myspata_userid_to',$session_id);
       $this->db->from('tbl_pspao');
       $query = $this->db->get();

       $data = array();

       if($query->result())
       foreach ($query->result() as $row) {
         
         $data[] = $row;
       }

       return $data; 
   }
   
   
   function get_senarai_pspao()

   {
       
    
       $this->db->select('*');
      // $this->db->where('status',0);
       $this->db->where('idkem', $this->session->userdata('user_kemid'));
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

   
   public function get_pspao_awal_from_segment($id){

  $this->db->select('*');
  $this->db->from('tbl_pspao_awal');
  $this->db->join('tbl_kandungan','tbl_pspao_awal.pspa_awal_id = tbl_kandungan.pspa_awal_id');
  $this->db->where('tbl_pspao_awal.pspa_awal_id',$id);
    $query = $this->db->get();
  
  $row = $query->result();
  
  return $row;
  
}
  

  public function insert_pspao_awal($id){

  $sessionarray = $this->session->all_userdata();
  
$data = array(
    /*'tahun_mula' => $this->input->post('tahun_mula'),
    'tahun_akhir' => $this->input->post('tahun_akhir'),*/
    'idkem' => $sessionarray['user_kemid'],
    'idjab_agensi' => $sessionarray['user_jabid'],
    'idnegeri' => $sessionarray['user_negid'],
    //'iddaerah' => $sessionarray['user_negid'],
    'pspa_sedia_oleh_id' => $sessionarray['user_id'],

    'pspa_tarikh_sedia' => date('Y-m-d')
  );
  $this->db->where('pspa_awal_id', $id);
  $this->db->update('tbl_pspao_awal', $data);
  
  //echo $idbaru;
  //$idbaru = 1;

  $kand_utama_bil = $this->input->post('kand_bil');
  $kand_utama = $this->input->post('kand_utama');
  $kand_detail = $this->input->post('kand_detail');
  
  $data2 = array(
  
    array(
      'kump_kand_id' => '1',
      'pspa_awal_id' => $id,
      'kand_utama_bil' => $kand_utama_bil[0],
      'kand_utama' => $kand_utama[0],
      'kand_utama_detail' => $kand_detail[0],
      'node_type' => '0',
      'kand_type' => '1'
    ),
    array(
      'kump_kand_id' => '1',
      'pspa_awal_id' => $id,
      'kand_utama_bil' => $kand_utama_bil[1],
      'kand_utama' => $kand_utama[1],
      'kand_utama_detail' => $kand_detail[1],
      'node_type' => '0',
      'kand_type' => '1'
    ),
    array(
      'kump_kand_id' => '1',
      'pspa_awal_id' => $id,
      'kand_utama_bil' => $kand_utama_bil[2],
      'kand_utama' => $kand_utama[2],
      'kand_utama_detail' => $kand_detail[2],
      'node_type' => '0',
      'kand_type' => '1'
    ),
    array(
      'kump_kand_id' => '1',
      'pspa_awal_id' => $id,
      'kand_utama_bil' => $kand_utama_bil[3],
      'kand_utama' => $kand_utama[3],
      'kand_utama_detail' => $kand_detail[3],
      'node_type' => '0',
      'kand_type' => '1'
    )
    
    
  );
  
  $this->db->insert_batch('tbl_kandungan', $data2);
  
  return true;
  

}


public function insert_status_log($id_pspao_awal,$status){

$sessionarray = $this->session->all_userdata();


  $data = array(
    'status_id' => $status,
    'status_tarikh' => date('Y-m-d H:i:s'),
    'myspata_userid' => $sessionarray['user_id'],
    //'status_ulasan' => $status_ulasan,
    'pspa_id' => $id_pspao_awal,
    'kump_kand_id' => 1,
    'rekod_pelan_id' => 0
    
  );

  $this->db->insert('tbl_statuslog', $data);


}


public function insert_status_log_ulasan($id_pspao_awal,$status){

$sessionarray = $this->session->all_userdata();


  $data = array(
    'status_id' => $status,
    'status_tarikh' => date('Y-m-d H:i:s'),
    'myspata_userid' => $sessionarray['user_id'],
    'status_ulasan' => $this->input->post('ulasan'),
    'pspa_id' => $id_pspao_awal,
    'kump_kand_id' => 1,
    'rekod_pelan_id' => 0
    
  );

  $this->db->insert('tbl_statuslog', $data);


}


function update_pspao_date_sah($id){

$data = array(

    'pspa_tarikh_semak' => date('Y-m-d')
  );
  $this->db->where('pspa_awal_id', $id);
  $this->db->update('tbl_pspao_awal', $data);


}

function update_pspao_date_lulus($id){

$data = array(

    'pspa_tarikh_lulus' => date('Y-m-d')
  );
  $this->db->where('pspa_awal_id', $id);
  $this->db->update('tbl_pspao_awal', $data);


}


public function update_pspao_awal($id){
  $sessionarray = $this->session->all_userdata();
  
  $data = array(
    /*'tahun_mula' => $this->input->post('tahun_mula'),
    'tahun_akhir' => $this->input->post('tahun_akhir'),*/
    'idkem' => $sessionarray['user_kemid'],
    'idjab_agensi' => $sessionarray['user_jabid'],
    'idnegeri' => $sessionarray['user_negid'],
    //'iddaerah' => $sessionarray['user_negid'],
    'pspa_sedia_oleh_id' => $sessionarray['user_id'],

    'pspa_tarikh_sedia' => date('Y-m-d')
  );
  $this->db->where('pspa_awal_id', $id);
  $this->db->update('tbl_pspao_awal', $data);
  //$idbaru = $this->db->insert_id();
  //$idbaru = $id;

  $kand_utama_bil = $this->input->post('kand_utama_bil');
  $kand_utama = $this->input->post('kand_utama');
  
  $data2 = array(
  
    array(
      'kump_kand_id' => '1',
      'pspa_awal_id' => $id,
      'kand_utama_bil' => $kand_utama_bil[0],
      'kand_utama' => $kand_utama[0],
      'kand_utama_detail' => $this->input->post('kand_pendahuluan'),
      'node_type' => '0',
      'kand_type' => '1'
    ),
    array(
      'kump_kand_id' => '1',
      'pspa_awal_id' => $id,
      'kand_utama_bil' => $kand_utama_bil[1],
      'kand_utama' => $kand_utama[1],
      'kand_utama_detail' => $this->input->post('kand_visi'),
      'node_type' => '0',
      'kand_type' => '1'
    ),
    array(
      'kump_kand_id' => '1',
      'pspa_awal_id' => $id,
      'kand_utama_bil' => $kand_utama_bil[2],
      'kand_utama' => $kand_utama[2],
      'kand_utama_detail' => $this->input->post('kand_misi'),
      'node_type' => '0',
      'kand_type' => '1'
    ),
    array(
      'kump_kand_id' => '1',
      'pspa_awal_id' => $id,
      'kand_utama_bil' => $kand_utama_bil[3],
      'kand_utama' => $kand_utama[3],
      'kand_utama_detail' => $this->input->post('kand_objektif'),
      'node_type' => '0',
      'kand_type' => '1'
    )
    
    
  );
  
  $this->db->insert_batch('tbl_kandungan', $data2);
  
  return TRUE;

}


public function get_pspao_detail($id){

  $this->db->select('*');
  $this->db->from('tbl_pspao_awal');
  $this->db->join('tbl_kandungan','tbl_pspao_awal.pspa_awal_id = tbl_kandungan.pspa_awal_id');
  $this->db->where('tbl_pspao_awal.pspa_awal_id',$id);
  $query = $this->db->get();
  
  $row = $query->result();
  
  return $row;
  

}



public function get_kem_name($id){

  $this->db->select('*');
  $this->db->from('tbl_pspao_awal');
  $this->db->join('lkp_kementerian','tbl_pspao_awal.idkem = lkp_kementerian.idkem');
  $this->db->where('tbl_pspao_awal.pspa_awal_id',$id);
  $query = $this->db->get();
  
  $row = $query->row();
  
  return $row->namakem;
  

}
  

  public function get_tahun_mula($id){

  $this->db->select('tahun_mula');
  $this->db->from('tbl_pspao_awal');
   $this->db->where('pspa_awal_id',$id);
   $query = $this->db->get();
  
  $row = $query->row();
  
  return $row->tahun_mula;
  

  }

  public function get_tahun_akhir($id){

  $this->db->select('tahun_akhir');
  $this->db->from('tbl_pspao_awal');
   $this->db->where('pspa_awal_id',$id);
  $query = $this->db->get();
  
  $row = $query->row();
  
  return $row->tahun_akhir;
  

  }


  public function update_pspao_awal_edit($id)

  {


   $input1 = $this->input->post('kand_id');
   $input2 = $this->input->post('kand_detail');

   $data3 = array();
  
  for($i=0;$i<count($input1);$i++){
    $data3[$i]['kandungan_id'] = $input1[$i];
    $data3[$i]['kand_utama_detail'] = $input2[$i];
  }
  
  $this->db->update_batch('tbl_kandungan', $data3, 'kandungan_id');

  
  return true;
  
   }


   function get_tempoh_mula(){

     $sessionarray = $this->session->all_userdata();
    
    $this->db->select('tahun_mula');
    $this->db->from('tbl_pspao_awal');
    $this->db->where('pspa_sedia_oleh_id',$sessionarray['user_id']);
    $this->db->where('pspa_tarikh_sedia','0000-00-00');
    $query = $this->db->get();
  
    $row = $query->row();
  
    return $row->tahun_mula;
  

   } 

   function get_tempoh_akhir(){

     $sessionarray = $this->session->all_userdata();
    
    $this->db->select('tahun_akhir');
    $this->db->from('tbl_pspao_awal');
    $this->db->where('pspa_sedia_oleh_id',$sessionarray['user_id']);
    $this->db->where('pspa_tarikh_sedia','0000-00-00');
    $query = $this->db->get();
  
    $row = $query->row();
  
    return $row->tahun_akhir;
  

   } 

   function get_pspaoawalid(){   /// get pspao awal id yg dh di create

    $sessionarray = $this->session->all_userdata();

    $this->db->select('pspa_awal_id');
    $this->db->from('tbl_pspao_awal');
    $this->db->where('pspa_sedia_oleh_id',$sessionarray['user_id']);
    $this->db->where('pspa_tarikh_sedia','0000-00-00');
    $query = $this->db->get();
  
    $row = $query->row();

    if($row){
  
    return $row->pspa_awal_id;
    
    }else{

    return 0;

    }

   }



function get_pspao_ptf_id($id){  /// get ptf id utk pspao 

    $sessionarray = $this->session->all_userdata();

    $this->db->select('pspa_semak_oleh_id');
    $this->db->from('tbl_pspao_awal');
    $this->db->where('pspa_awal_id',$id);
    $query = $this->db->get();
  
    $row = $query->row();

    if($row){
  
    return $row->pspa_semak_oleh_id;
    
    }else{

    return 0;

    }

   }


   function get_pspao_ppd_id($id){  /// get ppd id utk pspao 


    $this->db->select('pspa_sedia_oleh_id');
    $this->db->from('tbl_pspao_awal');
    $this->db->where('pspa_awal_id',$id);
    $query = $this->db->get();
  
    $row = $query->row();

    if($row){
  
    return $row->pspa_sedia_oleh_id;
    
    }else{

    return 0;

    }

   }


 function get_pspao_pp_id($id){  /// get ppd id utk pspao 


    $this->db->select('pspa_lulus_oleh_id');
    $this->db->from('tbl_pspao_awal');
    $this->db->where('pspa_awal_id',$id);
    $query = $this->db->get();
  
    $row = $query->row();

    if($row){
  
    return $row->pspa_lulus_oleh_id;
    
    }else{

    return 0;

    }

   }

   function get_latest_status_pspao($id){

    $query = $this->db->query('SELECT status_id FROM tbl_statuslog WHERE pspa_id ='.$id.' AND 
    status_tarikh IN (SELECT max( status_tarikh ) FROM tbl_statuslog)');

   $row = $query->row();

    if($row){
   return $row->status_id;
    }else{
      return 0;
    }

   }

   function get_ketua_jab_agensi_id($idkem){

  $this->db->select('tbl_myspata_user.myspata_userid');
       $this->db->where('tbl_myspata_user.idkem',$idkem);
       //$this->db->where('tbl_myspata_user_to_matrix.role_pengguna_id',6);
       $this->db->where_in('tbl_myspata_user_to_matrix.role_pengguna_id',array('6', '7', '8'));
       $this->db->from('tbl_myspata_user');
       $this->db->join('tbl_myspata_user_to_matrix', 'tbl_myspata_user_to_matrix.myspata_userid = tbl_myspata_user.myspata_userid', 'inner');
       $this->db->join('tbl_user_matrix as a', 'a.role_pengguna_id = tbl_myspata_user_to_matrix.role_pengguna_id');
       $this->db->group_by('tbl_myspata_user.myspata_userid');
       $this->db->order_by('tbl_myspata_user.nama_user', 'ASC');
       
  $query = $this->db->get();
  
  $row = $query->result();
  
  return $row;

   }
    
}

?>