<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gaji_model extends CI_Model {

    private $table = 'gaji';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function insert_batch($data)
    {
        return $this->db->insert_batch($this->table, $data);
    }
    
    // Mengecek apakah data absensi sudah ada
    public function is_exist($karyawan_id, $tanggal)
    {
        return $this->db
            ->where('karyawan_id', $karyawan_id)
            ->where('tanggal', $tanggal)
            ->get($this->table)
            ->num_rows() > 0;
    }
    

    public function get_all($start_date = null, $end_date = null)
    {
        $this->db->select('gaji.*, karyawan.nama');
        $this->db->from($this->table);
        $this->db->join('karyawan', 'karyawan.id = gaji.karyawan_id', 'left');
        
        // Tambahkan filter tanggal jika ada
        if ($start_date) {
            $this->db->where('gaji.bulan >=', $start_date);
        }
        if ($end_date) {
            $this->db->where('gaji.bulan <=', $end_date);
        }

        $this->db->order_by('gaji.bulan', 'desc');
        return $this->db->get()->result();
    }

    // Ambil data gaji berdasarkan ID (untuk edit/detail) dengan join
    public function get_by_id($id)
    {
        $this->db->select('gaji.*, karyawan.nama');
        $this->db->from($this->table);
        $this->db->join('karyawan', 'karyawan.id = gaji.karyawan_id', 'left');
        $this->db->where('gaji.id', $id);
        return $this->db->get()->row();
    }

    public function insert($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function simpan($data)
    {
        return $this->insert($data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function delete($id)
    {
        return $this->db->delete($this->table, ['id' => $id]);
    }

    public function check_existing($karyawan_id, $bulan)
    {
        $this->db->where('karyawan_id', $karyawan_id);
        $this->db->where('bulan', $bulan);
        return $this->db->get($this->table)->row();
    }
}