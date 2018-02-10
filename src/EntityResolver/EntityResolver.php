<?php declare(strict_types=1);

namespace App\EntityResolver;

interface EntityResolver
{
    /**
     * @param mixed[] $extraEntities
     */
    public function reply(?string $value = null, array $extraEntities = []): string;
}
