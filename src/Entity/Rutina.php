<?php

namespace App\Entity;

use App\Repository\RutinaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=RutinaRepository::class)
 */
class Rutina
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
     * @ORM\Column(type="date")
     */
    private $fecha_creacion;

    /**
     * @ORM\OneToMany(targetEntity=EjerciciosRutina::class, mappedBy="rutina", orphanRemoval=true)
     */
    private $ejerciciosRutina;

    /**
     * @ORM\ManyToOne(targetEntity=Socio::class, inversedBy="rutinas")
     * @ORM\JoinColumn(nullable=false)
     */
    private $socio;

    public function __construct()
    {
        $this->ejerciciosRutina = new ArrayCollection();
    }

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

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fecha_creacion): self
    {
        $this->fecha_creacion = $fecha_creacion;

        return $this;
    }

    /**
     * @return Collection|EjerciciosRutina[]
     */
    public function getEjerciciosRutina(): Collection
    {
        return $this->ejerciciosRutina;
    }

    public function addEjerciciosRutina(EjerciciosRutina $ejerciciosRutina): self
    {
        if (!$this->ejerciciosRutina->contains($ejerciciosRutina)) {
            $this->ejerciciosRutina[] = $ejerciciosRutina;
            $ejerciciosRutina->setRutina($this);
        }

        return $this;
    }

    public function removeEjerciciosRutina(EjerciciosRutina $ejerciciosRutina): self
    {
        if ($this->ejerciciosRutina->removeElement($ejerciciosRutina)) {
            // set the owning side to null (unless already changed)
            if ($ejerciciosRutina->getRutina() === $this) {
                $ejerciciosRutina->setRutina(null);
            }
        }

        return $this;
    }

    public function getSocio(): ?Socio
    {
        return $this->socio;
    }

    public function setSocio(?Socio $socio): self
    {
        $this->socio = $socio;

        return $this;
    }
}
