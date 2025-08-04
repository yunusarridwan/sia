<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Pettycash extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Pettycash_model');
        $this->load->helper(['url', 'form']);
        $this->load->library('form_validation');
    }

    // TAMPILKAN REKAP
    public function index()
    {
        $data['title'] = 'Rekap Data Petty Cash';

        $tanggal_awal  = $this->input->get('tanggal_awal');
        $tanggal_akhir = $this->input->get('tanggal_akhir');

        if ($tanggal_awal && $tanggal_akhir) {
            $data['pettycash'] = $this->Pettycash_model->get_filtered($tanggal_awal, $tanggal_akhir);
        } else {
            $data['pettycash'] = $this->Pettycash_model->get_all();
        }

        $data['tanggal_awal']  = $tanggal_awal;
        $data['tanggal_akhir'] = $tanggal_akhir;

        $data['content'] = 'pettycash/index';
        $this->load->view('layouts/main', $data);
    }

    // FORM TAMBAH
    public function tambah()
    {
        $data['title'] = 'Tambah Data Petty Cash';
        $content = $this->load->view('pettycash/tambah', $data, true);
        $this->load->view('layouts/main', compact('content'));
    }

    // PROSES SIMPAN
    public function simpan()
    {
        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            $this->tambah();
        } else {
            $data = [
                'tanggal'    => $this->input->post('tanggal'),
                'kategori'   => $this->input->post('kategori'),
                'keterangan' => $this->input->post('keterangan'),
                'nominal'    => $this->input->post('nominal'),
            ];

            $this->Pettycash_model->insert($data);
            $this->session->set_flashdata('success', 'Data petty cash berhasil ditambahkan.');
            redirect('pettycash');
        }
    }

    // FORM EDIT
    public function edit($id)
    {
        $data['title'] = 'Edit Data Petty Cash';
        $data['pettycash'] = $this->Pettycash_model->get_by_id($id);

        $content = $this->load->view('pettycash/edit', $data, true);
        $this->load->view('layouts/main', compact('content'));
    }

    // PROSES UPDATE
    public function update()
    {
        $id = $this->input->post('id');

        $this->form_validation->set_rules('tanggal', 'Tanggal', 'required');
        $this->form_validation->set_rules('kategori', 'Kategori', 'required');
        $this->form_validation->set_rules('keterangan', 'Keterangan', 'required');
        $this->form_validation->set_rules('nominal', 'Nominal', 'required|numeric');

        if ($this->form_validation->run() === FALSE) {
            $this->edit($id);
        } else {
            $data = [
                'tanggal'    => $this->input->post('tanggal'),
                'kategori'   => $this->input->post('kategori'),
                'keterangan' => $this->input->post('keterangan'),
                'nominal'    => $this->input->post('nominal'),
            ];

            $this->Pettycash_model->update($id, $data);
            $this->session->set_flashdata('success', 'Data berhasil diperbarui.');
            redirect('pettycash');
        }
    }

    // HAPUS DATA
    public function hapus($id)
    {
        $this->Pettycash_model->delete($id);
        $this->session->set_flashdata('success', 'Data berhasil dihapus.');
        redirect('pettycash');
    }

    // CETAK PDF LAPORAN
    public function cetak()
    {
        $tanggal_awal  = $this->input->get('tanggal_awal') ?? date('Y-m-01');
        $tanggal_akhir = $this->input->get('tanggal_akhir') ?? date('Y-m-t');

        $kategori = ['air_galon', 'bensin', 'lainnya', 'bulanan'];
        $result = [];

        foreach ($kategori as $kat) {
            $result[$kat] = $this->Pettycash_model->get_by_kategori($kat, $tanggal_awal, $tanggal_akhir);
        }

        $data['title']  = 'Laporan Petty Cash';
        $data['start']  = $tanggal_awal;
        $data['end']    = $tanggal_akhir;
        $data['result'] = $result;

        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->filename = "laporan_pettycash.pdf";
        $this->pdf->load_view('pettycash/cetak_pdf', $data);
    }
}
