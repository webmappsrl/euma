<?php

namespace App\Enums;

enum TrailUserTypes: string
{
    case TRAIL_RUNNERS = 'trail runners';
    case MOUNTAIN_BIKERS = 'mountain bikers';
    case HORSE_RIDERS = 'horse riders';
    case MOTORCYCLIST = 'motorcyclist';
    case E_BIKERS = 'e-bikers';
    case QUAD_DRIVERS = 'quad drivers';
    case OTHERS = 'others';
}
