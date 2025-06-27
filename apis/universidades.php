<?php include('../header.php'); ?>

<h2 class="text-center mb-4">🎓 Universidades por país 🎓</h2>

<div class="row justify-content-center mb-4">
  <div class="col-md-6">
    <form method="GET" class="d-flex" role="search">
      <input 
        class="form-control me-2" 
        type="search" 
        placeholder="Ej: Canada, Germany..." 
        aria-label="Buscar país" 
        name="pais" 
        value="<?php echo isset($_GET['pais']) ? htmlspecialchars($_GET['pais']) : ''; ?>"
        required
      >
      <button class="btn btn-primary" type="submit">Buscar</button>
    </form>
  </div>
</div>

<?php
if (isset($_GET['pais']) && !empty($_GET['pais'])) {
    $pais = trim($_GET['pais']);
    $url = "http://universities.hipolabs.com/search?country=" . urlencode($pais);
    $json = @file_get_contents($url);

    if ($json === FALSE) {
        echo "<div class='alert alert-danger text-center'>❌ No se pudo conectar con la API.</div>";
    } else {
        $data = json_decode($json, true);

        if (count($data) === 0) {
            echo "<div class='alert alert-warning text-center'>⚠️ No se encontraron universidades para <strong>" . htmlspecialchars($pais) . "</strong>.</div>";
        } else {
            echo "<div class='row justify-content-center'>";
            echo "<div class='col-md-8'>";
            echo "<h4 class='text-center mb-3'>Universidades en <strong>" . htmlspecialchars($pais) . "</strong></h4>";
            echo "<ul class='list-group'>";
            foreach ($data as $uni) {
                $nombre = htmlspecialchars($uni['name']);
                $web = htmlspecialchars($uni['web_pages'][0]);
                $dominio = htmlspecialchars($uni['domains'][0]);
                echo "<li class='list-group-item d-flex justify-content-between align-items-center'>";
                echo "<div><strong>$nombre</strong><br><small>$dominio</small></div>";
                echo "<a href='$web' target='_blank' class='btn btn-sm btn-outline-primary'>Visitar</a>";
                echo "</li>";
            }
            echo "</ul></div></div>";
        }
    }
}
?>

<?php include('../footer.php'); ?>