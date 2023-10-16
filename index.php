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