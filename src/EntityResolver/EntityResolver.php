<?php declare(strict_types=1);

namespace App\EntityResolver;

interface EntityResolver
{
    /**
     * @param mixed[] $entity
     * @param mixed[] $extraEntities
     */
    public function reply(array $entity, array $extraEntities = []): ?string;
}
