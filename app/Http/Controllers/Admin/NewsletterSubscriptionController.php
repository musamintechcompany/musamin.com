<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscription;
use Illuminate\Http\Request;

class NewsletterSubscriptionController extends Controller
{
    public function index()
    {
        $subscriptions = NewsletterSubscription::with('user')->latest()->paginate(15);
        return view('management.portal.admin.newsletter-subscriptions.index', compact('subscriptions'));
    }

    public function show(NewsletterSubscription $newsletterSubscription)
    {
        $newsletterSubscription->load('user');
        return view('management.portal.admin.newsletter-subscriptions.view', compact('newsletterSubscription'));
    }

    public function destroy(NewsletterSubscription $newsletterSubscription)
    {
        $newsletterSubscription->delete();
        return redirect()->route('admin.newsletter-subscriptions.index')->with('success', 'Newsletter subscription deleted successfully.');
    }

    public function updateStatus(Request $request, NewsletterSubscription $newsletterSubscription)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,unsubscribed'
        ]);

        $newsletterSubscription->update(['status' => $request->status]);

        return redirect()->back()->with('success', 'Subscription status updated successfully.');
    }
}