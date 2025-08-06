<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gaji extends CI_Controller {

    // ... (fungsi __construct, edit, update tidak perlu diubah) ...
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Gaji_model');
        $this->load->model('Karyawan_model');
        $this->load->model('Absensi_model');
        $this->load->model('Lembur_model');
        $this->load->library('session');
        $this->load->database();
    }

    /**
     * PERBAIKAN LOGIKA INDEX
     * Fungsi ini akan mengecek apakah data ada. Jika tidak, akan memberi pesan khusus.
     */
    public function index()
    {
        $data['title'] = 'Rekap Gaji Karyawan';
        $start_date = $this->input->get('start_date');
        $end_date = $this->input->get('end_date');
        
        // Default: jangan tampilkan data apa pun
        $data['gaji'] = [];

        // HANYA ambil data dari database JIKA pengguna sudah menekan tombol filter
        if ($start_date && $end_date) {
            $data['gaji'] = $this->Gaji_model->get_all($start_date, $end_date);
            
            // Cek jika data tetap kosong setelah difilter, untuk memberi pesan cerdas
            if (empty($data['gaji'])) {
                $this->session->set_flashdata('rekap_needed', 'Data untuk periode yang Anda pilih belum dibuat.');
            }
        }

        $data['content'] = 'gaji/index';
        $this->load->view('layouts/main', $data);
    }
    
    // ... (fungsi edit dan update tetap sama) ...
    public function edit($id)
    {
        $data['title'] = 'Edit Gaji Karyawan';
        $gaji_record = $this->Gaji_model->get_by_id($id);

        if (!$gaji_record) {
            show_404();
        }

        $bulan_rekap = $gaji_record->bulan;
        $karyawan_id = $gaji_record->karyawan_id;
        $start_date = date('Y-m-01', strtotime($bulan_rekap));
        $end_date = date('Y-m-t', strtotime($bulan_rekap));

        $absen_summary = $this->Absensi_model->get_summary($karyawan_id, $start_date, $end_date);
        
        $data['gaji'] = $gaji_record;
        $data['absen'] = $absen_summary;
        $data['content'] = 'gaji/edit';
        $this->load->view('layouts/main', $data);
    }
    
    public function update()
    {
        $id = $this->input->post('id');
        $gaji_record = $this->Gaji_model->get_by_id($id);

        if (!$gaji_record) {
            $this->session->set_flashdata('error', 'Data gaji tidak ditemukan.');
            redirect('gaji');
        }

        $insentif = (int) str_replace('.', '', $this->input->post('insentif'));
        $total_tambahan = (int) str_replace('.', '', $this->input->post('total_tambahan'));
        $total_potongan = (int) str_replace('.', '', $this->input->post('total_potongan'));
        $gaji_pokok = (int) $gaji_record->gaji_pokok;

        $total_gaji = $gaji_pokok + $total_tambahan + $insentif - $total_potongan;

        $data = [
            'insentif' => $insentif,
            'total_tambahan' => $total_tambahan,
            'total_potongan' => $total_potongan,
            'total_gaji' => $total_gaji
        ];

        $this->Gaji_model->update($id, $data);
        $this->session->set_flashdata('success', 'Data gaji berhasil diperbarui.');
        redirect('gaji?start_date='.$gaji_record->bulan.'-01&end_date='.$gaji_record->bulan.'-28');
    }

    /**
     * FUNGSI REKAP OTOMATIS (sudah benar dari sebelumnya)
     */
    public function rekap_otomatis()
    {
        $start_date_input = $this->input->get('start_date');
        $end_date_input = $this->input->get('end_date');

        if (empty($start_date_input) || empty($end_date_input)) {
            $this->session->set_flashdata('error', 'Silakan pilih rentang tanggal terlebih dahulu.');
            redirect('gaji');
            return;
        }

        $start    = (new DateTime($start_date_input))->modify('first day of this month');
        $end      = (new DateTime($end_date_input))->modify('first day of this month');
        $interval = DateInterval::createFromDateString('1 month');
        $period   = new DatePeriod($start, $interval, $end->modify('+1 day'));

        $users = $this->Karyawan_model->get_all();
        $bulan_diproses = [];

        foreach ($period as $dt) {
            $tahun = $dt->format('Y');
            $bulan = $dt->format('m');
            $bulan_rekap = $dt->format('Y-m');
            $bulan_diproses[] = date('F Y', strtotime($bulan_rekap));

            $start_date_rekap = $tahun . '-' . $bulan . '-01';
            $end_date_rekap = date('Y-m-t', strtotime($start_date_rekap));

            foreach ($users as $user) {
                $karyawan_id = $user->karyawan_id; 
                
                $absen = $this->Absensi_model->get_summary($karyawan_id, $start_date_rekap, $end_date_rekap);
                $izin  = $absen->total_izin ?? 0;
                $sakit = $absen->total_sakit ?? 0;
                $telat = $absen->total_telat ?? 0;

                $lembur = $this->Lembur_model->get_total_tambahan($karyawan_id, $start_date_rekap, $end_date_rekap);
                $total_tambahan = $lembur ?? 0;

                $potongan_absen = ($telat * 50000) + ($izin * 100000);
                
                $insentif = 0;
                $gaji_pokok = $user->gaji_pokok;
                $total_potongan = $potongan_absen;
                $total_gaji = $gaji_pokok + $insentif + $total_tambahan - $total_potongan;

                $existing_gaji = $this->Gaji_model->check_existing($karyawan_id, $bulan_rekap);
                
                $data_gaji = [
                    'karyawan_id' => $karyawan_id, 'bulan' => $bulan_rekap, 'total_izin' => $izin, 
                    'sakit' => $sakit, 'total_telat' => $telat, 'insentif' => $insentif, 
                    'total_tambahan' => $total_tambahan, 'potongan_absen' => $potongan_absen, 
                    'total_potongan' => $total_potongan, 'gaji_pokok' => $gaji_pokok, 'total_gaji' => $total_gaji,
                ];

                if ($existing_gaji) {
                    $this->Gaji_model->update($existing_gaji->id, $data_gaji);
                } else {
                    $data_gaji['tanggal_dibuat'] = date('Y-m-d H:i:s');
                    $this->Gaji_model->simpan($data_gaji);
                }
            }
        }

        $this->session->set_flashdata('success', 'Rekap gaji untuk bulan ' . implode(', ', $bulan_diproses) . ' berhasil dibuat/diperbarui.');
        redirect('gaji?start_date=' . $start_date_input . '&end_date=' . $end_date_input);
    }
}