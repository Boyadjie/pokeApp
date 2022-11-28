<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use Symfony\Component\Security\Http\Attribute\CurrentUser;

class TrainerController extends AbstractController
{
  #[Route('/trainer/license', name: 'trainer_license')]
  public function number(#[CurrentUser] ?User $user): Response
  {
    $number = random_int(1000, 2000);

    // if (null === $user) {
    //   return $this->json([
    //     'message' => 'missing credentials',
    //   ], Response::HTTP_UNAUTHORIZED);
    // }

    // $token = "superToken";

    return $this->render('trainer/license.html.twig', [
      'number' => $number,
      // 'user'  => $user->getUserIdentifier(),
      // 'token' => $token,
    ]);
  }
}
