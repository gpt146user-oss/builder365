<?php

namespace App\Http\Controllers\Builder360;

use App\Application\Dashboard\Actions\ShowRoleDashboard;
use App\Application\Dashboard\Data\DashboardContextData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Builder360\DashboardRequest;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(DashboardRequest $request, ShowRoleDashboard $action): View
    {
        $page = $action->execute($request->user(), DashboardContextData::fromRequest($request));

        return view('builder360.classic.dashboard', [
            'page' => $page,
        ]);
    }
}
