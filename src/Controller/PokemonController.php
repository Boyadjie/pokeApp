<?php

namespace App\Controller;

use App\Entity\Pokemon;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class PokemonController extends AbstractController
{

    private $client;
    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    #[Route('/pokemon', name: 'pokemons')]
    public function getPokemons(): Response
    {
        $response = $this->client->request(
            'GET',
            'https://pokeapi.co/api/v2/pokemon/',
        );

        // $statusCode = $response->getStatusCode();
        // $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
        $content = $response->toArray();

        $pokemonList = [];

        foreach ($content["results"] as $key => $value) {
            preg_match("/([^\/]+)(?=[^\/]*\/?$)/", $value["url"], $matches);
            $pokeId = $matches[0];
            $img = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/" . $pokeId . ".png";

            array_push($pokemonList, ["name" => $value["name"], "img" => $img]);
        }

        return $this->render('pokemon/search.html.twig', [
            'controller_name' => 'PokemonController',
            'list' => $pokemonList,
        ]);
    }

    #[Route('/pokemon/{name}', name: 'one_pokemon')]
    public function getOnePokemonFromApi(string $name): Response
    {
        $response = $this->client->request(
            'GET',
            'https://pokeapi.co/api/v2/pokemon/' . $name,
        );

        // $statusCode = $response->getStatusCode();
        // $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
        $content = $response->toArray();

        if ($name) {
            $pokemon = new Pokemon();

            $pokemon->setPokeId($content["id"]);
            $pokemon->setName($content["name"]);
            $pokemon->setWeight($content["weight"]);
            $pokemon->setPokeOrder($content["order"]);
            $pokemon->setBaseExperience($content["base_experience"]);
            $pokemon->setTypes($content["types"]);
            $pokemon->setStats($content["stats"]);
            $pokemon->setSpecies($content["species"]);

            $img = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/" . $pokemon->getPokeId() . ".png";
        }


        return $this->render('pokemon/index.html.twig', [
            'controller_name' => 'PokemonController',
            'pokemon' => $pokemon,
            'imgUrl' => $img,
        ]);
    }
}
