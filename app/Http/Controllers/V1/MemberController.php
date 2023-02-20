<?php

namespace App\Http\Controllers\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Member;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Artisan;

class MemberController extends Controller
{
    
    /**
     * Return an array of member api based on the type as parameter. Otherwise returns all members
     *
     * @param int $updated_at
     *
     * @return array
     */
    public function membercollection( string $type = null ) {
        $list = [];

        if ($type) {
            $members = Member::where('type', '=', strtoupper($type))->orderBy('name_en')->get();
        } else {
            $members = Member::orderBy('name_en')->get();
        }

        if (count($members) > 0) {
            foreach ($members as $member) {
                array_push($list, $member->getJson());
            }
        } else {
            array_push($list, 'No member where fount. type: '.$type);
        }
        return $list;
    }
}
