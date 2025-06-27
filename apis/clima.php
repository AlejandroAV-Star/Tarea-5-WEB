<?php include('../header.php'); ?>

<h2 class="text-center mb-4">⛅ Clima en República Dominicana ⛅</h2>

<div class="row justify-content-center">
  <div class="col-md-6">
    <form method="GET" class="mb-4">
      <div class="mb-3">
        <label for="ciudad" class="form-label">Ciudad:</label>
        <input type="text" name="ciudad" id="ciudad" class="form-control" placeholder="Ej. Santiago" required>
      </div>
      <button type="submit" class="btn btn-info w-100">Consultar Clima</button>
    </form>

    <?php
    if (isset($_GET['ciudad']) && !empty($_GET['ciudad'])) {
        $ciudad = htmlspecialchars($_GET['ciudad']);
        $apiKey = "3b7d125326db1795006f243778df5b61";

        $url = "https://api.openweathermap.org/data/2.5/weather?q=" . urlencode($ciudad) . ",DO&units=metric&lang=es&appid=" . $apiKey;
        $response = @file_get_contents($url);

        if ($response === FALSE) {
            echo '<div class="alert alert-danger">❌ No se pudo conectar con el servicio. Intenta más tarde.</div>';
        } else {
            $data = json_decode($response, true);
            if ($data['cod'] == 200) {
                $temperatura = $data['main']['temp'];
                $descripcion = ucfirst($data['weather'][0]['description']);
                $icono = $data['weather'][0]['icon'];
                $ciudadNombre = $data['name'];

                echo "
                <div class='card text-center shadow p-3'>
                  <h4>Clima en <strong>{$ciudadNombre}</strong></h4>
                  <img src='https://openweathermap.org/img/wn/{$icono}@2x.png' alt='Icono del clima'>
                  <h5>{$descripcion}</h5>
                  <p class='display-6'>{$temperatura}°C</p>
                </div>";
            } else {
                echo '<div class="alert alert-warning">⚠️ No se encontró información para esa ciudad.</div>';
            }
        }
    }
    ?>
  </div>
</div>

<?php include('../footer.php'); ?>