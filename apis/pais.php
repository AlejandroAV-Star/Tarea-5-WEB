<?php include('../header.php'); ?>

<h2 class="text-center mb-4">🌎 Información de un País 🌎</h2>

<div class="row justify-content-center">
  <div class="col-md-6">
    <form method="GET" class="mb-4">
      <label for="pais" class="form-label">Nombre del país:</label>
      <input type="text" name="pais" id="pais" class="form-control" placeholder="Ej. Japón" required>
      <button type="submit" class="btn btn-primary w-100 mt-3">Buscar País</button>
    </form>

    <?php
    if (isset($_GET['pais']) && !empty(trim($_GET['pais']))) {
        $pais = htmlspecialchars(trim($_GET['pais']));
        $url = "https://restcountries.com/v3.1/name/" . urlencode($pais);
        $response = @file_get_contents($url);

        if ($response === FALSE) {
            echo "<div class='alert alert-danger'>❌ No se pudo conectar con el servicio.</div>";
        } else {
            $data = json_decode($response, true);

            if (isset($data[0])) {
                $paisData = $data[0];

                $bandera = $paisData['flags']['png'] ?? '';
                $capital = $paisData['capital'][0] ?? 'No disponible';
                $poblacion = number_format($paisData['population'] ?? 0, 0, ',', '.');
                
                $monedas = $paisData['currencies'] ?? [];
                $monedaNombre = $monedaSimbolo = "No disponible";
                if (!empty($monedas)) {
                    $keys = array_keys($monedas);
                    $monedaNombre = $monedas[$keys[0]]['name'] ?? "No disponible";
                    $monedaSimbolo = $monedas[$keys[0]]['symbol'] ?? "";
                }

                echo "
                <div class='card text-center shadow p-3'>
                  <h4><strong>{$paisData['name']['common']}</strong></h4>
                  <img src='{$bandera}' alt='Bandera de {$paisData['name']['common']}' class='img-fluid mx-auto mb-3' style='max-width: 200px;'>
                  <p><strong>Capital:</strong> {$capital}</p>
                  <p><strong>Población:</strong> {$poblacion}</p>
                  <p><strong>Moneda:</strong> {$monedaNombre} {$monedaSimbolo}</p>
                </div>
                ";
            } else {
                echo "<div class='alert alert-warning'>⚠️ No se encontró información para <strong>{$pais}</strong>.</div>";
            }
        }
    }
    ?>
  </div>
</div>

<?php include('../footer.php'); ?>