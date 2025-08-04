<?php
class Auth extends CI_Controller {
  public function __construct() {
    parent::__construct();
    $this->load->model('Auth_model');
    $this->load->library('session');
    $this->load->helper('url'); // <-- TAMBAH INI
}

  public function index() {
    if ($this->session->userdata('logged_in')) redirect('dashboard');
    $this->load->view('auth/login');
  }

  public function login() {
    $username = $this->input->post('username', TRUE);
    $password = $this->input->post('password', TRUE);
    $user = $this->Auth_model->check_login($username, $password);

    if ($user) {
      $this->session->set_userdata([
        'id' => $user->id,
        'nama' => $user->nama,
        'role' => $user->role,
        'logged_in' => TRUE
      ]);
      redirect('dashboard');
    } else {
      $this->session->set_flashdata('error', 'Username atau Password salah.');
      redirect('auth');
    }
  }

  public function logout() {
    $this->session->sess_destroy();
    redirect('auth');
  }
}