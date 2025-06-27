<?php include('../header.php'); ?>

<h2 class="text-center mb-4">🤖 Generador de Imágenes con IA 🤖</h2>

<div class="row justify-content-center">
  <div class="col-md-6">
    <form method="GET" class="mb-4">
      <label for="palabra" class="form-label">Palabra clave para buscar imagen:</label>
      <input type="text" name="palabra" id="palabra" class="form-control" placeholder="Ej. banco, máquina" required>
      <button type="submit" class="btn btn-info w-100 mt-3">Buscar Imagen</button>
    </form>

    <?php
    if (isset($_GET['palabra']) && !empty(trim($_GET['palabra']))) {
        $keyword = htmlspecialchars(trim($_GET['palabra']));
        $pexelsKey = "CaESVLKUxEcPAJMhN2iIJuU76QNBVkbfh2B2ODR9VhK3NF23qwNZi4aW";
        $pexelsUrl = "https://api.pexels.com/v1/search?query=" . urlencode($keyword) . "&per_page=1&locale=es-ES";

        $headers = [
            "Authorization: $pexelsKey"
        ];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $pexelsUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        $response = curl_exec($ch);
        curl_close($ch);

        if ($response === FALSE) {
            echo "<div class='alert alert-danger'>❌ Error al conectar con la API de Pexels.</div>";
        } else {
            $data = json_decode($response, true);
            if (!empty($data['photos'])) {
                $imgUrl = $data['photos'][0]['src']['large'];
                echo "
                <div class='card text-center shadow p-3'>
                  <h4>Imagen para <strong>{$keyword}</strong></h4>
                  <img src='{$imgUrl}' alt='{$keyword}' class='img-fluid mx-auto' style='max-width: 100%; height: auto;'>
                </div>
                ";
            } else {
                echo "<div class='alert alert-warning'>⚠️ No se encontró ninguna imagen para <strong>{$keyword}</strong>.</div>";
            }
        }
    }
    ?>
  </div>
</div>

<?php include('../footer.php'); ?>
