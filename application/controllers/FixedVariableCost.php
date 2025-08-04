<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FixedVariableCost extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model(['FixedVariableCost_model', 'Pettycash_model']);
        $this->load->helper(['url', 'form']);
    }

    public function index()
    {
        $data['title'] = 'Laporan Fixed & Variable Cost';

        $start = $this->input->get('start_date');
        $end   = $this->input->get('end_date');

        $data['fc'] = $this->FixedVariableCost_model->get_by_kategori('Fixed', $start, $end);
        $data['vc'] = $this->FixedVariableCost_model->get_by_kategori('Variable', $start, $end);

        $kategori_vc = [
            'air_galon' => 'Air Galon',
            'bensin'    => 'Bensin Operasional',
            'lainnya'   => 'Pengeluaran Lain'
        ];

        $data['pc_vc'] = [];
        foreach ($kategori_vc as $kat => $label) {
            $nom = $this->Pettycash_model->total_per_kategori($kat, $start, $end);
            if ($nom > 0) {
                $tanggal = $this->Pettycash_model->get_last_date_by_kategori($kat, $start, $end);
                $data['pc_vc'][] = [
                    'kategori' => $label,
                    'nominal'  => $nom,
                    'tanggal'  => $tanggal
                ];
            }
        }

        $keterangan_fc = ['Token Listrik', 'IPKL Ruko', 'Wifi Indihome', 'PAM'];
        $data['pc_fc'] = [];
        foreach ($keterangan_fc as $ket) {
            $nom = $this->Pettycash_model->total_per_keterangan($ket, $start, $end);
            if ($nom > 0) {
                $tanggal = $this->Pettycash_model->get_last_date_by_keterangan($ket, $start, $end);
                $data['pc_fc'][] = [
                    'kategori' => $ket,
                    'nominal'  => $nom,
                    'tanggal'  => $tanggal
                ];
            }
        }

        $data['start'] = $start;
        $data['end']   = $end;

        // render view dalam variabel content
        $data['content'] = 'fv/index';
        $this->load->view('layouts/main', $data);

    }

    public function tambah()
    {
        $data['title'] = 'Tambah Biaya';
        $content = $this->load->view('fv/tambah', $data, true);
        $this->load->view('layouts/main', compact('content'));
    }

    public function simpan()
    {
        $data = [
            'bulan'        => $this->input->post('bulan'),
            'tanggal'      => $this->input->post('tanggal'),
            'kategori'     => $this->input->post('kategori'),
            'keterangan'   => $this->input->post('keterangan'),
            'nominal'      => $this->input->post('nominal'),
            'source'       => 'manual',
            'id_pettycash' => null
        ];

        $this->FixedVariableCost_model->insert($data);
        redirect('FixedVariableCost');
    }

    public function edit($id)
    {
        $data['title'] = 'Edit Biaya';
        $data['biaya'] = $this->FixedVariableCost_model->get_by_id($id);
        $content = $this->load->view('fv/edit', $data, true);
        $this->load->view('layouts/main', compact('content'));
    }

    public function update()
    {
        $id = $this->input->post('id');
        $data = [
            'bulan'      => $this->input->post('bulan'),
            'tanggal'    => $this->input->post('tanggal'),
            'kategori'   => $this->input->post('kategori'),
            'keterangan' => $this->input->post('keterangan'),
            'nominal'    => $this->input->post('nominal'),
        ];

        $this->FixedVariableCost_model->update($id, $data);
        redirect('FixedVariableCost');
    }

    public function hapus($id)
    {
        $this->FixedVariableCost_model->delete($id);
        redirect('FixedVariableCost');
    }

    public function cetak()
    {
        $start_date = $this->input->get('start_date') ?? date('Y-m-01');
        $end_date   = $this->input->get('end_date') ?? date('Y-m-t');

        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;

        $data['fixed']          = $this->FixedVariableCost_model->get_by_kategori('Fixed', $start_date, $end_date);
        $data['variable']       = $this->FixedVariableCost_model->get_by_kategori('Variable', $start_date, $end_date);
        $data['total_fixed']    = $this->FixedVariableCost_model->total_kategori('Fixed', $start_date, $end_date);
        $data['total_variable'] = $this->FixedVariableCost_model->total_kategori('Variable', $start_date, $end_date);
        $data['total_semua']    = $this->FixedVariableCost_model->total_semua($start_date, $end_date);

        $kategori_vc = [
            'air_galon' => 'Air Galon',
            'bensin'    => 'Bensin Operasional',
            'lainnya'   => 'Pengeluaran Lain'
        ];

        $data['pc_vc'] = [];
        foreach ($kategori_vc as $kat => $label) {
            $nom = $this->Pettycash_model->total_per_kategori($kat, $start_date, $end_date);
            if ($nom > 0) {
                $tanggal = $this->Pettycash_model->get_last_date_by_kategori($kat, $start_date, $end_date);
                $data['pc_vc'][] = [
                    'kategori' => $label,
                    'nominal'  => $nom,
                    'tanggal'  => $tanggal
                ];
            }
        }

        $keterangan_fc = ['Token Listrik', 'IPKL Ruko', 'Wifi Indihome', 'PAM'];
        $data['pc_fc'] = [];
        foreach ($keterangan_fc as $ket) {
            $nom = $this->Pettycash_model->total_per_keterangan($ket, $start_date, $end_date);
            if ($nom > 0) {
                $tanggal = $this->Pettycash_model->get_last_date_by_keterangan($ket, $start_date, $end_date);
                $data['pc_fc'][] = [
                    'kategori' => $ket,
                    'nominal'  => $nom,
                    'tanggal'  => $tanggal
                ];
            }
        }

        $this->load->library('pdf');
        $this->pdf->setPaper('A4', 'portrait');
        $this->pdf->filename = "laporan_fixed_variable_cost.pdf";
        $this->pdf->load_view('fv/cetak_pdf', $data);
    }
}
