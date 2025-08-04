<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mutasi_kantor extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Mutasi_kantor_model');
    }

    public function index()
    {
        $data['title'] = "Laporan Mutasi Uang dari Pusat";
        $data['mutasi'] = $this->Mutasi_kantor_model->get_all();

        $data['content'] = 'mutasi_kantor/index';
        $this->load->view('layouts/main', $data);

    }

    public function tambah()
    {
        $data['title'] = "Tambah Mutasi";

        $content = $this->load->view('mutasi_kantor/tambah', $data, true);
        $this->load->view('layouts/main', compact('content'));
    }

    public function simpan()
    {
        $data = [
            'tanggal' => $this->input->post('tanggal'),
            'jenis_pemasukan' => 'Masuk',
            'nominal' => $this->input->post('nominal'),
            'keterangan' => $this->input->post('keterangan')
        ];

        $this->Mutasi_kantor_model->insert($data);
        redirect('mutasi_kantor');
    }

    public function edit($id)
    {
        $data['title'] = "Edit Mutasi";
        $data['mutasi'] = $this->Mutasi_kantor_model->get_by_id($id);

        $content = $this->load->view('mutasi_kantor/edit', $data, true);
        $this->load->view('layouts/main', compact('content'));
    }

    public function update($id)
    {
        $data = [
            'tanggal' => $this->input->post('tanggal'),
            'jenis_pemasukan' => 'Masuk',
            'nominal' => $this->input->post('nominal'),
            'keterangan' => $this->input->post('keterangan')
        ];

        $this->Mutasi_kantor_model->update($id, $data);
        redirect('mutasi_kantor');
    }

    public function hapus($id)
    {
        $this->Mutasi_kantor_model->delete($id);
        redirect('mutasi_kantor');
    }
}
