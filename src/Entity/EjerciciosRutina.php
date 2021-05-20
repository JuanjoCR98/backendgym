<?php

namespace App\Entity;

use App\Repository\EjerciciosRutinaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EjerciciosRutinaRepository::class)
 */
class EjerciciosRutina
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $tiempo;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $series;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $repeticiones;

    /**
     * @ORM\ManyToOne(targetEntity=Rutina::class, inversedBy="ejerciciosRutina")
     * @ORM\JoinColumn(nullable=false)
     */
    private $rutina;

    /**
     * @ORM\ManyToOne(targetEntity=Ejercicio::class, inversedBy="ejerciciosRutina")
     * @ORM\JoinColumn(nullable=false)
     */
    private $ejercicio;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTiempo(): ?float
    {
        return $this->tiempo;
    }

    public function setTiempo(?float $tiempo): self
    {
        $this->tiempo = $tiempo;

        return $this;
    }

    public function getSeries(): ?int
    {
        return $this->series;
    }

    public function setSeries(?int $series): self
    {
        $this->series = $series;

        return $this;
    }

    public function getRepeticiones(): ?int
    {
        return $this->repeticiones;
    }

    public function setRepeticiones(?int $repeticiones): self
    {
        $this->repeticiones = $repeticiones;

        return $this;
    }

    public function getRutina(): ?Rutina
    {
        return $this->rutina;
    }

    public function setRutina(?Rutina $rutina): self
    {
        $this->rutina = $rutina;

        return $this;
    }

    public function getEjercicio(): ?Ejercicio
    {
        return $this->ejercicio;
    }

    public function setEjercicio(?Ejercicio $ejercicio): self
    {
        $this->ejercicio = $ejercicio;

        return $this;
    }
}
