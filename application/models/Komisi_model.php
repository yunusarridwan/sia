<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Komisi_model extends CI_Model {

    public function insert($data)
    {
        return $this->db->insert('komisi', $data);
    }

    public function get_rekap($start_date, $end_date)
    {
        $this->db->select('
            k.karyawan_id,
            k.nama,
            SUM(CASE WHEN c.jenis = "Komisi" AND c.tipe = "Mini" THEN c.total_amount ELSE 0 END) as komisi_mini,
            SUM(CASE WHEN c.jenis = "Komisi" AND c.tipe = "Reguler" THEN c.total_amount ELSE 0 END) as komisi_reguler,
            SUM(CASE WHEN c.jenis = "OR" THEN c.total_amount ELSE 0 END) as total_or
        ');
        $this->db->from('karyawan k');
        $this->db->join('komisi c', 'k.karyawan_id = c.karyawan_id AND c.tanggal >= "'.$start_date.'" AND c.tanggal <= "'.$end_date.'"', 'left');
        
        // PERBAIKAN: Jangan ikutkan "Karyawan Kantor" dalam rekap payout
        $this->db->where('k.karyawan_id !=', 'K-KANTOR');

        $this->db->group_by('k.karyawan_id, k.nama');
        $this->db->order_by('k.nama', 'ASC');
        
        return $this->db->get()->result_array();
    }
    
    // FUNGSI BARU: Untuk menghitung total komisi office secara terpisah
    public function get_total_office_commission($start_date, $end_date)
    {
        $this->db->select_sum('total_amount');
        $this->db->where('karyawan_id', 'K-KANTOR');
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        $result = $this->db->get('komisi')->row();
        return $result->total_amount ?? 0;
    }

    public function get_detail($karyawan_id, $start_date, $end_date)
    {
        return $this->db
            ->where('karyawan_id', $karyawan_id)
            ->where('tanggal >=', $start_date)
            ->where('tanggal <=', $end_date)
            ->order_by('tanggal', 'ASC')
            ->get('komisi')->result_array();
    }

    // application/models/Komisi_model.php

    public function get_all_detail($start_date, $end_date)
    {
        $this->db->select('komisi.*, karyawan.nama as nama_karyawan');
        $this->db->from('komisi');
        $this->db->join('karyawan', 'karyawan.karyawan_id = komisi.karyawan_id', 'left');
        $this->db->where('komisi.tanggal >=', $start_date);
        $this->db->where('komisi.tanggal <=', $end_date);
        $this->db->order_by('komisi.tanggal', 'ASC');
        return $this->db->get()->result_array();
    }
}