<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_advance_model extends CI_Model {

    public function insert($data)
    {
        return $this->db->insert('cash_advance', $data);
    }

    public function get_total_ca_per_karyawan($start_date, $end_date)
    {
        $this->db->select('karyawan_id, SUM(jumlah) as total_ca');
        $this->db->from('cash_advance');
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        $this->db->group_by('karyawan_id');
        
        $query = $this->db->get()->result_array();
        
        $result = [];
        foreach ($query as $row) {
            $result[$row['karyawan_id']] = $row['total_ca'];
        }
        return $result;
    }

    public function get_detail($karyawan_id, $start_date, $end_date)
    {
        return $this->db
            ->where('karyawan_id', $karyawan_id)
            ->where('tanggal >=', $start_date)
            ->where('tanggal <=', $end_date)
            ->order_by('tanggal', 'ASC')
            ->get('cash_advance')->result_array();
    }
    
    public function get_all_detail($start_date = null, $end_date = null)
    {
        $this->db->select('
            ca.*, 
            k.nama as nama_karyawan,
            k.jabatan,
            k.no_rekening,
            (SELECT SUM(lot) FROM komisi 
             WHERE karyawan_id = ca.karyawan_id 
             AND tanggal >= "'.$start_date.'" 
             AND tanggal <= "'.$end_date.'") as total_lot
        ');
        $this->db->from('cash_advance ca');
        $this->db->join('karyawan k', 'k.karyawan_id = ca.karyawan_id', 'left');

        if ($start_date) {
            $this->db->where('ca.tanggal >=', $start_date);
        }
        if ($end_date) {
            $this->db->where('ca.tanggal <=', $end_date);
        }

        $this->db->order_by('ca.tanggal', 'DESC');
        return $this->db->get()->result();
    }
    
    public function get_summary($start_date = null, $end_date = null)
    {
        $this->db->select('
            SUM(jumlah) as total_pengambilan,
            COUNT(id) as jumlah_transaksi
        ');
        $this->db->from('cash_advance');

        if ($start_date) {
            $this->db->where('tanggal >=', $start_date);
        }
        if ($end_date) {
            $this->db->where('tanggal <=', $end_date);
        }

        return $this->db->get()->row();
    }
}