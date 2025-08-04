<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FixedVariableCost_model extends CI_Model {

    protected $table = 'fixed_variable_cost';

    // Ambil semua data
    public function get_all()
    {
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get($this->table)->result();
    }

    // Ambil data berdasarkan filter tanggal
    public function get_filtered($start_date, $end_date)
    {
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get($this->table)->result();
    }

    // Ambil data per kategori (Fixed / Variable)
    public function get_by_kategori($kategori, $start_date = null, $end_date = null)
    {
        $this->db->where('kategori', $kategori);

        if ($start_date && $end_date) {
            $this->db->where('tanggal >=', $start_date);
            $this->db->where('tanggal <=', $end_date);
        }

        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get($this->table)->result();
    }

    // Ambil satu baris berdasarkan ID
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
        $this->db->where('id', $id);
        return $this->db->update($this->table, $data);
    }

    // Hapus data
    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    // Total nominal berdasarkan kategori
    public function total_kategori($kategori, $start_date = null, $end_date = null)
    {
        $this->db->where('kategori', $kategori);

        if ($start_date && $end_date) {
            $this->db->where('tanggal >=', $start_date);
            $this->db->where('tanggal <=', $end_date);
        }

        $this->db->select_sum('nominal');
        return $this->db->get($this->table)->row()->nominal;
    }

    // Total keseluruhan
    public function total_semua($start_date = null, $end_date = null)
    {
        if ($start_date && $end_date) {
            $this->db->where('tanggal >=', $start_date);
            $this->db->where('tanggal <=', $end_date);
        }

        $this->db->select_sum('nominal');
        return $this->db->get($this->table)->row()->nominal;
    }
}
