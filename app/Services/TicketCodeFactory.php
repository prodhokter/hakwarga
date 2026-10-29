<?php

declare(strict_types=1);

namespace App\Services;

class TicketCodeFactory
{
    protected string $alphabet;

    protected string $regex;

    public function __construct()
    {
        /** @var string $alphabet */
        $alphabet = config('hakwarga.codes.alphabet', '23456789ABCDEFGHJKMNPQRSTVWXYZ');
        $this->alphabet = $alphabet;

        /** @var string $regex */
        $regex = config('hakwarga.codes.ticket_regex', '/^HWT-\d{4}-[A-Z0-9]{6}$/');
        $this->regex = $regex;
    }

    public function makeTicketCode(?int $year = null): string
    {
        $yearCode = $year ?? (int) date('Y');

        $random = '';
        $maxIndex = strlen($this->alphabet) - 1;

        for ($i = 0; $i < 6; $i++) {
            $random .= $this->alphabet[random_int(0, $maxIndex)];
        }

        return sprintf('HWT-%d-%s', $yearCode, $random);
    }

    public function isValidTicketCode(string $code): bool
    {
        return (bool) preg_match($this->regex, strtoupper(trim($code)));
    }

    public function makeSecretCode(): string
    {
        $maxIndex = strlen($this->alphabet) - 1;
        $segments = [];

        for ($s = 0; $s < 3; $s++) {
            $chunk = '';
            for ($i = 0; $i < 4; $i++) {
                $chunk .= $this->alphabet[random_int(0, $maxIndex)];
            }
            $segments[] = $chunk;
        }

        return implode('-', $segments);
    }

    public function hashSecret(string $secret): string
    {
        $normalized = strtoupper(str_replace(['-', ' '], '', trim($secret)));

        return hash('sha256', $normalized);
    }

    public function verifySecret(string $inputSecret, string $storedHash): bool
    {
        return hash_equals($storedHash, $this->hashSecret($inputSecret));
    }
}
