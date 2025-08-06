<?php
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

defined('BASEPATH') OR exit('No direct script access allowed');

class Komisi extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Komisi_model');
        $this->load->model('Cash_advance_model');
        $this->load->model('Karyawan_model');
        $this->load->library('session');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['title'] = 'Rekap Komisi & Cash Advance';

        // 1. Ambil input bulan dari URL, jika tidak ada, gunakan bulan saat ini
        $bulan_dipilih = $this->input->get('bulan') ?? date('Y-m');

        // 2. Tentukan tanggal awal dan akhir dari bulan yang dipilih
        $start_date = date('Y-m-01', strtotime($bulan_dipilih));
        $end_date = date('Y-m-t', strtotime($bulan_dipilih));

        // 3. Buat judul periode untuk ditampilkan di view
        $data['judul_periode'] = date('F Y', strtotime($bulan_dipilih));

        // 4. Kirim tanggal ke view untuk digunakan di link "Detail"
        $data['start_date_for_link'] = $start_date;
        $data['end_date_for_link'] = $end_date;

        // Mengambil total komisi kantor secara terpisah
        $data['total_komisi_office'] = $this->Komisi_model->get_total_office_commission($start_date, $end_date);
        
        // Proses pengambilan data rekap karyawan
        $rekap_komisi = $this->Komisi_model->get_rekap($start_date, $end_date);
        $rekap_ca = $this->Cash_advance_model->get_total_ca_per_karyawan($start_date, $end_date);

        foreach ($rekap_komisi as $key => $row) {
            $karyawan_id = $row['karyawan_id'];
            $cash_advance = $rekap_ca[$karyawan_id] ?? 0;
            
            $rekap_komisi[$key]['cash_advance'] = $cash_advance;
            
            $total_pemasukan = $row['komisi_mini'] + $row['komisi_reguler'] + $row['total_or'];

            $rekap_komisi[$key]['total_komisi'] = $total_pemasukan;
            $rekap_komisi[$key]['total_payout'] = $total_pemasukan - $cash_advance;
        }
        
        $data['rekap'] = $rekap_komisi;
        $data['content'] = 'komisi/index';
        $this->load->view('layouts/main', $data);
    }

    // Fungsi untuk menampilkan halaman detail
    public function detail($karyawan_id = null)
    {
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');

        // Validasi: pastikan semua parameter ada
        if(!$karyawan_id || !$start_date || !$end_date){
            $this->session->set_flashdata('error', 'Link tidak valid.');
            redirect('komisi');
        }

        $data['karyawan'] = $this->db->get_where('karyawan', ['karyawan_id' => $karyawan_id])->row();
        
        if(!$data['karyawan']){
            show_404();
        }
        
        // Membuat judul periode yang rapi
        $bulan_awal = date('F Y', strtotime($start_date));
        $bulan_akhir = date('F Y', strtotime($end_date));
        
        // Cek jika rentang waktunya sangat jauh (default), tampilkan "Semua Periode"
        if ($start_date == '2000-01-01') {
            $periode_judul = 'Semua Periode';
        } elseif ($bulan_awal == $bulan_akhir) {
            $periode_judul = $bulan_awal;
        } else {
            $periode_judul = date('M Y', strtotime($start_date)) . ' - ' . date('M Y', strtotime($end_date));
        }
        
        $data['title'] = 'Detail Komisi: ' . $data['karyawan']->nama;
        $data['periode'] = $periode_judul;

        $data['komisi'] = $this->Komisi_model->get_detail($karyawan_id, $start_date, $end_date);
        $data['cash_advance'] = $this->Cash_advance_model->get_detail($karyawan_id, $start_date, $end_date);
        $data['start_date'] = $start_date;
        $data['end_date'] = $end_date;

        $data['content'] = 'komisi/detail';
        $this->load->view('layouts/main', $data);
    }

    public function tambah_komisi()
    {
        $data['title'] = 'Tambah Data Komisi';
        
        // Memanggil model untuk mengambil daftar karyawan
        $data['karyawan'] = $this->Karyawan_model->get_all();
        
        // Menentukan file view mana yang akan dimuat
        $data['content'] = 'komisi/form_komisi';
        
        // Memuat template utama dan memasukkan konten form ke dalamnya
        $this->load->view('layouts/main', $data);
    }

    public function tambah_ca()
    {
        $data['title'] = 'Tambah Data Cash Advance';
        $data['karyawan'] = $this->Karyawan_model->get_all();
        $data['content'] = 'komisi/form_ca';
        $this->load->view('layouts/main', $data);
    }

    public function simpan_ca()
    {
        $data = [
            'karyawan_id' => $this->input->post('karyawan_id'),
            'tanggal' => $this->input->post('tanggal'),
            'jumlah' => $this->input->post('jumlah'),
            'keterangan' => $this->input->post('keterangan'),
        ];
        $this->Cash_advance_model->insert($data);
        $this->session->set_flashdata('success', 'Data cash advance berhasil ditambahkan.');
        redirect('komisi');
    }

    public function export_excel()
    {
        // 1. Ambil data (sama seperti sebelumnya)
        $bulan_dipilih = $this->input->get('bulan') ?? date('Y-m');
        $start_date = date('Y-m-01', strtotime($bulan_dipilih));
        $end_date = date('Y-m-t', strtotime($bulan_dipilih));
        $judul_periode = date('F Y', strtotime($bulan_dipilih));

        $rekap_komisi_total = $this->Komisi_model->get_rekap($start_date, $end_date);
        $rekap_ca_total = $this->Cash_advance_model->get_total_ca_per_karyawan($start_date, $end_date);
        $total_komisi_office = $this->Komisi_model->get_total_office_commission($start_date, $end_date);
        
        // Data baru untuk rincian
        $detail_komisi = $this->Komisi_model->get_all_detail($start_date, $end_date);
        $detail_ca = $this->Cash_advance_model->get_all_detail($start_date, $end_date);

        // 2. Buat objek Spreadsheet
        $spreadsheet = new Spreadsheet();

        // =================================================================
        // SHEET 1: REKAP TOTAL
        // =================================================================
        $sheet = $spreadsheet->getActiveSheet();
        $sheet->setTitle('Rekap Total');
        
        // ... (Kode untuk mengisi sheet rekap total tetap sama seperti sebelumnya) ...
        // Anda bisa copy-paste dari fungsi export_excel sebelumnya, dari baris:
        // $sheet->mergeCells('A1:H1'); sampai $sheet->getColumnDimension($columnID)->setAutoSize(true);
        // Atau saya sertakan versi lengkapnya di bawah.

        // Isi Judul dan Header Rekap Total
        $sheet->mergeCells('A1:H1')->setCellValue('A1', 'Rekap Total Komisi')->getStyle('A1')->getFont()->setBold(true)->setSize(16);
        $sheet->mergeCells('A2:H2')->setCellValue('A2', 'Periode: ' . $judul_periode);
        $sheet->getStyle('A1:A2')->getAlignment()->setHorizontal('center');
        
        $sheet->fromArray(['Nama', 'Komisi Mini', 'Komisi Reguler', 'Total OR', 'Total Komisi', 'Cash Advance', 'Total Payout'], NULL, 'A4');
        $sheet->getStyle('A4:G4')->getFont()->setBold(true);

        // Isi Data Rekap Total
        $row_number = 5;
        foreach ($rekap_komisi_total as $row) {
            $cash_advance = $rekap_ca_total[$row['karyawan_id']] ?? 0;
            $total_pemasukan = $row['komisi_mini'] + $row['komisi_reguler'] + $row['total_or'];
            $total_payout = $total_pemasukan - $cash_advance;

            $sheet->setCellValue('A' . $row_number, $row['nama']);
            $sheet->setCellValue('B' . $row_number, $row['komisi_mini']);
            $sheet->setCellValue('C' . $row_number, $row['komisi_reguler']);
            $sheet->setCellValue('D' . $row_number, $row['total_or']);
            $sheet->setCellValue('E' . $row_number, $total_pemasukan);
            $sheet->setCellValue('F' . $row_number, $cash_advance);
            $sheet->setCellValue('G' . $row_number, $total_payout);
            $row_number++;
        }
        $sheet->getStyle('B5:G' . ($row_number - 1))->getNumberFormat()->setFormatCode('#,##0');


        // =================================================================
        // SHEET 2: RINCIAN KOMISI
        // =================================================================
        $sheet2 = $spreadsheet->createSheet();
        $sheet2->setTitle('Rincian Komisi');
        
        // Isi Header Rincian Komisi
        $sheet2->fromArray(['Tanggal', 'Nama Karyawan', 'Jenis', 'Tipe', 'LOT', 'Rp/LOT', 'Total'], NULL, 'A1');
        $sheet2->getStyle('A1:G1')->getFont()->setBold(true);

        // Isi Data Rincian Komisi
        $row_number = 2;
        foreach($detail_komisi as $dk){
            $sheet2->setCellValue('A' . $row_number, date('d-m-Y', strtotime($dk['tanggal'])));
            $sheet2->setCellValue('B' . $row_number, $dk['nama_karyawan']);
            $sheet2->setCellValue('C' . $row_number, $dk['jenis']);
            $sheet2->setCellValue('D' . $row_number, $dk['tipe']);
            $sheet2->setCellValue('E' . $row_number, $dk['lot']);
            $sheet2->setCellValue('F' . $row_number, $dk['rupiah_per_lot']);
            $sheet2->setCellValue('G' . $row_number, $dk['total_amount']);
            $row_number++;
        }
        $sheet2->getStyle('F2:G' . ($row_number - 1))->getNumberFormat()->setFormatCode('#,##0');

        // =================================================================
        // SHEET 3: RINCIAN CASH ADVANCE
        // =================================================================
        $sheet3 = $spreadsheet->createSheet();
        $sheet3->setTitle('Rincian Cash Advance');

        // Isi Header Rincian CA
        $sheet3->fromArray(['Tanggal', 'Nama Karyawan', 'Jumlah', 'Keterangan'], NULL, 'A1');
        $sheet3->getStyle('A1:D1')->getFont()->setBold(true);

        // Isi Data Rincian CA
        $row_number = 2;
        foreach($detail_ca as $dca){
            $sheet3->setCellValue('A' . $row_number, date('d-m-Y', strtotime($dca->tanggal)));
            $sheet3->setCellValue('B' . $row_number, $dca->nama_karyawan);
            $sheet3->setCellValue('C' . $row_number, $dca->jumlah);
            $sheet3->setCellValue('D' . $row_number, $dca->keterangan);
            $row_number++;
        }
        $sheet3->getStyle('C2:C' . ($row_number - 1))->getNumberFormat()->setFormatCode('#,##0');


        // Atur lebar kolom otomatis untuk semua sheet
        foreach ($spreadsheet->getAllSheets() as $worksheet) {
            foreach (range('A', $worksheet->getHighestColumn()) as $columnID) {
                $worksheet->getColumnDimension($columnID)->setAutoSize(true);
            }
        }
        
        // Set sheet pertama yang aktif saat file dibuka
        $spreadsheet->setActiveSheetIndex(0);

        // Siapkan file untuk di-download
        $writer = new Xlsx($spreadsheet);
        $filename = 'rekap-komisi-lengkap-' . strtolower($judul_periode) . '.xlsx';
        
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        
        $writer->save('php://output');
    }
}