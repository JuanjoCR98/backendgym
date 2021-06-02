<?php

namespace App\Entity;

use App\Repository\UsuarioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=UsuarioRepository::class)
 */
class Usuario
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $tipo;

    /**
     * @ORM\OneToOne(targetEntity=Socio::class, mappedBy="usuario", cascade={"persist", "remove"})
     */
    private $socio;

    /**
     * @ORM\OneToOne(targetEntity=Empleado::class, mappedBy="usuario", cascade={"persist", "remove"})
     */
    private $empleado;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getTipo(): ?string
    {
        return $this->tipo;
    }

    public function setTipo(string $tipo): self
    {
        $this->tipo = $tipo;

        return $this;
    }

    public function getSocio(): ?Socio
    {
        return $this->socio;
    }

    public function setSocio(?Socio $socio): self
    {
        // unset the owning side of the relation if necessary
        if ($socio === null && $this->socio !== null) {
            $this->socio->setUsuario(null);
        }

        // set the owning side of the relation if necessary
        if ($socio !== null && $socio->getUsuario() !== $this) {
            $socio->setUsuario($this);
        }

        $this->socio = $socio;

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
            $this->empleado->setUsuario(null);
        }

        // set the owning side of the relation if necessary
        if ($empleado !== null && $empleado->getUsuario() !== $this) {
            $empleado->setUsuario($this);
        }

        $this->empleado = $empleado;

        return $this;
    }
}
