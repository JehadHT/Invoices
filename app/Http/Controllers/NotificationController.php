<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\invoices;
use App\Models\invoices_details;
class NotificationController extends Controller
{
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();

        return redirect()->back()->with('success', 'تم تعليم جميع الإشعارات كمقروءة');
    }
    public function MarkAsRead($id,$da)
    {
        Auth::user()->unreadNotifications->find($id)->markAsRead();

        $inv= invoices::where('id', $da)->first();
        $invoices = invoices_details::where('id_Invoice', $da)->get();
        return view('Invoices.invoices_details', compact('invoices', 'inv'));
    }
}
