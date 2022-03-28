<?php

class Article_model extends CI_Model
{
    private $_table = 'article';

    //Method get() untuk mengambil semua artikel dari database;

    public function get()
    {
        $query = $this->db->get($this->_table);
        return $query->result();
    }

    // get_published() untuk mengambil semua artikel yang statusnya terbit (draft = false)
    // Parameter $limit dan $offset berfungsi untuk menentukan banyak data yang harus diambil.

    public function get_published($limit = null, $offset = null)
    {
        if (!$limit && $offset) {
            $query = $this->db->get_where($this->_table, ['draft' => 'FALSE']);
        } else {
            $query = $this->db->get_where($this->_table, ['draft' => 'FALSE'], $limit, $offset);
        }
        return $query->result();
    }

    // find_by_slug() untuk mengambil satu artikel dengan slug tertentu,
    public function find_by_slug($slug)
    {
        if (!$slug) {
            return;
        }
        $query = $this->db->get_where($this->_table, ['slug' => $slug]);
        return $query->row();
    }

    //Method find() untuk mengambil satu artikel saja dengan id tertentu;

    public function find($id)
    {
        if (!$id) {
            return;
        }

        $query = $this->db->get_where($this->_table, array('id' => $id));
        return $query->row();
    }

    //Method insert() untuk menambahkan artikel baru;

    public function insert($article)
    {
        return $this->db->insert($this->_table, $article);
    }

    // Method update() untuk mengupdate artikel;
    public function update($article)
    {
        if (!isset($article['id'])) {
            return;
        }

        return $this->db->update($this->_table, $article, ['id' => $article['id']]);
    }

    // method delete() untuk menghapus artikel.
    public function delete($id)
    {
        if (!$id) {
            return;
        }

        return $this->db->delete($this->_table, ['id' => $id]);
    }

    public function count()
    {
        return $this->db->count_all($this->_table);
    }

    // Rules
    public function rules()
    {
        return [
            [
                'field' => 'title',
                'label' => 'Title',
                'rules' => 'required|max_length[128]'
            ],
            [
                'field' => 'draft',
                'label' => 'Draft',
                'rules' => 'required|in_list[true,false]'
            ],
            [
                'field' => 'content',
                'label' => 'Content',
                'rules' => '' // <-- rules dikosongkan
            ]
        ];
    }

    // Method ini akan berfungsi untuk melakukan pencarian artikel dengan query LIKE.
    public function search($keyword)
    {
        if (!$keyword) {
            return null;
        }
        $this->db->like('title', $keyword);
        $this->db->or_like('content', $keyword);
        $query = $this->db->get($this->_table);
        return $query->result();
    }

    // Method ini akan mengembalikan nilai berupa integer yang merupakan jumlah artikel yang sudah terbit.
    public function get_published_count()
    {
        $query = $this->db->get_where($this->_table, ['draft' => 'FALSE']);
        return $query->num_rows();
    }
}
