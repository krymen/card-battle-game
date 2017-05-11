<?php

namespace CardBattleGame\Application\Command;

use Ramsey\Uuid\Uuid;

final class DealCard
{
    private $gameId;
    private $type;
    private $value;
    private $cost;

    public function __construct(Uuid $gameId, string $type, int $value, int $cost)
    {
        $this->gameId = $gameId;
        $this->type = $type;
        $this->value = $value;
        $this->cost = $cost;
    }

    public function gameId(): Uuid
    {
        return $this->gameId;
    }

    public function type(): string
    {
        return $this->type;
    }

    public function value(): int
    {
        return $this->value;
    }

    public function cost(): int
    {
        return $this->cost;
    }
}