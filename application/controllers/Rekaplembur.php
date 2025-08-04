<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekaplembur extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model(['Lembur_model', 'Karyawan_model']);
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }

    // Tampilkan semua karyawan
    public function index() {
        $data['title'] = 'Daftar Karyawan Lembur';
        $data['karyawan'] = $this->Karyawan_model->get_all();
        $data['content'] = 'lembur/index';
        $this->load->view('layouts/main', $data);
    }

    // Tampilkan detail lembur untuk 1 karyawan
    public function detail($id) {
        $karyawan = $this->Karyawan_model->get_by_id($id);
        if (!$karyawan) {
            show_404();
        }

        $data['title']    = 'Detail Lembur Karyawan';
        $data['karyawan'] = $karyawan;
        $data['lembur']   = $this->Lembur_model->get_by_karyawan($id);
        $data['content']  = 'lembur/detail';
        $this->load->view('layouts/main', $data);
    }

    // Form tambah lembur
    public function tambah($karyawan_id) {
        $karyawan = $this->Karyawan_model->get_by_id($karyawan_id);
        if (!$karyawan) {
            show_error("Error! Data pegawai tidak ditemukan.");
        }

        $data['title']    = 'Tambah Data Lembur';
        $data['karyawan'] = $karyawan;
        $data['content']  = 'lembur/form';
        $this->load->view('layouts/main', $data);
    }

    // Simpan lembur baru
    public function simpan() {
        $this->form_validation->set_rules('karyawan_id', 'Karyawan', 'required');
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('jam_mulai', 'Jam Mulai', 'required');
        $this->form_validation->set_rules('jam_selesai', 'Jam Selesai', 'required');

        if ($this->form_validation->run() === FALSE) {
            $this->tambah($this->input->post('karyawan_id'));
        } else {
            $data = [
                'karyawan_id'  => $this->input->post('karyawan_id'),
                'tanggal'      => $this->input->post('tanggal'),
                'jam_mulai'    => $this->input->post('jam_mulai'),
                'jam_selesai'  => $this->input->post('jam_selesai'),
                'tujuan'       => $this->input->post('tujuan'),
                'uang_makan'   => $this->input->post('uang_makan')
            ];

            $this->Lembur_model->insert($data);
            $this->session->set_flashdata('success', 'Data lembur berhasil ditambahkan.');
            redirect('rekaplembur/detail/' . $data['karyawan_id']);
        }
    }

    // Form edit
    public function edit($id) {
        $data['lembur']   = $this->Lembur_model->get_by_id($id);
        $data['karyawan'] = $this->Karyawan_model->get_by_id($data['lembur']->karyawan_id);
        $data['title']    = 'Edit Data Lembur';
        $data['content']  = 'lembur/form';
        $this->load->view('layouts/main', $data);
    }

    // Update lembur
    public function update() {
        $id = $this->input->post('id');
        $data = [
            'tanggal'     => $this->input->post('tanggal'),
            'jam_mulai'   => $this->input->post('jam_mulai'),
            'jam_selesai' => $this->input->post('jam_selesai'),
            'tujuan'      => $this->input->post('tujuan'),
            'uang_makan'  => $this->input->post('uang_makan')
        ];

        $this->Lembur_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data lembur berhasil diperbarui.');
        redirect('rekaplembur/detail/' . $this->input->post('karyawan_id'));
    }

    // Hapus
    public function hapus($id) {
        $karyawan_id = $this->Lembur_model->get_by_id($id)->karyawan_id;
        $this->Lembur_model->delete($id);
        $this->session->set_flashdata('success', 'Data lembur berhasil dihapus.');
        redirect('rekaplembur/detail/' . $karyawan_id);
    }

    // Cetak PDF
    public function cetak($id) {
        $data['karyawan'] = $this->Karyawan_model->get_by_id($id);
        $data['lembur'] = $this->Lembur_model->get_by_karyawan($id);
        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->filename = 'rekap_lembur_' . $data['karyawan']->nama . '.pdf';
        $this->pdf->load_view('lembur/cetak', $data);
    }
}
