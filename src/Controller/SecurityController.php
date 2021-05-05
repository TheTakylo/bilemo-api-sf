<?php

namespace App\Controller;

use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class SecurityController extends AbstractController
{
    /**
     * @OA\Tag(name="Login")
     * @OA\Post(
     *   operationId="get-jwt-token",
     *   summary="Get a JWT token"
     * )
     * @Route("/api/login_check", name="security_login_check", methods="POST")
     */
    public function login()
    {
        throw new \Exception('Should not be reached');
    }
}
