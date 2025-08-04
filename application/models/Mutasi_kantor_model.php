<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi_kantor_model extends CI_Model
{
    private $table = 'mutasi_kantor';

    // Ambil semua data
    public function get_all()
    {
        return $this->db->order_by('tanggal', 'DESC')->get($this->table)->result();
    }

    // Ambil data berdasarkan ID
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    // Simpan data baru
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Update data
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    // Hapus data
    public function delete($id)
    {
        return $this->db->where('id', $id)->delete($this->table);
    }
}
