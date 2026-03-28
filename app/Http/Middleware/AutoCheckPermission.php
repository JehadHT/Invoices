<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AutoCheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $routeName = $request->route()->getName();

        $permissions = [
            'roles.index' => 'عرض صلاحية',
            'roles.create' => 'اضافة صلاحية',
            'roles.store' => 'اضافة صلاحية',
            'roles.show' => 'عرض صلاحية',
            'roles.edit' => 'تعديل صلاحية',
            'roles.update' => 'تعديل صلاحية',
            'roles.destroy' => 'حذف صلاحية',
            // أضف المزيد حسب الحاجة
        ];

        if (isset($permissions[$routeName]) && !$request->user() || !$request->user()->can($permissions[$routeName])) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }
}