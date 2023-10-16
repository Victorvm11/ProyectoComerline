<?php
session_start();

// Función para obtener la lista de categorías desde la API
function getCategories()
{
    $api_url = 'https://api.chucknorris.io/jokes/categories';
    $response = file_get_contents($api_url);
    $categories = json_decode($response);
    return $categories;
}
// Función para obtener una frase aleatoria de una categoría
function getRandomPhrase($category)
{
    $api_url = "https://api.chucknorris.io/jokes/random?category=$category";
    $response = file_get_contents($api_url);
    $phrase = json_decode($response);
    return $phrase->value;
}
// Inicializar la lista de frases seleccionadas si no existe
if (!isset($_SESSION['selected_phrases'])) {
    $_SESSION['selected_phrases'] = array();
}
// Procesar la solicitud de selección de categoría y mostrar una frase aleatoria
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['selected_category'])) {
    $selected_category = $_POST['selected_category'];
    $random_phrase = getRandomPhrase($selected_category);
    array_push($_SESSION['selected_phrases'], $random_phrase);
} elseif (isset($_POST['clear_phrases'])) {
    // Borrar todas las frases almacenadas
    $_SESSION['selected_phrases'] = array();
}
// Obtener la lista de categorías
$categories = getCategories();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" type="text/css" href="api.css">
    <meta charset="UTF-8">
    <title>Chuck Norris Phrases</title>
</head>

<body>
    <h1>Chuck Norris Phrases</h1>

    <h2>Selecciona una categoría:</h2>
    <form method="post">
        <select class="select_personalizado" name="selected_category">
            <?php foreach ($categories as $category) { ?>
                <option value="<?php echo $category; ?>">
                    <?php echo $category; ?>
                </option>
            <?php } ?>
        </select>
        <button type="submit">Obtener frase</button>
    </form>

    <?php if (isset($random_phrase)) { ?>
        <h2>Frase aleatoria de la categoría seleccionada:</h2>
        <p>
            <?php echo $random_phrase; ?>
        </p>
    <?php } ?>

    <h2>Frases seleccionadas:</h2>
    <ul>
        <?php foreach ($_SESSION['selected_phrases'] as $selected_phrase) { ?>
            <li>
                <?php echo $selected_phrase; ?>
            </li>
        <?php } ?>
    </ul>
    <!-- Botón para borrar frases almacenadas -->
    <form method="post">
        <button type="submit" name="clear_phrases">Borrar Frases Almacenadas</button>
    </form>

</body>

</html>