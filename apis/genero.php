<?php include("../header.php"); ?>

<style>
  .genero-container {
    max-width: 600px;
    margin: auto;
  }
  body {
    overflow-x: hidden;
  }
</style>

<div class="genero-container">
  <h2 class="text-center mb-4">🚺🚹 Predicción de Género 🚹🚺</h2>

  <form method="GET" class="mb-4">
    <div class="mb-3">
      <label for="nombre" class="form-label">Ingresa un nombre:</label>
      <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ej: Connor" required
        value="<?php echo isset($_GET['nombre']) ? htmlspecialchars($_GET['nombre']) : '' ?>">
    </div>
    <button type="submit" class="btn btn-primary">Predecir Género</button>
  </form>

  <div id="resultado">
    <?php
    if (isset($_GET['nombre']) && !empty(trim($_GET['nombre']))) {
        $nombre = urlencode(trim($_GET['nombre']));
        $url = "https://api.genderize.io/?name=$nombre";

        $response = @file_get_contents($url);

        if ($response === FALSE) {
            echo '<div class="alert alert-danger">❌ Error al conectarse a la API. Inténtalo más tarde.</div>';
        } else {
            $data = json_decode($response, true);

            if (!empty($data['gender'])) {
                $colorFondo = $data['gender'] === "male" ? "#cce5ff" : "#f8d7da";
                $textoGenero = $data['gender'] === "male" ? "Masculino 🚹" : "Femenino 🚺";
                $probabilidad = number_format($data['probability'] * 100, 2);

                $nombreFormateado = ucfirst(strtolower(trim($_GET['nombre'])));

                echo "
                <div class='p-4 rounded' style='background-color: $colorFondo;'>
                  <h4>Nombre: <strong>$nombreFormateado</strong></h4>
                  <h5>Género estimado: <strong>$textoGenero</strong></h5>
                  <p>Probabilidad: $probabilidad%</p>
                </div>
                ";
            } else {
                echo '<div class="alert alert-warning">⚠️ No se pudo predecir el género del nombre.</div>';
            }
        }
    }
    ?>
  </div>
</div>

<?php include("../footer.php"); ?>