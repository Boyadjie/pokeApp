<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class ApiController extends AbstractController
{
  #[Route('/api/posts', methods: ['GET', 'HEAD'])]
  public function show(): Response
  {
    $posts = [
      [
        "id" => 0,
        "title" => "Post 1 title",
        "description" => "Lorem Ipsum sit amet...."
      ],
      [
        "id" => 1,
        "title" => "Post 2 title",
        "description" => "Lorem Ipsum sit amet...."
      ],
    ];

    return new Response(json_encode($posts));
  }
}
