<?php

namespace App\Entity;

use App\Repository\TeamRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

use function PHPUnit\Framework\throwException;

#[ORM\Entity(repositoryClass: TeamRepository::class)]
class Team
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::ARRAY)]
    private array $list = [];

    #[ORM\Column]
    private ?int $userId = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getList(): array
    {
        return $this->list;
    }

    public function setList(array $list): self
    {
        if (count($list) >= 0 && count($list) <= 6) {
            $this->list = $list;
        }

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function addPokemonIdToList($pokemonId): self
    {
        if (count($this->list) >= 0 && count($this->list) < 6) {
            array_push($this->list, $pokemonId);
        }
        return $this;
    }

    public function removePokemonIdFromTeam($id): self
    {
        unset($this->list[$id]);
        return $this;
    }
}
