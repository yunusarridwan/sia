<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_laporan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Rekap_laporan_model');
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        $data['title'] = "Rekapan Arus Kas";
        $data['laporan'] = $this->Rekap_laporan_model->get_laporan();

        $data['content'] = 'rekap_laporan/index';
        $this->load->view('layouts/main', $data);

    }

    public function cetak()
    {
        $data['title'] = "Rekapan Arus Kas";
        $data['laporan'] = $this->Rekap_laporan_model->get_laporan();

        // Default periode: bulan berjalan
        $data['start_date'] = '01-07-2025';
        $data['end_date']   = date('d-m-Y');

        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->filename = "rekap_arus_kas.pdf";
        $this->pdf->load_view('rekap_laporan/cetak_pdf', $data);
    }
}
