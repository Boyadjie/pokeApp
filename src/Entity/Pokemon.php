<?php

namespace App\Entity;

use App\Repository\PokemonRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PokemonRepository::class)]
class Pokemon
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $pokeId = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?int $weight = null;

    #[ORM\Column]
    private ?int $pokeOrder = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $types = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $stats = [];

    #[ORM\Column(type: Types::ARRAY)]
    private array $species = [];

    #[ORM\Column]
    private ?int $base_experience = null;

    #[ORM\Column(length: 300, nullable: true)]
    private ?string $img = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPokeId(): ?int
    {
        return $this->pokeId;
    }

    public function setPokeId(int $pokeId): self
    {
        $this->pokeId = $pokeId;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getWeight(): ?int
    {
        return $this->weight;
    }

    public function setWeight(int $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getPokeOrder(): ?int
    {
        return $this->pokeOrder;
    }

    public function setPokeOrder(int $pokeOrder): self
    {
        $this->pokeOrder = $pokeOrder;

        return $this;
    }

    public function getTypes(): array
    {
        return $this->types;
    }

    public function setTypes(array $types): self
    {
        $this->types = $types;

        return $this;
    }

    public function getStats(): array
    {
        return $this->stats;
    }

    public function setStats(array $stats): self
    {
        $this->stats = $stats;

        return $this;
    }

    public function getSpecies(): array
    {
        return $this->species;
    }

    public function setSpecies(array $species): self
    {
        $this->species = $species;

        return $this;
    }

    public function getBaseExperience(): ?int
    {
        return $this->base_experience;
    }

    public function setBaseExperience(int $base_experience): self
    {
        $this->base_experience = $base_experience;

        return $this;
    }

    public function getImg(): ?string
    {
        return $this->img;
    }

    public function setImg(?string $img): self
    {
        $this->img = $img;

        return $this;
    }
}
