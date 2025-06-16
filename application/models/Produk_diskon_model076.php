<?php
defined('BASEPATH') or exit('No direct script Allowed');

class Produk_diskon_model076 extends CI_Model
{
	private $_table = "prodiskon2211500076";

	public function get_all()
	{
		$this->db->select('
			prodiskon2211500076.id_diskon076,
			prodiskon2211500076.nama076,
			prodiskon2211500076.jumlah_diskon076,
			prodiskon2211500076.deskripsi076,
			produk.nama as pd_nama');
		$this->db->from($this->_table);
		$this->db->join('produk', 'produk.id_produk = prodiskon2211500076.produk_id');

		$query = $this->db->get();
		return $query->result_array();
	}

	public function tambah($data)
	{
		$this->db->insert($this->_table, $data);
		#untuk check apakah berhasil atau tidak input data
		return $this->db->insert_id();
	}

	public function get_by_id($id)
	{
		$this->db->where('id_diskon076', $id);
		$query = $this->db->get($this->_table);
		return $query->row_array();
	}

	public function get_by_produk_id($produk_id)
	{
		$this->db->where('produk_id', $produk_id);
		$query = $this->db->get($this->_table);
		return $query->row_array(); // hanya ambil satu, jika satu produk satu diskon
	}


	public function hapus($id)
	{
		$this->db->delete($this->_table, array('id_diskon076'=>$id));
		return ($this->db->affected_rows() !=1)? false : true;
	}

	public function ubah($data, $id){
		$this->db->where('id_diskon076', $id);
		$this->db->update($this->_table, $data);
		return($this->db->affected_rows() !=1) ? false :true;
	}

}