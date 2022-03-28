<?php

class Article extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('article_model');
	}

	// untuk menampilkan list artikel
	public function index()
	{
		// mengambil artikel yg statusnya bukan draft
		$data['articles'] = $this->article_model->get_published();

		if (count($data['articles']) > 0) {
			// kirim data artikel ke view
			$this->load->view('articles/list_article.php', $data);
		} else {
			// kalau gaada artikel, tampilkan view ini
			$this->load->view('articles/empty_article.php');
		}
	}

	// untuk menampilkan artikel dengan slug tertentu
	public function show($slug = null)
	{
		// jika tidak ada slug di url, tampilkan 404
		if (!$slug) {
			show_404();
		}

		// mengambil artikell dengan slug yg diperlukan
		$data['article'] = $this->article_model->find_by_slug($slug);

		// jika artikel tidak ditemukan di database, tampilkan 404
		if (!$data['article']) {
			show_404();
		}

		// menampilkan artikel
		$this->load->view('articles/show_article.php', $data);
	}
}
