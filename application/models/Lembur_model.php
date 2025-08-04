<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Lembur_model extends CI_Model {

    private $table = 'rekap_lembur';

    // Ambil semua data lembur
    public function get_all() {
        return $this->db->get($this->table)->result();
    }

    // Ambil data lembur berdasarkan karyawan_id
    public function get_by_karyawan($karyawan_id) {
        return $this->db
            ->where('karyawan_id', $karyawan_id)
            ->order_by('tanggal', 'ASC')
            ->get($this->table)
            ->result();
    }

    // Ambil satu data lembur berdasarkan ID
    public function get_by_id($id) {
        return $this->db
            ->where('id', $id)
            ->get($this->table)
            ->row();
    }

    // Insert data lembur
    public function insert($data) {
        return $this->db->insert($this->table, $data);
    }

    // Update data lembur berdasarkan ID
    public function update($id, $data) {
        return $this->db
            ->where('id', $id)
            ->update($this->table, $data);
    }

    // Hapus data lembur berdasarkan ID
    public function delete($id) {
        return $this->db
            ->where('id', $id)
            ->delete($this->table);
    }

    /**
     * Hitung total uang tambahan dari jam lembur dan uang makan berdasarkan durasi
     */
    public function total_tambahan($karyawan_id, $tanggal_awal, $tanggal_akhir) {
        $this->db->select('jam_mulai, jam_selesai, uang_makan');
        $this->db->from($this->table);
        $this->db->where('karyawan_id', $karyawan_id);
        $this->db->where('tanggal >=', $tanggal_awal);
        $this->db->where('tanggal <=', $tanggal_akhir);

        $query = $this->db->get()->result();

        $total = 0;
        foreach ($query as $row) {
            $mulai = strtotime($row->jam_mulai);
            $selesai = strtotime($row->jam_selesai);
            $durasi_jam = round(($selesai - $mulai) / 3600);
            $uang_makan = (int) $row->uang_makan;
            $total += ($durasi_jam * 10000) + $uang_makan;
        }

        return $total;
    }

    /**
     * Hitung total dari kolom 'total_tambahan' (jika field ini ada di tabel)
     */
    public function total_range($karyawan_id, $start, $end) {
        $this->db->select_sum('total_tambahan');
        $this->db->where('karyawan_id', $karyawan_id);
        $this->db->where('tanggal >=', $start);
        $this->db->where('tanggal <=', $end);
        $result = $this->db->get($this->table)->row();

        return $result->total_tambahan ?? 0;
    }

    /**
     * Hitung total lembur (uang lembur + uang makan) dari rentang tanggal
     */
    public function get_total_tambahan($karyawan_id, $start_date, $end_date)
{
    $this->db->select('jam_mulai, jam_selesai, uang_makan');
    $this->db->from('rekap_lembur');
    $this->db->where('karyawan_id', $karyawan_id);
    $this->db->where('tanggal >=', $start_date);
    $this->db->where('tanggal <=', $end_date);

    $query = $this->db->get()->result();

    $total = 0;
    foreach ($query as $row) {
        $mulai = strtotime($row->jam_mulai);
        $selesai = strtotime($row->jam_selesai);
        $durasi_jam = round(($selesai - $mulai) / 3600);

        $uang_makan = (int) $row->uang_makan;
        $uang_lembur = $durasi_jam * 10000;

        $total += $uang_lembur + $uang_makan;
    }

    return $total;
}

}
