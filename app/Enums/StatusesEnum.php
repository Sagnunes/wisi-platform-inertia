<?php

namespace App\Enums;

enum StatusesEnum: int
{
    case PENDING = 1;
    case ACTIVE = 2;
    case BLOCKED = 3;

    public function getTranslatedName(): string
    {
        return match ($this) {
            self::PENDING => 'Pendente',
            self::ACTIVE => 'Ativo',
            self::BLOCKED => 'Bloqueado',
        };
    }

    public function fromName(string $name): ?self
    {
        foreach (self::cases() as $case) {
            if ($case->getTranslatedName() === $name) {
                return $case;
            }
        }
        return null;
    }
}
