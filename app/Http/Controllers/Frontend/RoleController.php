<?php

/*
 * This file is part of the Qsnh/meedu.
 *
 * (c) XiaoTeng <616896861@qq.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace App\Http\Controllers\Frontend;

use App\Models\Role;
use App\Repositories\RoleRepository;
use Illuminate\Support\Facades\Auth;

class RoleController extends FrontendController
{
    public function index()
    {
        $roles = Role::orderByDesc('weight')->get();
        ['title' => $title, 'keywords' => $keywords, 'description' => $description] = config('meedu.seo.role_list');

        return view('frontend.role.index', compact('roles', 'title', 'keywords', 'description'));
    }

    public function showBuyPage($id)
    {
        $role = Role::findOrFail($id);
        $title = sprintf('购买VIP《%s》', $role->name);

        return view('frontend.role.buy', compact('role', 'title'));
    }

    public function buyHandler(RoleRepository $repository, $id)
    {
        $role = Role::findOrFail($id);
        $user = Auth::user();

        if (! $repository->bulHandler($user, $role)) {
            flash($repository->errors, 'error');

            return back();
        }

        flash('购买成功', 'success');

        return redirect(route('member'));
    }
}
