<?php

namespace App\Entity;

use App\Repository\SocioRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=SocioRepository::class)
 */
class Socio
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
     * @ORM\Column(type="string", length=255)
     */
    private $apellidos;

    /**
     * @ORM\Column(type="date")
     */
    private $fecha_nacimiento;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    /**
     * @ORM\OneToMany(targetEntity=Estadistica::class, mappedBy="socio")
     */
    private $estadisticas;

    /**
     * @ORM\OneToMany(targetEntity=Rutina::class, mappedBy="socio", orphanRemoval=true)
     */
    private $rutinas;

    public function __construct()
    {
        $this->estadisticas = new ArrayCollection();
        $this->rutinas = new ArrayCollection();
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

    public function getApellidos(): ?string
    {
        return $this->apellidos;
    }

    public function setApellidos(string $apellidos): self
    {
        $this->apellidos = $apellidos;

        return $this;
    }

    public function getFechaNacimiento(): ?\DateTimeInterface
    {
        return $this->fecha_nacimiento;
    }

    public function setFechaNacimiento(\DateTimeInterface $fecha_nacimiento): self
    {
        $this->fecha_nacimiento = $fecha_nacimiento;

        return $this;
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

    /**
     * @return Collection|Estadistica[]
     */
    public function getEstadisticas(): Collection
    {
        return $this->estadisticas;
    }

    public function addEstadistica(Estadistica $estadistica): self
    {
        if (!$this->estadisticas->contains($estadistica)) {
            $this->estadisticas[] = $estadistica;
            $estadistica->setSocio($this);
        }

        return $this;
    }

    public function removeEstadistica(Estadistica $estadistica): self
    {
        if ($this->estadisticas->removeElement($estadistica)) {
            // set the owning side to null (unless already changed)
            if ($estadistica->getSocio() === $this) {
                $estadistica->setSocio(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Rutina[]
     */
    public function getRutinas(): Collection
    {
        return $this->rutinas;
    }

    public function addRutina(Rutina $rutina): self
    {
        if (!$this->rutinas->contains($rutina)) {
            $this->rutinas[] = $rutina;
            $rutina->setSocio($this);
        }

        return $this;
    }

    public function removeRutina(Rutina $rutina): self
    {
        if ($this->rutinas->removeElement($rutina)) {
            // set the owning side to null (unless already changed)
            if ($rutina->getSocio() === $this) {
                $rutina->setSocio(null);
            }
        }

        return $this;
    }
}
