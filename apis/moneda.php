<?php include('../header.php'); ?>

<h2 class="text-center mb-4">🪙 Conversión de Monedas 🪙</h2>

<div class="row justify-content-center">
  <div class="col-md-6">
    <form method="GET" class="mb-4">
      <label for="cantidad" class="form-label">Cantidad en USD:</label>
      <input type="number" name="cantidad" id="cantidad" class="form-control" step="0.01" required placeholder="Ej. 100">
      <button type="submit" class="btn btn-success w-100 mt-3">Convertir</button>
    </form>

    <?php
    if (isset($_GET['cantidad']) && is_numeric($_GET['cantidad'])) {
        $cantidad = floatval($_GET['cantidad']);
        $url = "https://api.exchangerate-api.com/v4/latest/USD";
        $response = @file_get_contents($url);

        if ($response === FALSE) {
            echo "<div class='alert alert-danger'>❌ No se pudo conectar con el servicio.</div>";
        } else {
            $data = json_decode($response, true);
            $dop = round($cantidad * $data['rates']['DOP'], 2);
            $eur = round($cantidad * $data['rates']['EUR'], 2);
            $mxn = round($cantidad * $data['rates']['MXN'], 2);

            echo "
            <div class='card shadow text-center p-3'>
              <h4><strong>{$cantidad} USD</strong> equivale a:</h4>
              <p>🇩🇴 <strong>{$dop} DOP</strong></p>
              <p>🇪🇺 <strong>{$eur} EUR</strong></p>
              <p>🇲🇽 <strong>{$mxn} MXN</strong></p>
            </div>";
        }
    } elseif (isset($_GET['cantidad'])) {
        echo "<div class='alert alert-warning'>⚠️ Error, ingresa un número válido.</div>";
    }
    ?>
  </div>
</div>

<?php include('../footer.php'); ?>