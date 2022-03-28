<?php

//Pada model ini kita menggunakan query insert() untuk menambahkan data ke dalam tabel feedback.
class Feedback_model extends CI_Model
{
    private $_table = "feedback";

    public function rules()
    {
        return [
            [
                'field' => 'name',
                'label' => 'Name',
                'rules' => 'required|max_length[32]'
            ],
            [
                'field' => 'email',
                'label' => 'Email',
                'rules' => 'required|valid_email|max_length[32]'
            ],
            [
                'field' => 'message',
                'label' => 'Message',
                'rules' => 'required'
            ]
            ];
    }
    
    // Method () berfungsi untuk menghapus feedback.
    public function insert($feedback)
    {
        if(!$feedback){
            return;
        }

        return $this->db->insert($this->_table, $feedback);
    }

    // Method get() berfungsi untuk mengambil semua data di tabel feedback;
    public function get()
    {
        $query = $this->db->get($this->_table);
        return $query->result();
    }

    // Method delete() berfungsi untuk menghapus feedback.
    public function delete($id)
    {
        if(!$id){
            return;
        }

        $this->db->delete($this->_table, ['id' => $id]);
    }

    public function count()
    {
        return $this->db->count_all($this->_table);
    }
    
}