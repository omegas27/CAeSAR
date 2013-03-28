<?php

namespace Caesar\AdminBundle\Security\Authentication\Provider;

use Caesar\AdminBundle\Security\Authentication\Token\CaesarUserToken;
use Symfony\Component\Security\Core\Authentication\Provider\DaoAuthenticationProvider;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\EncoderFactoryInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;

class CaesarAdminAuthentificationProvider extends DaoAuthenticationProvider {

  public function __construct(UserProviderInterface $userProvider, UserCheckerInterface $userChecker = null, EncoderFactoryInterface $encoderFactory = null, $hideUserNotFoundExceptions = true) {
    parent::__construct($userProvider, $userChecker, "caesar_admin", $encoderFactory, $hideUserNotFoundExceptions);
    $this->userProvider = $userProvider;
    $this->encoderFactory = $encoderFactory;
  }

  protected function checkAuthentication(UserInterface $user, UsernamePasswordToken $token) {

    $user = $this->userProvider->loadUserByUsername($token->getUsername());
    if ($user) {
      if (!in_array('ROLE_USER', $user->getRoles()) && $user->getPassword() != null || $user->getPassword() != "") {
        //check password
        $authenticatedToken = new CaesarUserToken($user->getRoles());
        $authenticatedToken->setUser($user);
        return $authenticatedToken;
      } else {
        //TODO traduction
        throw new AuthenticationException('Un administrateur ne peut accéder ....');
      }
    }

    //TODO traduction
    throw new AuthenticationException('The authentication failed.');
  }

}