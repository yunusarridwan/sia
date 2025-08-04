<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Karyawan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('Karyawan_model', 'karyawan');
        $this->load->library(['form_validation', 'session']);
    }

    public function index() {
        $data['title'] = 'Data Karyawan';
        $data['rows'] = $this->karyawan->get_all();
        $data['content'] = 'karyawan/index';
        $this->load->view('layouts/main', $data);
    }

    public function create() {
        $data['title'] = 'Tambah Karyawan';
        $data['content'] = 'karyawan/form';
        $this->load->view('layouts/main', $data);
    }

    public function store() {
    $this->_rules();

    if ($this->form_validation->run() === FALSE) {
        $this->create();
    } else {
        $data = [
            'karyawan_id' => $this->input->post('karyawan_id'),
            'nama' => $this->input->post('nama'),
            'jabatan' => $this->input->post('jabatan'),
            'gaji_pokok' => $this->input->post('gaji_pokok'),
            'no_rekening' => $this->input->post('no_rekening'),
            'status' => $this->input->post('status'),
            'tgl_masuk' => $this->input->post('tgl_masuk'),
            'tgl_resign' => $this->input->post('tgl_resign')
        ];

        $this->karyawan->insert($data);
        $this->session->set_flashdata('success', 'Data berhasil ditambahkan.');
        redirect('karyawan');
    }
}


    public function edit($id) {
        $data['title'] = 'Edit Karyawan';
        $data['row'] = $this->karyawan->get_by_id($id);

        if (!$data['row']) show_404();

        $data['content'] = 'karyawan/form';
        $this->load->view('layouts/main', $data);
    }

    public function update($id) {
    $this->_rules();

    if ($this->form_validation->run() === FALSE) {
        $this->edit($id);
    } else {
        $data = [
            'karyawan_id' => $this->input->post('karyawan_id'),
            'nama' => $this->input->post('nama'),
            'jabatan' => $this->input->post('jabatan'),
            'gaji_pokok' => $this->input->post('gaji_pokok'),
            'no_rekening' => $this->input->post('no_rekening'),
            'status' => $this->input->post('status'),
            'tgl_masuk' => $this->input->post('tgl_masuk'),
            'tgl_resign' => $this->input->post('tgl_resign')
        ];

        $this->karyawan->update($id, $data);
        $this->session->set_flashdata('success', 'Data berhasil diubah.');
        redirect('karyawan');
    }
}


    public function delete($id) {
        $this->karyawan->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('karyawan');
    }

    private function _rules() {
        $this->form_validation->set_rules('karyawan_id', 'ID Fingerprint', 'required|numeric');
        $this->form_validation->set_rules('nama', 'Nama', 'required');
        $this->form_validation->set_rules('jabatan', 'Jabatan', 'required');
        $this->form_validation->set_rules('gaji_pokok', 'Gaji Pokok', 'required|numeric');
        $this->form_validation->set_rules('status', 'Status', 'required');
    }
}
