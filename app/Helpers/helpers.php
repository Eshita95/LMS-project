<?php

use Illuminate\Support\Facades\Auth;

function permission_check($permission)
{

    if (!Auth::user()->hasPermissionTo($permission)) {
        flash()->addwarning('You are not authorized to access this page');

        return redirect()->back();
    }
}
