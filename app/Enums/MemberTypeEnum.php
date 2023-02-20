<?php

namespace App\Enums;

enum MemberTypeEnum: string
{
    case FULL = 'FULL';
    case SPONSOR = 'SPONSOR';
    case PARTNER = 'PARTNER';
    case ASSOCIATED = 'ASSOCIATED';
    case AGREEMENT = 'AGREEMENT';
    case COLLABORATING = 'COLLABORATING';
    case LOOSE_EXCHANGE = 'LOOSE-EXCHANGE';
    case EUMA_IS_MEMBER_OF = 'EUMA-IS-MEMBER';
    case EUMA_IS_OBSERVER_OF = 'EUMA-IS-OBSERVER';
    case EXTERNAL_MEMBER = 'EXTERNAL-MEMBER';

    public static function getNameValues(): array
    {
        return array_column(MemberTypeEnum::cases(), 'value', 'name');
    }

    public static function getValueNames(): array
    {
        return array_column(MemberTypeEnum::cases(), 'name', 'value');
    }

    public static function getValues(): array
    {
        return array_column(MemberTypeEnum::cases(), 'value');
    }

    public static function getNames(): array
    {
        return array_column(MemberTypeEnum::cases(), 'name');
    }
}