<?php


namespace App\Handler;

use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;


class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    protected
        $router,
        $security;

    public function __construct(RouterInterface $router, Security $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        /** @var User $user */
        $user = $token->getUser();
        $response = '';
        if ($this->security->isGranted('ROLE_ADMIN')) {
            $response = new RedirectResponse($this->router->generate('easyadmin'));
        }
        elseif ($this->security->isGranted('ROLE_USER')) {
            $response = new RedirectResponse($this->router->generate('profile', [
                'id' => $user->getId()
            ]));
        }


        return $response;
    }
}