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

trait LegalTrait
{
    /*Indica si se ha aceptado la Política de Privacidad.*/
    #[ORM\Column(type: Types::BOOLEAN)]
    protected bool $privacyAccepted = false;

    /*Indica si se ha aceptado los términos y condiciones.*/
    #[ORM\Column(type: Types::BOOLEAN)]
    protected bool $termsAccepted = false;

    public function getPrivacyAccepted(): bool
    {
        return $this->privacyAccepted;
    }

    public function setPrivacyAccepted(bool $privacyAccepted): self
    {
        $this->privacyAccepted = $privacyAccepted;

        return $this;
    }

    public function getTermsAccepted(): bool
    {
        return $this->termsAccepted;
    }

    public function setTermsAccepted(bool $termsAccepted): self
    {
        $this->termsAccepted = $termsAccepted;

        return $this;
    }
}
