<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cash_advance extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Cash_advance_model');
        $this->load->model('Karyawan_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    // Fungsi untuk menampilkan halaman utama (daftar CA)
    public function index()
    {
        $data['title'] = 'Data Cash Advance';

        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        // Jika tidak ada filter, set default bulan ini
        if (empty($start_date) && empty($end_date)) {
            $start_date = date('Y-m-01');
            $end_date = date('Y-m-t');
        }

        // Mengambil data ringkasan (summary)
        $data['summary'] = $this->Cash_advance_model->get_summary($start_date, $end_date);

        // Mengambil data rincian untuk tabel
        $data['cash_advance_list'] = $this->Cash_advance_model->get_all_detail($start_date, $end_date);
        
        $data['content'] = 'cash_advance/index';
        $this->load->view('layouts/main', $data);
    }

    // Fungsi untuk menampilkan form tambah CA
    public function tambah()
    {
        $data['title'] = 'Tambah Data Cash Advance';
        $data['karyawan'] = $this->Karyawan_model->get_all();
        $data['content'] = 'cash_advance/form';
        $data['action_url'] = site_url('cash_advance/simpan');
        $data['ca_data'] = null; // Data kosong untuk form tambah

        $this->load->view('layouts/main', $data);
    }

    // Fungsi untuk menyimpan data CA baru
    public function simpan()
    {
        $data = [
            'karyawan_id' => $this->input->post('karyawan_id'),
            'tanggal' => $this->input->post('tanggal'),
            'jumlah' => $this->input->post('jumlah'),
            'keterangan' => $this->input->post('keterangan'),
        ];
        $this->Cash_advance_model->insert($data);
        $this->session->set_flashdata('success', 'Data cash advance berhasil ditambahkan.');
        redirect('cash_advance');
    }
    
    // Anda bisa menambahkan fungsi edit dan hapus di sini nanti
}