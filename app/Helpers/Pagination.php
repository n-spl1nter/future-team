<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class Pagination
{
    public static function resolvePerPageCount(Request $request, int $pageDefault = 20, int $pageMax = 50): int
    {
        $perPage = $request->get('perPage', $pageDefault);

        return $perPage > $pageMax ? $pageDefault : $perPage;
    }
}
