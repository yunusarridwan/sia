<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pettycash_model extends CI_Model {

    // Ambil semua data petty cash
    public function get_all()
    {
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get('pettycash')->result();
    }

    // Ambil data berdasarkan filter tanggal
    public function get_filtered($start_date, $end_date)
    {
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get('pettycash')->result();
    }

    // Ambil data berdasarkan ID
    public function get_by_id($id)
    {
        return $this->db->get_where('pettycash', ['id' => $id])->row();
    }

    // Tambah data baru
    public function insert($data)
    {
        return $this->db->insert('pettycash', $data);
    }

    // Update data
    public function update($id, $data)
    {
        $this->db->where('id', $id);
        return $this->db->update('pettycash', $data);
    }

    // Hapus data
    public function delete($id)
    {
        return $this->db->delete('pettycash', ['id' => $id]);
    }

    // Total nominal keseluruhan (opsional)
    public function total_nominal($start_date = null, $end_date = null)
    {
        if ($start_date && $end_date) {
            $this->db->where('tanggal >=', $start_date);
            $this->db->where('tanggal <=', $end_date);
        }
        $this->db->select_sum('nominal');
        return $this->db->get('pettycash')->row()->nominal;
    }

    // ✅ Total berdasarkan kategori (Variable Cost)
    public function total_per_kategori($kategori, $start_date = null, $end_date = null)
    {
        $this->db->where('kategori', $kategori);
        if ($start_date && $end_date) {
            $this->db->where('tanggal >=', $start_date);
            $this->db->where('tanggal <=', $end_date);
        }
        $this->db->select_sum('nominal');
        return $this->db->get('pettycash')->row()->nominal;
    }

    // ✅ Total berdasarkan keterangan (Fixed Cost)
    public function total_per_keterangan($keterangan, $start_date = null, $end_date = null)
    {
        $this->db->where('keterangan', $keterangan);
        if ($start_date && $end_date) {
            $this->db->where('tanggal >=', $start_date);
            $this->db->where('tanggal <=', $end_date);
        }
        $this->db->select_sum('nominal');
        return $this->db->get('pettycash')->row()->nominal;
    }

    // ✅ Ambil semua data berdasarkan kategori
    public function get_by_kategori($kategori, $start_date = null, $end_date = null)
    {
        $this->db->where('kategori', $kategori);
        if ($start_date && $end_date) {
            $this->db->where('tanggal >=', $start_date);
            $this->db->where('tanggal <=', $end_date);
        }
        $this->db->order_by('tanggal', 'ASC');
        return $this->db->get('pettycash')->result();
    }

    // ✅ Tanggal terakhir berdasarkan kategori
    public function get_last_date_by_kategori($kategori, $start_date = null, $end_date = null)
    {
        $this->db->select('tanggal');
        $this->db->where('kategori', $kategori);
        if ($start_date && $end_date) {
            $this->db->where('tanggal >=', $start_date);
            $this->db->where('tanggal <=', $end_date);
        }
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit(1);
        $result = $this->db->get('pettycash')->row();
        return $result ? $result->tanggal : null;
    }

    // ✅ Tanggal terakhir berdasarkan keterangan
    public function get_last_date_by_keterangan($keterangan, $start_date = null, $end_date = null)
    {
        $this->db->select('tanggal');
        $this->db->where('keterangan', $keterangan);
        if ($start_date && $end_date) {
            $this->db->where('tanggal >=', $start_date);
            $this->db->where('tanggal <=', $end_date);
        }
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit(1);
        $result = $this->db->get('pettycash')->row();
        return $result ? $result->tanggal : null;
    }
}
