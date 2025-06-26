<?php

namespace App\Enums;

enum RolesEnum: int
{
    case ADMIN = 1;

    public function getTranslatedName(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrador',
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
