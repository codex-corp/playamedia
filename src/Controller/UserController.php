<?php

namespace App\Controller;

use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;

#[Route("/api", "api_")]
class UserController extends AbstractController
{
    #[Route('/users', name: 'app_user')]
    public function findUsers(Request $request, UserRepository $userRepository): JsonResponse
    {
        $isActive = (bool) $request->query->get('is_active');
        $isMember = (bool) $request->query->get('is_member');
        $lastLoginAtFrom = $request->query->get('last_login_at_from');
        $lastLoginAtTo = $request->query->get('last_login_at_to');
//        $userTypes = $request->query->get('user_types', []);
        $userTypes = [];

        return new JsonResponse(
            $userRepository->findByCriteria(
                $isActive, $isMember, $lastLoginAtFrom, $lastLoginAtTo, $userTypes
            ), 200);
    }
}
