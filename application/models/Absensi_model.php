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
    
    
    // Memasukkan banyak data sekaligus ke tabel absensi
    public function insert_batch($data)
    {
        return $this->db->insert_batch($this->table, $data);
    }
    
    // Mengecek apakah data absensi untuk karyawan dan tanggal tertentu sudah ada
    public function is_exist($karyawan_id, $tanggal)
    {
        return $this->db
            ->where('karyawan_id', $karyawan_id)
            ->where('tanggal', $tanggal)
            ->get($this->table)
            ->num_rows() > 0;
    }

    // Mengambil semua data absensi dengan join ke tabel karyawan
    public function get_all()
    {
        return $this->db->select('absensi.*, karyawan.nama')
                        ->from('absensi')
                        // Perbaikan: Gunakan 'karyawan.id' di sini untuk JOIN
                        ->join('karyawan', 'absensi.karyawan_id = karyawan.id', 'left')
                        ->order_by('tanggal', 'DESC')
                        ->get()
                        ->result();
    }
    
    // Mengambil data absensi dengan filter tanggal
    public function get_filtered($start, $end)
    {
        return $this->db->select('absensi.*, karyawan.nama')
                        ->from('absensi')
                        // Perbaikan: Gunakan 'karyawan.id' di sini untuk JOIN
                        ->join('karyawan', 'absensi.karyawan_id = karyawan.id', 'left')
                        ->where('tanggal >=', $start)
                        ->where('tanggal <=', $end)
                        ->order_by('tanggal', 'DESC')
                        ->get()
                        ->result();
    }

    // Menghitung rekap absensi bulanan
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
        $sakit = 0;

        foreach ($result as $row) {
            if ($row->status == 'hadir') {
                $hadir++;
            } elseif ($row->status == 'izin') {
                $izin++;
            } elseif ($row->status == 'sakit') {
                $sakit++;
            } elseif ($row->status == 'telat') {
                $telat++;
            }
        }

        return (object) [
            'total_hadir' => $hadir,
            'total_izin' => $izin,
            'total_telat' => $telat,
            'total_sakit' => $sakit,
        ];
    }
    
    // Menghitung rekap absensi berdasarkan rentang tanggal
    public function rekap_range($karyawan_id, $start, $end)
    {
        $this->db->where('karyawan_id', $karyawan_id);
        $this->db->where('tanggal >=', $start);
        $this->db->where('tanggal <=', $end);
        $query = $this->db->get('absensi')->result();

        $hasil = ['hadir' => 0, 'telat' => 0, 'izin' => 0, 'sakit' => 0];
        foreach ($query as $row) {
            if ($row->status == 'hadir') $hasil['hadir']++;
            elseif ($row->status == 'telat') $hasil['telat']++;
            elseif ($row->status == 'izin') $hasil['izin']++;
            elseif ($row->status == 'sakit') $hasil['sakit']++;
        }

        return (object) $hasil;
    }

    // Mengambil ringkasan data absensi (izin, sakit, telat)
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