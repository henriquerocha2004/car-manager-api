<?php

namespace App\Support\Document;

use Exception;

class ValidateCPFCNPJ
{
    private string $document;
    private const DIGITS_CPF = 11;
    private const DIGITS_CPNJ = 14;
    private const FACTOR_DIGIT_1 = 10;
    private const FACTOR_DIGIT_2 = 11;
    private const CPF = 'CPF';
    private const CNPJ = 'CNPJ';

    /**
     * @throws Exception
     */
    public function __construct(string $value)
    {
        $this->document = $this->validate($value);
    }

    public function getValue(): string
    {
        return $this->document;
    }

    /**
     * @throws Exception
     */
    private function validate(string $document): string
    {
        if (empty($document)) {
            throw new Exception("value for document cpf/cnpj is empty");
        }

        $document = $this->clean($document);
        $typeDocument = $this->isCPFOrCPNJ($document);

        if ($this->hasAllDigitsEqual($document)) {
            throw new Exception("all digits from cpf/cnpj are equals");
        }

        if ($typeDocument == self::CPF) {
            if (!$this->validateCPF($document)) {
                throw new Exception("Invalid CPF");
            }
            return $document;
        }

        if ($typeDocument == self::CNPJ) {
            if (!$this->validateCNPJ($document)) {
                throw new Exception("Invalid CNPJ");
            }
            return $document;
        }

        throw new Exception("Invalid Cpf/Cnpj");
    }

    private function clean(string $document): string
    {
        return preg_replace('/[\.\-\/]/', "", $document);
    }

    /**
     * @throws Exception
     */
    private function isCPFOrCPNJ(string $document): ?string
    {
        if (strlen($document) == self::DIGITS_CPF) {
            return self::CPF;
        }

        if (strlen($document) == self::DIGITS_CPNJ) {
            return self::CNPJ;
        }

        throw new Exception("invalid value for cpf or cnpj");
    }

    private function hasAllDigitsEqual(string $document): bool
    {
        $firstDigit = $document[0];
        $allEquals = true;

        foreach (str_split($document) as $digit) {
            if ($digit != $firstDigit) {
                $allEquals = false;
            }

            $firstDigit = $digit;
        }

        return $allEquals;
    }

    private function validateCPF(string $document): bool
    {
        $digit1 = $this->calculateCheckDigit($document, self::FACTOR_DIGIT_1, self::CPF);
        $digit2 = $this->calculateCheckDigit($document, self::FACTOR_DIGIT_2, self::CPF);
        $digitCPF = $this->extractDigit($document);
        $calculatedDigit = "{$digit1}{$digit2}";
        return $digitCPF == $calculatedDigit;
    }

    private function calculateCheckDigit(string $document, int $factor, string $typeDocument): int
    {
        $total = 0;
        $digits = str_split($document);

        foreach ($digits as $digit) {
            if ($factor > 1) {
                $total += intval($digit) * $factor--;
            }
            if ($typeDocument == self::CNPJ && $factor < 2) {
                $factor = 9;
            }
        }

        $rest = $total % 11;
        return ($rest < 2) ? 0 : (11 - $rest);
    }

    private function extractDigit(string $document): string
    {
        return substr($document, -2);
    }

    private function validateCNPJ(string $document): bool
    {
        $firstTwelveDigits = substr($document, 0, 12);
        $digit1 = $this->calculateCheckDigit($firstTwelveDigits, 5, self::CNPJ);
        $digits = "{$firstTwelveDigits}{$digit1}";
        $digit2 = $this->calculateCheckDigit($digits, 6, self::CNPJ);
        $checkDigit = $this->extractDigit($document);
        $calculatedDigit = "{$digit1}{$digit2}";
        return $checkDigit == $calculatedDigit;
    }
}
