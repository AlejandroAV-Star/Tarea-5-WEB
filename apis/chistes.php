<?php include('../header.php'); ?>

<h2 class="text-center mb-4">😆 Generador de Chistes Aleatorios 😆</h2>

<div class="row justify-content-center">
  <div class="col-md-6">

    <?php
      $url = "https://official-joke-api.appspot.com/random_joke";
      $response = @file_get_contents($url);

      if ($response === FALSE) {
          echo "<div class='alert alert-danger'>❌ No se pudo obtener un chiste en este momento 😭. Intenta más tarde.</div>";
      } else {
          $data = json_decode($response, true);
          $setup = $data['setup'] ?? '';
          $punchline = $data['punchline'] ?? '';

          echo "
          <div class='card shadow p-4 text-center'>
            <h4>🤣 {$setup}</h4>
            <hr>
            <h5><em>{$punchline}</em></h5>
          </div>
          ";
      }
    ?>

  </div>
</div>

<?php include('../footer.php'); ?>