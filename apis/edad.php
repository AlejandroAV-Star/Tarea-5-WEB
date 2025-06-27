<?php include('../header.php'); ?>

<h2 class="text-center mb-4">📅 Predicción de Edad 📅</h2>

<div class="row justify-content-center">
  <div class="col-md-6">
    <form method="GET" class="mb-4">
      <div class="mb-3">
        <label for="nombre" class="form-label">Nombre:</label>
        <input type="text" name="nombre" id="nombre" class="form-control" required>
      </div>
      <button type="submit" class="btn btn-primary w-100">Predecir Edad</button>
    </form>

    <?php
    if (isset($_GET['nombre']) && !empty($_GET['nombre'])) {
        $nombre = htmlspecialchars($_GET['nombre']);
        $url = "https://api.agify.io/?name=" . urlencode($nombre);
        $response = @file_get_contents($url);

        if ($response === FALSE) {
            echo '<div class="alert alert-danger">❌ Error al conectar con la API. Intenta más tarde.</div>';
        } else {
            $data = json_decode($response, true);
            if (isset($data['age'])) {
                $edad = $data['age'];
                if ($edad < 18) {
                    $categoria = "Joven 👶";
                    $imagen = "https://cdn-icons-png.flaticon.com/512/1804/1804275.png";
                } elseif ($edad <= 60) {
                    $categoria = "Adulto 🧑";
                    $imagen = "https://cdn-icons-png.flaticon.com/512/706/706830.png";
                } else {
                    $categoria = "Anciano 👴";
                    $imagen = "https://cdn-icons-png.flaticon.com/512/1995/1995617.png";
                }

                echo "
                    <div class='card shadow text-center p-3'>
                        <h4>Edad estimada para <strong>{$data['name']}</strong>: <span class='text-primary'>{$edad} años</span></h4>
                        <h5>{$categoria}</h5>
                        <img src='{$imagen}' alt='Edad' class='img-fluid mx-auto' style='max-width: 150px;'>
                    </div>
                ";
            } else {
                echo '<div class="alert alert-warning">No se pudo predecir la edad.</div>';
            }
        }
    }
    ?>
  </div>
</div>

<?php include('../footer.php'); ?>