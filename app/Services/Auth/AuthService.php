<?php

namespace App\Services\Auth;

use App\Services\Auth\AuthException;
use App\Entity\UserAuth;
use App\Entity\NotificationAuthToken;
use App\Services\Service;

class AuthService extends Service
{

    public function login($username, $password)
    {
        $user = $this->findUserByUsername($username);
        $this->checkPassword($user, $password);
        return $this->createToken($username);
    }

    public function authorize($token)
    {
        if (empty($token)) {
            throw new AuthException('NOT_AUTHORIZED');
        }

        $this->clearExpired();
        $authToken = $this->findToken($token);
        $user = $this->findUserByToken($authToken);
        $this->updateLastLogged($authToken);
        return $user->getId();
    }

    private function createToken($username)
    {
        $entityManager = $this->DI->get('EntityManager');

        $token = uniqid(); //TODO gen token

        $auth_token = new NotificationAuthToken($username, $token);
        $entityManager->persist($auth_token);
        $entityManager->flush();

        return $token;
    }

    private function findToken($token)
    {
        $authToken = $this->DI->get('EntityManager')->getRepository(NotificationAuthToken::class)->findOneByToken($token);

        if (!$authToken) {
            throw new AuthException('NOT_AUTHORIZED');
        }

        return $authToken;
    }

    private function findUserByUsername($username)
    {
        $user = $this->DI->get('EntityManager')->getRepository(UserAuth::class)->findOneByUsername($username);

        if (!$user) {
            throw new AuthException('NOT_AUTHORIZED');
        }

        return $user;
    }

    private function findUserByToken($authToken)
    {
        $user = $this->DI->get('EntityManager')->getRepository(UserAuth::class)->findOneByUsername($authToken->getUsername());

        if (!$user) {
            throw new AuthException('NOT_AUTHORIZED');
        }

        return $user;
    }

    private function checkPassword($user, $password)
    {
        if (! password_verify($password, $user->getPassword())) {
            throw new AuthException('NOT_AUTHORIZED');
        }
    }

    private function updateLastLogged($authToken)
    {
        $entityManager = $this->DI->get('EntityManager');
        $authToken->updateLastLogged();
        $entityManager->flush();
    }

    private function clearExpired()
    {
        $entityManager = $this->DI->get('EntityManager');
        $authTokenRepository = $entityManager->getRepository(NotificationAuthToken::class);

        $days = intval($_ENV['EXPIRED_DAYS']);
        if (!$days) {
            $days = 3;
        }

        $authTokenRepository->clearExpired($days);
    }
}
