<?php

namespace followed\framed\Authentication;

use followed\framed\Session\SessionInterface;

class SessionAuthentication implements  SessionAuthInterface
{
    private AuthUserInterface $user;

    public function __construct(private AuthRepositoryInterface $authRepository, private SessionInterface $session)
    {

    }
    public function authenticate(string $username, string $password): bool
    {
        $user = $this->authRepository->findByUsername($username);

        if (!$user) {
            return false;
        }

        if (password_verify($password, $user->getPassword())) {
            $this->login($user);
            return true;
        }

        return false;
    }

    public function login(AuthUserInterface $user)
    {
        // Start a session
        $this->session->start();
        // Log the user in
        $this->session->set("auth_id",$user->getAuthId());
        // Set the user
        $this->user = $user;
    }

    public function logout()
    {
        // TODO: Implement logout() method.
    }

    public function getUser(): AuthUserInterface
    {
        return $this->user;
    }

}