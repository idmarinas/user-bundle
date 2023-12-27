<?php

/**
 * This file is part of Bundle "IdmUserBundle".
 *
 * @see https://github.com/idmarinas/user-bundle/
 *
 * @license https://github.com/idmarinas/user-bundle/blob/master/LICENSE.txt
 * @author Iván Diaz Marinas (IDMarinas)
 *
 * @since 1.0.0
 */

namespace Idm\Bundle\User\Model\Traits;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Idm\Bundle\User\Model\AbstractUser;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * https://symfony.com/doc/5.4/security.html#comparing-users-manually-with-equatableinterface.
 */
trait EquatableTrait
{
    #[ORM\Column(type: Types::STRING, length: 45)]
    protected string $sessionId = '';

    public function getSessionId(): string
    {
        return $this->sessionId;
    }

    public function setSessionId(string $sessionId): static
    {
        $this->sessionId = $sessionId;

        return $this;
    }

    /**
     * @param AbstractUser $user
     */
    public function isEqualTo(UserInterface $user): bool
    {
        return ! (
            $this->getPassword()          !== $user->getPassword()
            || $this->getSalt()           !== $user->getSalt()
            || $this->getUserIdentifier() !== $user->getUserIdentifier()
            // -- Solo se permite una sesión en un único dispositivo y firewall
            || $this->getSessionId() !== $user->getSessionId()
        );
    }
}
