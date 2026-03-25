<?php

class FormatHelper
{
    public static function bytes(int $b): string
    {
        if ($b >= 1024 * 1024) return number_format($b / 1024 / 1024, 2) . ' Mo';
        if ($b >= 1024)        return number_format($b / 1024, 2) . ' Ko';
        return $b . ' o';
    }

    public static function hex(int $v): string
    {
        return '#' . strtoupper(str_pad(dechex($v), 2, '0', STR_PAD_LEFT));
    }

    public static function sectorCssClass(array $s): string
    {
        if ($s['isWeak'] && $s['isErased'] && !$s['isUsed']) return 'weak-erased-empty';
        if ($s['isWeak'] && $s['isErased'])                  return 'weak-erased';
        if ($s['isWeak'] && !$s['isUsed'])                   return 'weak-empty';
        if ($s['isWeak'])                                     return 'weak';
        if ($s['isIncomplete'])                               return 'incomplete';
        if ($s['isErased'] && !$s['isUsed'])                 return 'erased-empty';
        if ($s['isErased'])                                   return 'erased-used';
        if ($s['isUsed'])                                     return 'normal-used';
        return 'normal-empty';
    }

    public static function sectorTooltip(array $s): string
    {
        $size   = 128 << $s['N'];
        $status = $s['isUsed'] ? 'utilisé' : 'vide';
        $extra  = [];
        if ($s['isWeak'])       $extra[] = 'WEAK';
        if ($s['isErased'])     $extra[] = 'ERASED';
        if ($s['isIncomplete']) $extra[] = 'INCOMPLET';
        $flags  = $extra ? ' [' . implode('+', $extra) . ']' : '';
        return 'T' . $s['track'] . ' Secteur ' . self::hex($s['R']) . ' — ' . $size . ' o [' . $status . ']' . $flags;
    }

    public static function fdcBinary(int $v): string
    {
        return str_pad(decbin($v), 8, '0', STR_PAD_LEFT);
    }

    public static function badge(bool $condition, string $labelYes, string $classYes, string $labelNo = '-'): string
    {
        if ($condition) {
            return '<span class="badge badge-' . $classYes . '">' . $labelYes . '</span>';
        }
        return '<span class="badge badge-no">' . $labelNo . '</span>';
    }
}
