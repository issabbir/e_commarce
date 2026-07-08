<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class CompanyScope implements Scope
{
    public function apply(Builder $builder, Model $model)
    {
        // Avoid infinite recursion when resolving the authenticated user/admin
        if ($model instanceof \App\Models\User || $model instanceof \App\Models\Admin) {
            return;
        }

        if (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();
            if ($user && $user->company_id) {
                $builder->where($model->getTable() . '.company_id', $user->company_id);
            }
        }
    }
}
