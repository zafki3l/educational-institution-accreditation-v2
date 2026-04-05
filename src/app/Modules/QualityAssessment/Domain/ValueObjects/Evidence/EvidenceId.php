<?php

namespace App\Modules\QualityAssessment\Domain\ValueObjects\Evidence;

use App\Modules\QualityAssessment\Domain\Exception\Evidence\EvidenceCodeInvalidException;

final class EvidenceId
{
    // Regex pattern: Hn.ab.cd.ef
    // H: fixed letter "H"
    // n: box number (1 or more digits)
    // ab: standard number (2 digits)
    // cd: criteria number (2 digits)
    // ef: evidence number (2 digits)
    private const PATTERN = '/^H\d+\.\d{2}\.\d{2}\.\d{2}$/';

    private function __construct(private string $value) {}

    /**
     * Create evidence code from string
     * 
     * @param string $code Evidence code string (e.g., H1.01.01.01)
     * @return self
     * @throws EvidenceCodeInvalidException
     */
    public static function fromString(string $code): self
    {
        if (!preg_match(self::PATTERN, $code)) {
            throw new EvidenceCodeInvalidException();
        }

        return new self($code);
    }

    public function value(): string
    {
        return $this->value;
    }

    /**
     * Check if evidence code is valid
     * 
     * @param string $code Evidence code string to validate
     * @return bool
     */
    public static function isValid(string $code): bool
    {
        return (bool) preg_match(self::PATTERN, $code);
    }
}
