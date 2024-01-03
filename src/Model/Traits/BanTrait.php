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

use DateTime;
use DateTimeInterface;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

trait BanTrait
{
    /** Fecha hasta la que no puede entrar con su cuenta */
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    protected ?DateTimeInterface $bannedUntil = null;

    public function getBannedUntil(): ?DateTimeInterface
    {
        return $this->bannedUntil;
    }

    public function setBannedUntil(?DateTimeInterface $bannedUntil): static
    {
        $this->bannedUntil = $bannedUntil;

        return $this;
    }

    /**
     * Obtiene si el usuario está bloqueado.
     */
    public function isBanned(): bool
    {
        if (
            ! $this->bannedUntil instanceof DateTimeInterface
            || '-0001-11-30' == $this->bannedUntil->format('Y-m-d')
        ) {
            return false;
        }

        return $this->bannedUntil > (new DateTime('now'));
    }
}
