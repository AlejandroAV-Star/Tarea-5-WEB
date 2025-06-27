<?php include('../header.php'); ?>

<h2 class="text-center mb-4">🐉 Información de un Pokémon 🐉</h2>

<div class="row justify-content-center">
  <div class="col-md-6">
    <form method="GET" class="mb-4">
      <div class="mb-3">
        <label for="pokemon" class="form-label">Nombre del Pokémon:</label>
        <input type="text" name="pokemon" id="pokemon" class="form-control" placeholder="Ej. Mew" required>
      </div>
      <button type="submit" class="btn btn-warning w-100">Buscar Pokémon</button>
    </form>

    <?php
    if (isset($_GET['pokemon']) && !empty($_GET['pokemon'])) {
        $nombre = strtolower(trim($_GET['pokemon']));
        $url = "https://pokeapi.co/api/v2/pokemon/" . urlencode($nombre);
        $response = @file_get_contents($url);

        if ($response === FALSE) {
            echo "<div class='alert alert-danger'>❌ No se encontró información para <strong>$nombre</strong>.</div>";
        } else {
            $data = json_decode($response, true);

            $imagen = $data['sprites']['front_default'];
            $experiencia = $data['base_experience'];
            $habilidades = array_map(function ($h) {
                return $h['ability']['name'];
            }, $data['abilities']);
            $sonido = "https://play.pokemonshowdown.com/audio/cries/{$nombre}.mp3";

            echo "
              <div class='card text-center shadow p-3'>
                <h4 class='text-capitalize'><strong>{$nombre}</strong></h4>
                <img src='{$imagen}' alt='{$nombre}' class='img-fluid mx-auto' style='max-width: 150px;'>
                <p class='mt-3'><strong>Experiencia base:</strong> {$experiencia}</p>
                <p><strong>Habilidades🔥:</strong> " . implode(', ', $habilidades) . "</p>
                <audio controls>
                  <source src='{$sonido}' type='audio/mpeg'>
                  Tu navegador no soporta el audio 🔈.
                </audio>
              </div>
            ";
        }
    }
    ?>
  </div>
</div>

<?php include('../footer.php'); ?>