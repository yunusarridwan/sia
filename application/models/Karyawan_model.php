<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    // Ambil semua data karyawan
    public function get_all()
    {
        return $this->db->select('id, karyawan_id, nama, jabatan, gaji_pokok, no_rekening, status, tgl_masuk, tgl_resign')
                        ->from('karyawan')
                        ->get()
                        ->result();
    }

    // Ambil satu karyawan berdasarkan ID (id di database)
    public function get_by_id($id)
    {
        return $this->db->get_where('karyawan', ['id' => $id])->row();
    }

    // Ambil berdasarkan jabatan (misalnya untuk komisi atau filter SDM)
    public function get_by_jabatan($jabatan_array)
    {
        return $this->db->where_in('jabatan', $jabatan_array)->get('karyawan')->result();
    }

    // Tambah data karyawan
    public function insert($data)
    {
        return $this->db->insert('karyawan', $data);
    }

    // Update data karyawan berdasarkan id
    public function update($id, $data)
    {
        return $this->db->where('id', $id)->update('karyawan', $data);
    }

    // Hapus data karyawan
    public function delete($id)
    {
        return $this->db->delete('karyawan', ['id' => $id]);
    }

    // Ambil berdasarkan ID fingerprint (opsional kalau kamu ingin integrasi absensi)
    public function get_by_karyawan_id($karyawan_id)
    {
        return $this->db->get_where('karyawan', ['karyawan_id' => $karyawan_id])->row();
    }

    public function get_aktif()
{
    return $this->db->where('status', 'Aktif')->get('karyawan')->result();
}

}
