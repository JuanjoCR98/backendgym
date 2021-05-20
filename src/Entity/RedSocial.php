<?php

namespace App\Entity;

use App\Repository\RedSocialRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RedSocialRepository::class)
 */
class RedSocial
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $facebook;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $instagram;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $twitter;

    /**
     * @ORM\OneToOne(targetEntity=Empleado::class, mappedBy="redes_sociales", cascade={"persist", "remove"})
     */
    private $empleado;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFacebook(): ?string
    {
        return $this->facebook;
    }

    public function setFacebook(?string $facebook): self
    {
        $this->facebook = $facebook;

        return $this;
    }

    public function getInstagram(): ?string
    {
        return $this->instagram;
    }

    public function setInstagram(?string $instagram): self
    {
        $this->instagram = $instagram;

        return $this;
    }

    public function getTwitter(): ?string
    {
        return $this->twitter;
    }

    public function setTwitter(?string $twitter): self
    {
        $this->twitter = $twitter;

        return $this;
    }

    public function getEmpleado(): ?Empleado
    {
        return $this->empleado;
    }

    public function setEmpleado(?Empleado $empleado): self
    {
        // unset the owning side of the relation if necessary
        if ($empleado === null && $this->empleado !== null) {
            $this->empleado->setRedesSociales(null);
        }

        // set the owning side of the relation if necessary
        if ($empleado !== null && $empleado->getRedesSociales() !== $this) {
            $empleado->setRedesSociales($this);
        }

        $this->empleado = $empleado;

        return $this;
    }
}
