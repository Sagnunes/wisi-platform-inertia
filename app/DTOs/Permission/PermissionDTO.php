<?php

declare(strict_types=1);

namespace App\DTOs\Permission;

use App\Models\Permission;
use Illuminate\Support\Str;

final readonly class PermissionDTO
{
    public function __construct(
        public string  $name,
        public string  $slug,
        public ?int    $id = null,
        public ?string $created_at = null,
        public ?string $updated_at = null,
    ) {}

    public static function fromRequest(array $data): self
    {
        return new self(
            name: $data['name'],
            slug: Str::slug($data['name']),
        );
    }

    public static function fromModel(Permission $permission): self
    {
        return new self(
            name: $permission->name,
            slug: $permission->slug,
            id: $permission->id,
            created_at: $permission->created_at?->format('Y-m-d'),
            updated_at: $permission->updated_at?->format('Y-m-d'),
        );
    }
}
