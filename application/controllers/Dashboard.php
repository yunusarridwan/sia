<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Dashboard_model');
        $this->load->helper('url');
    }

    public function index()
    {
        $data['title'] = 'Dashboard';
        $data['chart_net_margin'] = $this->Dashboard_model->grafik_net_margin();
        $data['chart_arus_kas']   = $this->Dashboard_model->grafik_arus_kas();

        // view dashboard yang akan dimuat di layout
        $data['content'] = 'dashboard/index'; 
        $this->load->view('layouts/main', $data);
    }
}
