<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gaji_model extends CI_Model {

    private $table = 'gaji';

    // Ambil semua data gaji dengan join ke tabel karyawan
    public function get_all()
    {
        $this->db->select('gaji.*, karyawan.nama');
        $this->db->from($this->table);
        $this->db->join('karyawan', 'karyawan.karyawan_id = gaji.karyawan_id', 'left');
        $this->db->order_by('gaji.bulan', 'desc');
        return $this->db->get()->result();
    }

    // Ambil data gaji berdasarkan ID (untuk edit/detail)
    public function get_by_id($id)
    {
        return $this->db->get_where($this->table, ['id' => $id])->row();
    }

    // Simpan data gaji baru
    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    // Alias dari insert(), untuk keperluan controller
    public function simpan($data)
    {
        return $this->insert($data); // Supaya tidak perlu duplikasi
    }

    // Update data gaji
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    // Hapus data gaji
    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    // Cek apakah gaji untuk karyawan dan bulan tertentu sudah ada
    public function check_existing($karyawan_id, $bulan)
    {
        $this->db->where('karyawan_id', $karyawan_id);
        $this->db->where('bulan', $bulan);
        return $this->db->get($this->table)->row();
    }
}
