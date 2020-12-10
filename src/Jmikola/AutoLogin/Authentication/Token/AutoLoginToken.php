<?php

namespace Jmikola\AutoLogin\Authentication\Token;

use Symfony\Component\Security\Core\Authentication\Token\AbstractToken;

class AutoLoginToken extends AbstractToken
{
    private $key;
    private $providerKey;

    /**
     * Constructor.
     *
     * @param string $providerKey
     * @param string $key
     * @param array  $roles
     *
     * @throws \InvalidArgumentException When $providerKey is empty
     */
    public function __construct(string $providerKey, string $key = null, array $roles = array())
    {
        parent::__construct($roles);

        if (empty($providerKey)) {
            throw new \InvalidArgumentException('$providerKey must not be empty.');
        }

        $this->providerKey = $providerKey;
        $this->key = $key;
    }

    /**
     * @return string|null
     */
    public function getKey() : ?string
    {
        return $this->key;
    }

    /**
     * @return string
     */
    public function getProviderKey() : string
    {
        return $this->providerKey;
    }

    /**
     * @see Symfony\Component\Security\Core\Authentication\Token\TokenInterface::getCredentials()
     */
    public function getCredentials() : string
    {
        return '';
    }

    /**
     * @see Symfony\Component\Security\Core\Authentication\Token\AbstractToken::__serialize()
     */
    public function __serialize(): array
    {
        return array(
            $this->key,
            $this->providerKey,
            parent::__serialize(),
        );
    }

    /**
     * @see Symfony\Component\Security\Core\Authentication\Token\AbstractToken::__unserialize()
     */
    public function __unserialize(array $data): void
    {
        [$this->key, $this->providerKey, $parentData] = $data;
        parent::__unserialize($parentData);
    }
}
