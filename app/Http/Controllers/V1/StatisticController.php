<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TrailCollection;
use App\Models\Trail;
use App\Models\Hut;
use App\Models\ClimbingRockArea;
use App\Models\Member;
use App\Traits\ControllerTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class StatisticController extends Controller
{
    use ControllerTrait;

    /**
     * Return an array of statistics from EUMA DB.
     *
     * @return array
     */
    public function eumadbstatistics() {
        $list = [];

        $list['individual_members'] = Member::sum('members');
        $list['members'] = Member::all()->count();
        $list['trails'] = Trail::all()->count();
        $list['huts'] = Hut::all()->count();
        $list['climbingrockareas'] = ClimbingRockArea::all()->count();

        return $list;
    }
}
