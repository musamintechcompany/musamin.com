<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function general()
    {
        $settings = Setting::getSettings();
        return view('management.portal.admin.settings.general', compact('settings'));
    }

    public function sms()
    {
        $settings = Setting::getSettings();
        return view('management.portal.admin.settings.sms', compact('settings'));
    }

    public function finance()
    {
        $settings = Setting::getSettings();
        return view('management.portal.admin.settings.finance', compact('settings'));
    }

    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'app_name' => 'required|string|max:255',
            'email_verification_required' => 'boolean',
            'sms_enabled' => 'boolean',
            'hide_admin_registration' => 'boolean',
            'terms_privacy_required' => 'boolean',
            'profile_information_required' => 'boolean',
            'password_change_required' => 'boolean',
            'browser_sessions_required' => 'boolean',
            'two_factor_auth_required' => 'boolean',
            'account_deletion_required' => 'boolean',
            'kyc_enabled' => 'boolean',
            'ideas_enabled' => 'boolean',
            'inbox_enabled' => 'boolean',
            'live_chat_support_enabled' => 'boolean',
            'request_callback_enabled' => 'boolean',
            'faq_enabled' => 'boolean',
            'help_center_enabled' => 'boolean',
            'whatsapp_enabled' => 'boolean',
        ]);

        $settings = Setting::getSettings();
        $settings->update($validated);

        return redirect()->back()->with('success', 'General settings updated successfully!');
    }

    public function updateSms(Request $request)
    {
        $validated = $request->validate([
            'twilio_sid' => 'nullable|string',
            'twilio_token' => 'nullable|string',
            'twilio_from' => 'nullable|string',
            'sms_provider' => 'nullable|string',
        ]);

        $settings = Setting::getSettings();
        $settings->update($validated);

        return redirect()->back()->with('success', 'SMS settings updated successfully!');
    }

    public function updateFinance(Request $request)
    {
        $validated = $request->validate([
            'purchase_fee_type' => 'required|in:percentage,fixed',
            'purchase_fee' => 'required|numeric|min:0',
            'withdrawal_fee_type' => 'required|in:percent,fixed',
            'withdrawal_fee' => 'required|numeric|min:0',
            'usd_to_coins_rate' => 'required|numeric|min:0',
            'affiliate_monthly_fee' => 'required|numeric|min:0',
            'affiliate_yearly_fee' => 'required|numeric|min:0',
            'minimum_withdrawal_amount' => 'required|numeric|min:0',
        ]);

        $settings = Setting::getSettings();
        $settings->update($validated);

        return redirect()->back()->with('success', 'Financial settings updated successfully!');
    }
}