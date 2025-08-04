<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi_model extends CI_Model
{
    public function insert_batch($data)
    {
        return $this->db->insert_batch('absensi', $data);
    }

    public function get_filtered($start, $end)
{
    return $this->db->select('absensi.*, karyawan.nama')
                    ->from('absensi')
                    ->join('karyawan', 'absensi.karyawan_id = karyawan.karyawan_id', 'left')
                    ->where('tanggal >=', $start)
                    ->where('tanggal <=', $end)
                    ->order_by('tanggal', 'DESC')
                    ->get()
                    ->result();
}



    public function is_exist($karyawan_id, $tanggal)
    {
        return $this->db
            ->where('karyawan_id', $karyawan_id)
            ->where('tanggal', $tanggal)
            ->get('absensi')
            ->num_rows() > 0;
    }

    public function get_all()
{
    return $this->db->select('absensi.*, karyawan.nama')
                    ->from('absensi')
                    ->join('karyawan', 'absensi.karyawan_id = karyawan.karyawan_id', 'left')
                    ->order_by('tanggal', 'DESC')
                    ->get()
                    ->result();
}


    public function rekap_bulanan($karyawan_id, $bulan)
{
    $this->db->select('status');
    $this->db->from('absensi');
    $this->db->where('karyawan_id', $karyawan_id);
    $this->db->like('tanggal', $bulan);

    $result = $this->db->get()->result();

    $hadir = 0;
    $izin = 0;
    $telat = 0;

    foreach ($result as $row) {
        if ($row->status == 'Hadir') {
            $hadir++;
        } elseif ($row->status == 'Izin') {
            $izin++;
        } elseif ($row->status == 'Telat') {
            $telat++;
        }
    }

    return [
        'hadir' => $hadir,
        'izin' => $izin,
        'telat' => $telat
    ];
}

public function rekap_range($karyawan_id, $start, $end)
{
    $this->db->where('karyawan_id', $karyawan_id);
    $this->db->where('tanggal >=', $start);
    $this->db->where('tanggal <=', $end);
    $query = $this->db->get('absensi')->result();

    $hasil = ['hadir' => 0, 'telat' => 0, 'izin' => 0];
    foreach ($query as $row) {
        if ($row->status == 'Hadir') $hasil['hadir']++;
        elseif ($row->status == 'Telat') $hasil['telat']++;
        elseif ($row->status == 'Izin') $hasil['izin']++;
    }

    return $hasil;
}

public function get_summary($karyawan_id, $start_date, $end_date)
{
    $this->db->select('
        SUM(CASE WHEN status = "Hadir" THEN 1 ELSE 0 END) AS total_hadir,
        SUM(CASE WHEN status = "Izin" THEN 1 ELSE 0 END) AS total_izin,
        SUM(CASE WHEN status = "Sakit" THEN 1 ELSE 0 END) AS total_sakit,
        SUM(CASE WHEN status = "Telat" THEN 1 ELSE 0 END) AS total_telat
    ');
    $this->db->where('karyawan_id', $karyawan_id);
    $this->db->where('tanggal >=', $start_date);
    $this->db->where('tanggal <=', $end_date);
    return $this->db->get('absensi')->row();
}


}
