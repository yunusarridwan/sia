<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gaji extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gaji_model');
        $this->load->model('Karyawan_model');
        $this->load->model('Absensi_model');
        $this->load->model('Lembur_model');
    }

    public function index()
    {
        $data['title'] = 'Rekap Gaji';
        $data['gaji'] = $this->Gaji_model->get_all();
        $data['content'] = 'gaji/index';
        $this->load->view('layouts/main', $data);
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Gaji Karyawan';
        $data['gaji'] = $this->Gaji_model->get_by_id($id);

        if (!$data['gaji']) {
            show_404(); // Data tidak ditemukan
        }

        $data['content'] = 'gaji/edit';
        $this->load->view('layouts/main', $data);
    }

    public function update()
    {
        $id = $this->input->post('id');
        $insentif = str_replace('.', '', $this->input->post('insentif'));
        $total_tambahan = str_replace('.', '', $this->input->post('total_tambahan'));
        $gaji_pokok = str_replace('.', '', $this->input->post('gaji_pokok'));
        $total_potongan = str_replace('.', '', $this->input->post('total_potongan'));

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

    public function rekap_otomatis()
    {
        $start_date = $this->input->get('start_date') ?? date('Y-m-01');
        $end_date = $this->input->get('end_date') ?? date('Y-m-t');

        $users = $this->Karyawan_model->get_all();

        foreach ($users as $user) {
            $karyawan_id = $user->id;
            $nama = $user->nama;
            $jabatan = $user->jabatan;
            $gaji_pokok = $user->gaji_pokok; // Atau gaji_pokok, basic_allowance, sesuai nama field di tabel karyawan kamu


            // Ambil data absensi
            $absen = $this->Absensi_model->get_summary($karyawan_id, $start_date, $end_date);
            $izin  = isset($absen->total_izin) ? $absen->total_izin : 0;
            $sakit = isset($absen->total_sakit) ? $absen->total_sakit : 0;
            $telat = isset($absen->total_telat) ? $absen->total_telat : 0;

            // Ambil data lembur
            $lembur = $this->Lembur_model->get_total_tambahan($karyawan_id, $start_date, $end_date);
            $total_tambahan = isset($lembur->total_tambahan) ? $lembur->total_tambahan : 0;

            // Hitung potongan
            $potongan_absen = ($telat * 50000) + ($izin * 100000);

            // Nilai default insentif
            $insentif = 0;

            $total_potongan = $potongan_absen;
            $total_gaji = $gaji_pokok + $insentif + $total_tambahan - $total_potongan;

            // Simpan ke database gaji
            $this->Gaji_model->simpan([
                'karyawan_id' => $karyawan_id,
                'nama' => $nama,
                'jabatan' => $jabatan,
                'bulan' => date('Y-m', strtotime($end_date)),
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

        $this->session->set_flashdata('success', 'Rekap gaji otomatis berhasil.');
        redirect('gaji');
    }
}
