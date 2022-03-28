<?php

class Auth extends CI_Controller
{
    // method index() tidak kita pakai. Maka kita bisa panggil show_404() di sana.
    public function index()
    {
        show_404();
    }

    // login() untuk menampilkan form login dan memproses login;
    public function login()
    {
        $this->load->model('auth_model');
        $this->load->library('form_validation');

        $rules = $this->auth_model->rules();
        $this->form_validation->set_rules($rules);

        if ($this->form_validation->run() == FALSE) {
            return $this->load->view('login_form');
        }

        $username = $this->input->post('username');
        $password = $this->input->post('password');

        if ($this->auth_model->login($username, $password)) {
            redirect('admin');
        } else {
            $this->session->set_flashdata(
                'message_login_error',
                'Login Gagal, pastikan username dan passwrod benar!'
            );
        }

        $this->load->view('login_form');
    }

    // logout() untuk melakukan logout.
    public function logout()
    {
        $this->load->model('auth_model');
        $this->auth_model->logout();
        redirect(site_url());
    }
}
