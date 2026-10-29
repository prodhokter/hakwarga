<?php

declare(strict_types=1);

namespace App\Services;

class ReceiptCodeFactory
{
    protected string $alphabet;

    protected string $regex;

    public function __construct()
    {
        /** @var string $alphabet */
        $alphabet = config('hakwarga.codes.alphabet', '23456789ABCDEFGHJKMNPQRSTVWXYZ');
        $this->alphabet = $alphabet;

        /** @var string $regex */
        $regex = config('hakwarga.codes.receipt_regex', '/^HWR-[A-Z]{3,5}-\d{4}-[A-Z0-9]{6}$/');
        $this->regex = $regex;
    }

    public function make(string $programCode, ?string $period = null): string
    {
        $program = strtoupper(trim($programCode));
        $periodCode = $period ?? date('ym');

        $random = '';
        $maxIndex = strlen($this->alphabet) - 1;

        for ($i = 0; $i < 6; $i++) {
            $random .= $this->alphabet[random_int(0, $maxIndex)];
        }

        return sprintf('HWR-%s-%s-%s', $program, $periodCode, $random);
    }

    public function isValid(string $code): bool
    {
        return (bool) preg_match($this->regex, strtoupper(trim($code)));
    }
}
