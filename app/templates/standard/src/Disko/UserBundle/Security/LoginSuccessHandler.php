<?php

/**
 * Handler
 *
 * @author Adrien Jerphagnon <adrien.j@disko.fr>
 */

namespace Disko\UserBundle\Security;

use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Router;
use Symfony\Component\Httpfoundation\Response;

/**
 * The LoginSuccessHandler class is call after authentication.
 *
 * @SuppressWarnings(PHPMD.UnusedLocalVariable)
 */
class LoginSuccessHandler implements AuthenticationSuccessHandlerInterface
{
    /**
     * Router
     *
     * @var Router
     */
    protected $router;

    /**
     * Security
     *
     * @var SecurityContext
     */
    protected $security;

    /**
     * Initialize authentication
     *
     * @param Router          $router   Router
     * @param SecurityContext $security SecurityContext
     *
     * @return void
     */
    public function __construct($router, SecurityContext $security)
    {
        $this->router = $router;
        $this->security = $security;
    }

    /**
     * Redirect user after authentication at the correct url.
     * Display a flash message in order to inform him of his connexion.
     *
     * @param Request        $request Request
     * @param TokenInterface $token   Token
     *
     * @return RedirectResponse
     */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token)
    {
        $token = $token;
        $session = $request->getSession();

        // redirect the user to where they were before the login process begun.
        $refererUrl = $session->get('login_redirect');
        if (!empty($refererUrl)) {
            $redirectUrl = $refererUrl;
        } else {
            $redirectUrl = $request->headers->get('Referer');
            if (strpos($redirectUrl, 'login') !== false) {
                $redirectUrl = $this->router->generate('homepage', array(), true);
            }
        }

        $response = new RedirectResponse($redirectUrl);

        // Generate new security token
        $session->set('token', md5(uniqid(rand(), true)));

        return $response;
    }
}
