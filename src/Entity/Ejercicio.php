<?php

namespace App\Entity;

use App\Repository\EjercicioRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EjercicioRepository::class)
 */
class Ejercicio
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
    private $nombre;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $ejecucion;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $foto;

    /**
     * @ORM\ManyToOne(targetEntity=TipoEjercicio::class, inversedBy="ejercicios")
     * @ORM\JoinColumn(nullable=false)
     */
    private $tipoEjercicio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getEjecucion(): ?string
    {
        return $this->ejecucion;
    }

    public function setEjecucion(?string $ejecucion): self
    {
        $this->ejecucion = $ejecucion;

        return $this;
    }

    public function getFoto(): ?string
    {
        return $this->foto;
    }

    public function setFoto(?string $foto): self
    {
        $this->foto = $foto;

        return $this;
    }

    public function getTipoEjercicio(): ?TipoEjercicio
    {
        return $this->tipoEjercicio;
    }

    public function setTipoEjercicio(?TipoEjercicio $tipoEjercicio): self
    {
        $this->tipoEjercicio = $tipoEjercicio;

        return $this;
    }
}
