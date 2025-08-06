<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\IOFactory;

/**
 * @property Absensi_model $Absensi_model
 * @property CI_Session $session
 * @property CI_Input $input
 * @property CI_DB_query_builder $db
 */
class Absensi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Absensi_model');
        $this->load->library(['session']);
        $this->load->helper(['url', 'form']);
        $this->load->database();
    }

    public function index()
    {
        $data['title'] = 'Daftar Absensi';

        $start = $this->input->get('start_date');
        $end   = $this->input->get('end_date');

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
            $spreadsheet = IOFactory::load($file);
            $sheetData = $spreadsheet->getActiveSheet()->toArray();

            $data = [];
            foreach ($sheetData as $i => $row) {
                if ($i == 0) continue;

                $karyawan_id = isset($row[2]) ? trim($row[2]) : null;
                $tanggal_raw = isset($row[3]) ? trim($row[3]) : null;

                if ($karyawan_id && $tanggal_raw) {
                    $tanggal = date('Y-m-d', strtotime($tanggal_raw));
                    $jam_masuk = date('H:i:s', strtotime($tanggal_raw));

                    if (!$this->Absensi_model->is_exist($karyawan_id, $tanggal)) {
                        $data[] = [
                            'karyawan_id' => $karyawan_id,
                            'tanggal' => $tanggal,
                            'jam_masuk' => $jam_masuk,
                            'status' => $jam_masuk > '09:15:00' ? 'telat' : 'hadir'
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