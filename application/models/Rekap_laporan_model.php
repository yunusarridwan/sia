<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Rekap_laporan_model extends CI_Model {

    public function get_laporan()
    {
        // Ambil total pemasukan dari mutasi_kantor
        $pemasukan = $this->db->select_sum('nominal')
                              ->get_where('mutasi_kantor', ['jenis_pemasukan' => 'Masuk'])
                              ->row()
                              ->nominal;

        // Ambil total pengeluaran dari pettycash
        $pengeluaran_petty = $this->db->select_sum('nominal')
                                      ->get('pettycash')
                                      ->row()
                                      ->nominal;

        // Ambil total pengeluaran dari fixed_variable_cost
        $pengeluaran_fv = $this->db->select_sum('nominal')
                                   ->get('fixed_variable_cost')
                                   ->row()
                                   ->nominal;

        // Hitung total pengeluaran & net margin
        $total_pengeluaran = $pengeluaran_petty + $pengeluaran_fv;
        $net_margin = $pemasukan - $total_pengeluaran;

        return [
            'pemasukan' => $pemasukan ?? 0,
            'pengeluaran_petty' => $pengeluaran_petty ?? 0,
            'pengeluaran_fv' => $pengeluaran_fv ?? 0,
            'total_pengeluaran' => $total_pengeluaran ?? 0,
            'net_margin' => $net_margin ?? 0
        ];
    }
}
