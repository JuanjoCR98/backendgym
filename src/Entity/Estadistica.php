<?php

namespace App\Entity;

use App\Repository\EstadisticaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=EstadisticaRepository::class)
 */
class Estadistica
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
    private $peso;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $altura;

    /**
     * @ORM\Column(type="float", nullable=true)
     */
    private $imc;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPeso(): ?float
    {
        return $this->peso;
    }

    public function setPeso(?float $peso): self
    {
        $this->peso = $peso;

        return $this;
    }

    public function getAltura(): ?float
    {
        return $this->altura;
    }

    public function setAltura(?float $altura): self
    {
        $this->altura = $altura;

        return $this;
    }

    public function getImc(): ?float
    {
        return $this->imc;
    }

    public function setImc(?float $imc): self
    {
        $this->imc = $imc;

        return $this;
    }
}
