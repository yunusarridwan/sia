<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory; // <--- tambahkan ini di atas

class Absensi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Absensi_model');
        $this->load->library(['session']);
        $this->load->helper(['url', 'form']);
    }

    public function index()
{
    $data['title'] = 'Daftar Absensi';

    // Ambil input dari form filter (GET parameter)
    $start = $this->input->get('start_date');
    $end   = $this->input->get('end_date');

    // Jika filter aktif
    if ($start && $end) {
        $data['absensi'] = $this->Absensi_model->get_filtered($start, $end);
    } else {
        $data['absensi'] = $this->Absensi_model->get_all();
    }

    $data['content'] = 'absensi/index';
    $this->load->view('layouts/main', $data);
}




    public function upload()
    {
        $data['title'] = 'Import Absensi';
        $data['content'] = 'absensi/upload';
        $this->load->view('layouts/main', $data);
    }

    public function import()
    {
        $file = $_FILES['file_excel']['tmp_name'];

        if (!empty($file)) {
            // Gunakan PhpSpreadsheet untuk baca file
            $spreadsheet = IOFactory::load($file);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            $data = [];

            foreach ($sheetData as $i => $row) {
                if ($i == 0) continue; // Skip baris header

                $pegawai_id = isset($row[2]) ? trim($row[2]) : null;
                $tanggal_raw = isset($row[3]) ? trim($row[3]) : null;

                if ($pegawai_id && $tanggal_raw) {
                    $tanggal = date('Y-m-d', strtotime($tanggal_raw));
                    $jam_masuk = date('H:i:s', strtotime($tanggal_raw));

                    if (!$this->Absensi_model->is_exist($pegawai_id, $tanggal)) {
                        $data[] = [
                            'pegawai_id' => $pegawai_id,
                            'tanggal'    => $tanggal,
                            'jam_masuk'  => $jam_masuk,
                            'status'     => $jam_masuk > '09:15:00' ? 'telat' : 'hadir'
                        ];
                    }
                }
            }

            if (!empty($data)) {
                $this->Absensi_model->insert_batch($data);
                $this->session->set_flashdata('success', 'Data absensi berhasil diimpor.');
            } else {
                $this->session->set_flashdata('warning', 'Semua data sudah ada atau tidak valid.');
            }
        } else {
            $this->session->set_flashdata('warning', 'File tidak ditemukan.');
        }

        redirect('absensi/upload');
    }
}
