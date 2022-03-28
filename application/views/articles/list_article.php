<!DOCTYPE html>
<html lang="en">
<head>
	<?php $this->load->view('_partials/head.php'); ?>
</head>

<body>
    <?php $this->load->view('_partials/navbar.php'); ?>

        <h1>List Artikel</h1>
            <ul>
                <?php foreach($articles as $article): ?>
                    <li>
                        <!-- site url untuk membuat link -->
                        <a href="<?= site_url('article/'.$article->slug) ?>">
                            <!-- html_escape(), fungsi ini bertujuan untuk mencegah XSS attack. -->
                            <?= $article->title ? html_escape($article->title) : "No Title" ?>
                        </a>
                    </li>
                <?php endforeach ?>
            </ul>

    <?php $this->load->view('_partials/footer.php'); ?>
</body>
</html>