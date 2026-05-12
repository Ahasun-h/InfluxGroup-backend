<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanySetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $info = CompanySetting::get('company_info', [
            'name' => 'Influx Group',
            'tagline' => 'Leaders in Energy & Infrastructure',
            'description' => 'Powering Bangladesh since 1980.',
            'email' => 'info@influxgroup.com',
            'phone' => '+880 1234 567890',
            'address' => 'Dhaka, Bangladesh',
        ]);
        
        return view('admin.settings.index', compact('info'));
    }

    public function update(Request $request)
    {
        CompanySetting::set('company_info', $request->except('_token'));
        
        return redirect()->back()->with('success', 'Company information updated successfully.');
    }
}
