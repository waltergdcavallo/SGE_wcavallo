<?php
namespace App\Security;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator
    ) {}

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): RedirectResponse
    {
        $user = $token->getUser();
        
        $roles = $user->getRoles();

        if (in_array('ROLE_ADMIN', $roles, true)) {
            $targetUrl = $this->urlGenerator->generate('admin_dashboard');
        } else {
            $targetUrl = $this->urlGenerator->generate('usuario_dashboard'); 
        }

        return new RedirectResponse($targetUrl);
    }
}