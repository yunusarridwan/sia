<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Absensi_model extends CI_Model
{
    private $table = 'absensi';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }
    
    public function insert_batch($data)
    {
        return $this->db->insert_batch($this->table, $data);
    }
    
    public function is_exist($karyawan_id, $tanggal)
    {
        return $this->db
            ->where('karyawan_id', $karyawan_id)
            ->where('tanggal', $tanggal)
            ->get($this->table)
            ->num_rows() > 0;
    }

    public function get_all()
    {
        $this->db->select('absensi.*, karyawan.nama');
        $this->db->from('absensi');
        // PERBAIKAN: Menggunakan nama tabel `karyawan`
        $this->db->join('karyawan', 'karyawan.karyawan_id = absensi.karyawan_id', 'left');
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get()->result();
    }

    public function get_filtered($start, $end)
    {
        $this->db->select('absensi.*, karyawan.nama');
        $this->db->from('absensi');
        // PERBAIKAN: Menggunakan nama tabel `karyawan`
        $this->db->join('karyawan', 'karyawan.karyawan_id = absensi.karyawan_id', 'left');
        $this->db->where('tanggal >=', $start);
        $this->db->where('tanggal <=', $end);
        $this->db->order_by('tanggal', 'DESC');
        return $this->db->get()->result();
    }

    public function rekap_bulanan($karyawan_id, $bulan)
    {
        $this->db->select('status');
        $this->db->from('absensi');
        $this->db->where('karyawan_id', $karyawan_id);
        $this->db->like('tanggal', $bulan);
        $result = $this->db->get()->result();

        $rekap = (object) [
            'total_hadir' => 0,
            'total_izin' => 0,
            'total_telat' => 0,
            'total_sakit' => 0,
        ];

        foreach ($result as $row) {
            if ($row->status == 'hadir') $rekap->total_hadir++;
            elseif ($row->status == 'izin') $rekap->total_izin++;
            elseif ($row->status == 'sakit') $rekap->total_sakit++;
            elseif ($row->status == 'telat') $rekap->total_telat++;
        }
        return $rekap;
    }
    
    public function rekap_range($karyawan_id, $start, $end)
    {
        $this->db->where('karyawan_id', $karyawan_id);
        $this->db->where('tanggal >=', $start);
        $this->db->where('tanggal <=', $end);
        $query = $this->db->get('absensi')->result();

        $hasil = ['hadir' => 0, 'telat' => 0, 'izin' => 0, 'sakit' => 0];
        foreach ($query as $row) {
            if (isset($hasil[$row->status])) {
                $hasil[$row->status]++;
            }
        }
        return (object) $hasil;
    }

    public function get_summary($karyawan_id, $start_date, $end_date)
    {
        $this->db->select('
            SUM(CASE WHEN status = "hadir" THEN 1 ELSE 0 END) AS total_hadir,
            SUM(CASE WHEN status = "izin" THEN 1 ELSE 0 END) AS total_izin,
            SUM(CASE WHEN status = "sakit" THEN 1 ELSE 0 END) AS total_sakit,
            SUM(CASE WHEN status = "telat" THEN 1 ELSE 0 END) AS total_telat
        ');
        $this->db->where('karyawan_id', $karyawan_id);
        $this->db->where('tanggal >=', $start_date);
        $this->db->where('tanggal <=', $end_date);
        return $this->db->get('absensi')->row();
    }
}