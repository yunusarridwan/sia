<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gaji_model extends CI_Model {

    private $table = 'gaji';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function get_all($start_date = null, $end_date = null)
    {
        $this->db->select('gaji.*, karyawan.nama');
        $this->db->from('gaji');
        $this->db->join('karyawan', 'karyawan.karyawan_id = gaji.karyawan_id', 'left');
        
        if ($start_date) {
            $this->db->where('gaji.bulan >=', date('Y-m', strtotime($start_date)));
        }
        if ($end_date) {
            $this->db->where('gaji.bulan <=', date('Y-m', strtotime($end_date)));
        }

        $this->db->order_by('gaji.bulan', 'desc');
        $this->db->order_by('karyawan.nama', 'asc');
        return $this->db->get()->result();
    }

    public function get_by_id($id)
    {
        $this->db->select('gaji.*, karyawan.nama');
        $this->db->from('gaji');
        $this->db->join('karyawan', 'karyawan.karyawan_id = gaji.karyawan_id', 'left');
        $this->db->where('gaji.id', $id);
        return $this->db->get()->row();
    }

    public function simpan($data)
    {
        return $this->db->insert($this->table, $data);
    }

    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update($this->table, $data);
    }

    public function check_existing($karyawan_id, $bulan)
    {
        $this->db->where('karyawan_id', $karyawan_id);
        $this->db->where('bulan', $bulan);
        return $this->db->get($this->table)->row();
    }
}