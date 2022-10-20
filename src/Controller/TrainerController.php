<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class TrainerController extends AbstractController
{
  #[Route('/trainer/license', name: 'trainer_license')]
  public function number(): Response
  {
    $number = random_int(1000, 2000);

    return $this->render('trainer/license.html.twig', [
      'number' => $number,
      'name' => "Ric",
    ]);
  }
}
