<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;

class AdminRegistrationController extends Controller
{
    public function allRegistrations()
    {
        $registrations = Registration::with('user', 'event')->get();
        return view('admin.registrations', compact('registrations'));
    }
}
