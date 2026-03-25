<?php

class CsrfService
{
    public function init(): void
    {
        if (empty($_SESSION[CSRF_TOKEN_NAME])) {
            $this->renew();
        }
    }

    public function getToken(): string
    {
        return $_SESSION[CSRF_TOKEN_NAME] ?? '';
    }

    public function verify(string $submitted): bool
    {
        return hash_equals($this->getToken(), $submitted);
    }

    public function renew(): void
    {
        $_SESSION[CSRF_TOKEN_NAME] = bin2hex(random_bytes(32));
    }
}
