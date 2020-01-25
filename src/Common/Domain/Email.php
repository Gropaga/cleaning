<?php


namespace CleaningCRM\Common\Domain;

use DomainException;

class Email
{
    private $email;

    public function __construct(string $email)
    {
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (false === $email) {
            throw new DomainException($email  . ' not a valid email address');
        }
        $this->email = $email;
    }

    public static function createEmpty(): self
    {
        return new self('email@domain.com');
    }

    public function email(): string
    {
        return $this->email;
    }

    public function equals(Email $email): bool
    {
        return $this->email === $email->email();
    }
}
