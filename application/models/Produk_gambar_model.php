<?php
defined('BASEPATH') or exit('No direct script Allowed');

class produk_gambar_model extends CI_Model
{
	private $_table = "produk_gambar";

	public function tambah($data)
	{
		$this->db->insert($this->_table,$data);
	}

	public function get_by_product_id($id)
	{
		$this->db->where('produk_id',$id);
		$query = $this->db->get($this->_table);
		return $query->result_array();
	}

	public function hapus($id)
	{
		$this->db->delete($this->_table, array('id_gambar'=> $id));
	}

	public function get_by_id($id)
    {
        return $this->db->get_where('produk_gambar', ['id_gambar' => $id])->row_array();
    }
}