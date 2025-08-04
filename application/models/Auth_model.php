<?php
class Auth_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
        $this->load->database();   // ← tambahkan baris ini
    }

    public function check_login($username, $password)
    {
        $user = $this->db
                     ->where('username', $username)
                     ->get('users')
                     ->row();
        return ($user && password_verify($password, $user->password)) ? $user : false;
    }
}
