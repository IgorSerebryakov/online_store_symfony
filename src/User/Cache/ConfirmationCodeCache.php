<?php

namespace App\User\Cache;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class ConfirmationCodeCache
{
    public function __construct(private CacheInterface $confirmationCodesCache)
    {
    }

    public function save(string $userId, int $code): void
    {
        $this->confirmationCodesCache->get(
            "user_$userId",
            function (ItemInterface $item) use ($code) {
                $item->expiresAfter(60);
                return $code;
            }
        );
    }

    public function get(string $userId): ?int
    {
        return $this->confirmationCodesCache->get("user_$userId", function() {
            return null;
        });
    }

    public function delete(string $userId): void
    {
        $this->confirmationCodesCache->delete("user_$userId");
    }
}