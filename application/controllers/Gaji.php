<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property CI_Input $input
 * @property Gaji_model $Gaji_model
 * @property Karyawan_model $Karyawan_model
 * @property Absensi_model $Absensi_model
 * @property Lembur_model $Lembur_model
 * @property CI_Session $session
 * @property CI_DB_query_builder $db
 */
class Gaji extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gaji_model');
        $this->load->model('Karyawan_model');
        $this->load->model('Absensi_model');
        $this->load->model('Lembur_model');
        $this->load->library('session');
        $this->load->database();
    }

    public function index()
    {
        $data['title'] = 'Rekap Gaji';
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        $data['gaji'] = $this->Gaji_model->get_all($start_date, $end_date);
        $data['content'] = 'gaji/index';
        $this->load->view('layouts/main', $data);
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Gaji Karyawan';
        $gaji_record = $this->Gaji_model->get_by_id($id);

        if (!$gaji_record) {
            show_404();
        }

        $bulan_rekap = $gaji_record->bulan;
        $karyawan_id = $gaji_record->karyawan_id;
        $start_date = date('Y-m-01', strtotime($bulan_rekap));
        $end_date = date('Y-m-t', strtotime($bulan_rekap));

        $absen_summary = $this->Absensi_model->get_summary($karyawan_id, $start_date, $end_date);
        
        $data['gaji'] = $gaji_record;
        $data['absen'] = $absen_summary;

        $data['content'] = 'gaji/edit';
        $this->load->view('layouts/main', $data);
    }

    public function update()
    {
        $id = $this->input->post('id');
        $gaji_record = $this->Gaji_model->get_by_id($id);

        if (!$gaji_record) {
            $this->session->set_flashdata('error', 'Data gaji tidak ditemukan.');
            redirect('gaji');
        }

        $insentif = str_replace('.', '', $this->input->post('insentif'));
        $total_tambahan = str_replace('.', '', $this->input->post('total_tambahan'));
        $total_potongan = str_replace('.', '', $this->input->post('total_potongan'));
        $gaji_pokok = $gaji_record->gaji_pokok;

        $total_gaji = $gaji_pokok + $total_tambahan + $insentif - $total_potongan;

        $data = [
            'insentif' => $insentif,
            'total_tambahan' => $total_tambahan,
            'total_potongan' => $total_potongan,
            'total_gaji' => $total_gaji
        ];

        $this->Gaji_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data gaji berhasil diperbarui.');
        redirect('gaji');
    }

    public function rekap_otomatis($tahun = null, $bulan = null)
    {
        $tahun = $tahun ?? date('Y');
        $bulan = $bulan ?? date('m');
        
        $start_date = $tahun . '-' . $bulan . '-01';
        $end_date = date('Y-m-t', strtotime($start_date));
        $bulan_rekap = date('Y-m', strtotime($end_date));

        $users = $this->Karyawan_model->get_all();

        foreach ($users as $user) {
            $karyawan_id = $user->id;
            $nama = $user->nama;
            $jabatan = $user->jabatan;

            $absen = $this->Absensi_model->get_summary($karyawan_id, $start_date, $end_date);
            $izin  = isset($absen->total_izin) ? $absen->total_izin : 0;
            $sakit = isset($absen->total_sakit) ? $absen->total_sakit : 0;
            $telat = isset($absen->total_telat) ? $absen->total_telat : 0;

            $lembur = $this->Lembur_model->get_total_tambahan($karyawan_id, $start_date, $end_date);
            $total_tambahan = isset($lembur) ? $lembur : 0;

            $potongan_absen = ($telat * 50000) + ($izin * 100000);
            $insentif = 0;
            $gaji_pokok = $user->gaji_pokok;
            $total_potongan = $potongan_absen;
            $total_gaji = $gaji_pokok + $insentif + $total_tambahan - $total_potongan;

            $existing_gaji = $this->Gaji_model->check_existing($karyawan_id, $bulan_rekap);
            if ($existing_gaji) {
                 $this->Gaji_model->update($existing_gaji->id, [
                    'nama' => $nama,
                    'jabatan' => $jabatan,
                    'total_izin' => $izin,
                    'sakit' => $sakit,
                    'total_telat' => $telat,
                    'insentif' => $insentif,
                    'total_tambahan' => $total_tambahan,
                    'potongan_absen' => $potongan_absen,
                    'total_potongan' => $total_potongan,
                    'gaji_pokok' => $gaji_pokok,
                    'total_gaji' => $total_gaji,
                ]);
            } else {
                 $this->Gaji_model->simpan([
                    'karyawan_id' => $karyawan_id,
                    'nama' => $nama,
                    'jabatan' => $jabatan,
                    'bulan' => $bulan_rekap,
                    'total_izin' => $izin,
                    'sakit' => $sakit,
                    'total_telat' => $telat,
                    'insentif' => $insentif,
                    'total_tambahan' => $total_tambahan,
                    'potongan_absen' => $potongan_absen,
                    'total_potongan' => $total_potongan,
                    'gaji_pokok' => $gaji_pokok,
                    'total_gaji' => $total_gaji,
                    'tanggal_dibuat' => date('Y-m-d H:i:s'),
                ]);
            }
        }

        $this->session->set_flashdata('success', 'Rekap gaji otomatis berhasil.');
        redirect('gaji');
    }
}