<?php

namespace App\Controller;

use App\Entity\Pokemon;
use App\Entity\Team;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TeamController extends AbstractController
{
    #[Route('/team', name: 'app_team')]
    public function index(ManagerRegistry $doctrine): Response
    {
        $teamRepository = $doctrine->getRepository(Team::class);
        $pokemonRepository = $doctrine->getRepository(Pokemon::class);
        $entityManager = $doctrine->getManager();
        $pokemonList = [];

        // $teams = $teamRepository->findAll();
        $team = $teamRepository->findOneBy([
            'userId' => 1,
        ]);

        if ($team) {
            $list = $team->getList();

            foreach ($list as $key => $pokeID) {
                $pokemon = $pokemonRepository->findOneBy([
                    'pokeId' => $pokeID,
                ]);
                array_push($pokemonList, $pokemon);
            }

            if (isset($_POST) && !empty($_POST)) {
                $pokemonToRemove = $pokemonList[$_POST["removePokemonId"]];
                $team->removePokemonIdFromTeam($_POST["removePokemonId"]);
                unset($pokemonList[$_POST["removePokemonId"]]);
                $entityManager->flush();

                // $entityManager->remove($pokemonToRemove);
                // $entityManager->flush();
            }
        }


        return $this->render('team/index.html.twig', [
            'controller_name' => 'TeamController',
            'team' => $pokemonList,
        ]);
    }
}
