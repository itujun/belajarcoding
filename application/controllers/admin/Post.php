<?php

class Post extends CI_Controller
{

    // Method __construct(): konstruktor untuk load model Article_model.php secara default;
    public function __construct()
    {
        parent::__construct();
        $this->load->model('article_model');
        $this->load->model('auth_model');
        if (!$this->auth_model->current_user()) {
            redirect('auth/login');
        }
    }


    // Method index(): untuk menampilkan list artikel baik yang statusnya sudah terbit maupun draft;
    public function index()
    {
        $data['current_user'] = $this->auth_model->current_user();
        $data['articles'] = $this->article_model->get();

        if (count($data['articles']) <= 0) {
            $this->load->view('admin/post_empty.php', $data);
        } else {
            $this->load->view('admin/post_list.php', $data);
        }
    }

    // Method new(): untuk membuat atau menambahkan artikel baru;
    public function neww()
    {
        $data['current_user'] = $this->auth_model->current_user();
        $this->load->library('form_validation');

        if ($this->input->method() === 'post') {
            // lakukan validasi sebelum menyimpan ke model
            $rules = $this->article_model->rules();
            $this->form_validation->set_rules($rules);

            if ($this->form_validation->run() === FALSE) {
                return $this->load->view('admin/post_new_form.php', $data);
            }

            // generate unique id dan slug
            $id = uniqid('', true);
            $slug = url_title($this->input->post('title'), 'dash', TRUE) . '-' . $id;
            // Pada method new() diaas, kita menggunakan fungsi url_title() dari 
            // helper url untuk membuat slug dan uniqid() untuk membuat id unik.

            $article = [
                'id' => $id,
                'title' => $this->input->post('title'),
                'slug' => $slug,
                'content' => $this->input->post('content'),
                'draft' => $this->input->post('draft')
            ];

            $saved = $this->article_model->insert($article);

            if ($saved) {
                $this->session->set_flashdata('message', 'Article was created');
                return redirect('admin/post');
            }
        }

        $this->load->view('admin/post_new_form.php', $data);
    }

    // Methode edit(): untuk mengubah artikel tertentu;
    public function edit($id = null)
    {
        $data['current_user'] = $this->auth_model->current_user();
        $data['article'] = $this->article_model->find($id);
        $this->load->library('form_validation');

        if (!$data['article'] || !$id) {
            show_404();
        }

        if ($this->input->method() === 'post') {
            // lakukan valifikasi data sebelum disimpan di model
            $rules = $this->article_model->rules();
            $this->form_validation->set_rules($rules);

            if ($this->form_validation->run() === FALSE) {
                return $this->load->view('admin/post_edit_form.php', $data);
            }

            $article = [
                'id' => $id,
                'title' => $this->input->post('title'),
                'content' => $this->input->post('content'),
                'draft' => $this->input->post('draft')
            ];

            $updated = $this->article_model->update($article);
            if ($updated) {
                $this->session->set_flashdata('message', 'Article was updated');
                redirect('admin/post');
            }
        }

        $this->load->view('admin/post_edit_form.php', $data);
    }

    // Methode delete(): untuk menghapus artikel;
    public function delete($id = null)
    {
        if (!$id) {
            show_404();
        }

        $deleted = $this->article_model->delete($id);
        if ($deleted) {
            $this->session->set_flashdata('message', 'Article was deleted');
            redirect('admin/post');
        }
    }

    // Kita juga menggunakan libraray session pada 
    // method new(), edit(), dan delete() untuk menampilkan flash data atau message.
}
