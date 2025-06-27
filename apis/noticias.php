<?php include('../header.php'); ?>

<h2 class="text-center mb-4">📰 Noticias desde WordPress 📰</h2>

<div class="row justify-content-center">
  <div class="col-md-6">
    <form method="GET" class="mb-4">
      <label for="fuente" class="form-label">Selecciona una página de noticias:</label>
      <select name="fuente" id="fuente" class="form-select" required>
        <option value="">-- Selecciona una fuente --</option>
        <option value="https://techcrunch.com">TechCrunch</option>
        <option value="https://wordpress.org/news">WordPress.org</option>
      </select>
      <button type="submit" class="btn btn-secondary mt-3 w-100">Ver noticias</button>
    </form>

    <?php
    if (isset($_GET['fuente']) && !empty($_GET['fuente'])) {
        $fuente = $_GET['fuente'];
        $url = $fuente . "/wp-json/wp/v2/posts?per_page=3";
        $response = @file_get_contents($url);

        if ($response === FALSE) {
            echo "<div class='alert alert-danger'>❌ No se pudo conectar con la fuente de noticias.</div>";
        } else {
            $posts = json_decode($response, true);

            echo "<div class='list-group'>";
            foreach ($posts as $post) {
                $titulo = $post['title']['rendered'];
                $contenido = strip_tags($post['excerpt']['rendered']);
                $link = $post['link'];

                echo "
                  <a href='{$link}' target='_blank' class='list-group-item list-group-item-action'>
                    <h5>{$titulo}</h5>
                    <p>{$contenido}</p>
                  </a>
                ";
            }
            echo "</div>";
        }
    }
    ?>
  </div>
</div>

<?php include('../footer.php'); ?>