<?php
// Función para obtener los datos del Pokémon usando la API de PokeAPI
function fetchPokemonData($pokemonName) {
    $pokemonName = strtolower(trim($pokemonName)); // Asegurarse de que el nombre esté en minúsculas
    $url = "https://pokeapi.co/api/v2/pokemon/{$pokemonName}";
    $response = @file_get_contents($url); // Manejar posibles errores con @

    if ($response === FALSE) {
        return null; // Si no se pudo obtener el Pokémon, retornamos null
    }

    $data = json_decode($response, true); // Decodificamos el JSON de la respuesta

    return [
        'name' => ucfirst($data['name']), // Nombre del Pokémon con la primera letra en mayúscula
        'height' => $data['height'],
        'weight' => $data['weight'],
        'abilities' => implode(', ', array_map(function($ability) {
            return $ability['ability']['name'];
        }, $data['abilities'])),
        'image' => $data['sprites']['front_default']
    ];
}

$pokemon = null;
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['pokemon-name'])) {
    $pokemonName = $_POST['pokemon-name'];
    $pokemon = fetchPokemonData($pokemonName); // Buscar el Pokémon por nombre
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscador de Pokémon</title>
    <!-- Incluir Bootstrap desde CDN para los estilos -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Buscador de Pokémon</h1>
        <form method="POST" class="form-inline justify-content-center mb-4">
            <input type="text" name="pokemon-name" class="form-control mr-2" placeholder="Ingresa el nombre de un Pokémon" required>
            <button type="submit" class="btn btn-primary">Buscar</button>
        </form>

        <?php if ($pokemon): ?>
            <div class="card mx-auto" style="width: 18rem;">
                <img src="<?= $pokemon['image']; ?>" class="card-img-top" alt="Imagen de <?= $pokemon['name']; ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $pokemon['name']; ?></h5>
                    <p class="card-text"><strong>Altura:</strong> <?= $pokemon['height']; ?> decímetros</p>
                    <p class="card-text"><strong>Peso:</strong> <?= $pokemon['weight']; ?> hectogramos</p>
                    <p class="card-text"><strong>Habilidades:</strong> <?= $pokemon['abilities']; ?></p>
                </div>
            </div>
        <?php elseif ($_SERVER['REQUEST_METHOD'] === 'POST'): ?>
            <div class="alert alert-danger mt-4 text-center">
                Pokémon no encontrado. Intenta de nuevo.
            </div>
        <?php endif; ?>
    </div>

    
</body>
</html>
