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

    #[Route('/pokemon', name: 'app_pokemon')]
    public function getOnePokemonFromApi(): Response
    {
        $response = $this->client->request(
            'GET',
            'https://pokeapi.co/api/v2/pokemon/charizard'
        );

        // $statusCode = $response->getStatusCode();
        // $contentType = $response->getHeaders()['content-type'][0];
        $content = $response->getContent();
        $content = $response->toArray();

        $pokemon = new Pokemon();

        $pokemon->setPokeId($content["id"]);
        $pokemon->setName($content["name"]);
        $pokemon->setWeight($content["weight"]);
        $pokemon->setPokeOrder($content["order"]);
        $pokemon->setBaseExperience($content["base_experience"]);
        $pokemon->setTypes($content["types"]);
        $pokemon->setStats($content["stats"]);
        $pokemon->setSpecies($content["species"]);

        return $this->render('pokemon/index.html.twig', [
            'controller_name' => 'PokemonController',
            'pokemon' => $pokemon,
        ]);
    }
}
