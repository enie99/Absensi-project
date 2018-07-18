<?php

class Mkaryawan extends CI_Model
{

	function tampil()
	{
		$id = $_SESSION['user']['perusahaan_id'];
		$ambil = $this->db->query("SELECT * FROM _karyawan k 
				LEFT JOIN _lokasi l ON k.lokasi_id = l.lokasi_id
				WHERE l.perusahaan_id = '$id' ");
		return $ambil->result_array();
	}

	function tampil_id($id,$lokasi_id)
	{
		$id = $_SESSION['user']['perusahaan_id'];
		$ambil = $this->db->query("SELECT * FROM _karyawan k 
				RIGHT JOIN _lokasi l ON k.lokasi_id = l.lokasi_id
				WHERE l.perusahaan_id = '$id' AND k.lokasi_id = '$lokasi_id' ");
		return $ambil->result_array();
	}

	function show_karyawan_id_pagination($limit, $page)
	{
		$id = $_SESSION['user']['perusahaan_id'];
		$this->db->order_by('_karyawan.karyawan_id','DESC');
		$this->db->where('_perusahaan.perusahaan_id', $id);		
		$this->db->join('_lokasi','_lokasi.lokasi_id = _karyawan.lokasi_id');
		$this->db->join('_perusahaan','_perusahaan.perusahaan_id = _lokasi.perusahaan_id');
		$ambil = $this->db->get('_karyawan', $batas, $from);
		return $ambil->result_array();
	}

	function cari($keyword){
		$id = $_SESSION['user']['perusahaan_id'];
		$this->db->like('karyawan_nama', $keyword);
		$this->db->where('_perusahaan.perusahaan_id', $id);		
		$this->db->join('_lokasi','_lokasi.lokasi_id = _karyawan.lokasi_id');
		$this->db->join('_perusahaan','_perusahaan.perusahaan_id = _lokasi.perusahaan_id');
		$ambil = $this->db->get('_karyawan');
		return $ambil->result_array();
	}

	function get_by_id($id)
	{
		$this->db->where('karyawan_id', $id);
		$ambil = $this->db->get('_karyawan');
		return $ambil->row_array();
	}

	function daftar_perusahaan()
	{
		$id = $_SESSION['user']['perusahaan_id'];
		$this->db->where('perusahaan_id',$id);
		$ambil = $this->db->get('_lokasi');
		return $ambil->result_array();
	}

	function tambah($input){
		$input['karyawan_user'] = $input['karyawan_email'];
		$this->db->insert('_karyawan', $input);
		redirect('mastercms/karyawan', 'refresh');
	}

	function edit($input, $id){
		$this->db->where('karyawan_id', $id);
		$this->db->update('_karyawan', $input);
		redirect('mastercms/karyawan', 'refresh');
	}

	function hapus($id){
		$this->db->where('karyawan_id', $id);
		$this->db->delete('_karyawan');
	}

	function detail($id){
		$this->db->join('_lokasi', '_karyawan.lokasi_id = _lokasi.lokasi_id','right');
		$this->db->where('_karyawan.karyawan_id', $id);
		$data = $this->db->get('_karyawan');
		return $data->row_array();
	}
}
?>