<?php

namespace App\Enums;

enum CategoriaOperacaoEnum: string
{
    case Entrada = 'entrada';
    case Saida = 'saida';

    public static function values(): array
    {
        return array_column(self::cases(), 'name', 'value');
    }
}