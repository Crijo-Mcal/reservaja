<?php

namespace public\api\utility;

class NifValidator
{
    public static function isValid(string $nif): bool
    {
        // 1. Validação de formato: Deve conter exatamente 9 dígitos numéricos
        if (!preg_match('/^\d{9}$/', $nif)) {
            return false;
        }

        // 2. Validação do primeiro dígito (Prefixos oficiais do NIF em Portugal)
        // 1, 2, 3: Pessoas Singulares (Residentes)
        // 45: Pessoas Singulares Não Residentes
        // 5, 6: Pessoas Coletivas / Empresas
        // 7: Organismos da Administração Pública
        // 8: Pessoas Coletivas Não Residentes
        // 9: Condomínios, Sociedades Irregulares, etc.
        $validPrefixes = ['1', '2', '3', '5', '6', '8', '9'];
        $validDoublePrefixes = ['45', '70', '71', '72', '74', '75', '77', '79'];

        $prefix1 = $nif[0];
        $prefix2 = substr($nif, 0, 2);

        if (!in_array($prefix1, $validPrefixes) && !in_array($prefix2, $validDoublePrefixes)) {
            return false;
        }

        // 3. Validação do Algoritmo Check Digit (Módulo 11)
        $sum = 0;
        for ($i = 0; $i < 8; $i++) {
            $sum += (int) $nif[$i] * (9 - $i);
        }

        $checkDigit = 11 - ($sum % 11);

        if ($checkDigit >= 10) {
            $checkDigit = 0;
        }

        // 4. Verificação final: O dígito de controlo calculado deve ser igual ao 9º dígito do NIF
        return $checkDigit === (int) $nif[8];
    }
}