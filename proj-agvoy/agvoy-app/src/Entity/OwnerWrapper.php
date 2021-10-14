<?php

namespace App\Entity;

class OwnerWrapper
{

    private $ownsRoom;

    public function __construct(){}

    public function setOwnsRoom(bool $value): self
    {
        $this->ownsRoom = $value;
        return $this;
    }

    public function isOwnsRoom(): bool
    {
        return $this->ownsRoom;
    }

}