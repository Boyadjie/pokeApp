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
            'https://pokeapi.co/api/v2/pokemon?limit=2000&offset=0',
        );

        // $statusCode = $response->getStatusCode();
        // $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
        $content = $response->toArray();

        // Get all the pokemons formated with name and img associated
        $pokemonList = [];
        foreach ($content["results"] as $key => $value) {
            preg_match("/([^\/]+)(?=[^\/]*\/?$)/", $value["url"], $matches);
            $pokeId = $matches[0];
            $img = "https://raw.githubusercontent.com/PokeAPI/sprites/master/sprites/pokemon/" . $pokeId . ".png";

            array_push($pokemonList, ["name" => $value["name"], "img" => $img]);
        }


        // -------------------------------
        // Page Management ---------------
        // -------------------------------

        $pokemonPerPages = 54;
        $maxPages = ceil(count($pokemonList) / $pokemonPerPages);
        $pages = [];
        for ($i = 1; $i <= $maxPages; $i++) {
            array_push($pages, $i);
        }

        // Set the default display list with the 54 first pokemons
        $displayList = [];
        foreach ($pokemonList as $key => $value) {
            if ($key >= 0 && $key < $pokemonPerPages) {
                array_push($displayList, $value);
            }
        }

        // Display the pokemons seperated by pages
        if (isset($_GET) && !empty($_GET)) {
            $displayList = [];
            $pageNumber = intval($_GET["page"]);
            $currentPage = $pageNumber;
            $offset = ($pageNumber * $pokemonPerPages) - $pokemonPerPages;

            foreach ($pokemonList as $key => $value) {
                if ($key >= $offset && $key < $offset + $pokemonPerPages) {
                    array_push($displayList, $value);
                }
            }
        } else {
            $currentPage = 1;
        }

        // -------------------------------
        // Search System ---------------
        // -------------------------------
        if (isset($_POST) && !empty($_POST)) {
            $searched = $_POST["search"];
            if ($searched != "" || $searched != " ") {
                $searchResult = [];
                foreach ($pokemonList as $key => $value) {
                    $searchedValue = strtolower($_POST["search"]);
                    $isInName = strstr($value["name"], $searchedValue);
                    if ($isInName) {
                        array_push($searchResult, $pokemonList[$key]);
                    }
                }
                $displayList = $searchResult;
            }
        } else {
            $searched = "";
        }

        return $this->render('pokemon/search.html.twig', [
            'controller_name' => 'PokemonController',
            'list' => $displayList,
            'searched' => $searched,
            'pages' => $pages,
            'currentPage' => $currentPage,
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
            $pokemon->setBaseExperience($content["base_experience"] || 0);
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
