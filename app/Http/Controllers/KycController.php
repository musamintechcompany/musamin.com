<?php

namespace App\Http\Controllers;

use App\Models\KycVerification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KycController extends Controller
{
    /**
     * Show KYC identity verification form
     */
    public function identity()
    {
        $user = auth()->user();
        
        // Redirect if KYC is already approved
        if ($user->kyc_status === 'approved') {
            return redirect()->route('settings.kyc')->with('error', 'Your KYC is already verified.');
        }
        
        return view('settings.kyc.identity', compact('user'));
    }

    /**
     * Store KYC verification data
     */
    public function store(Request $request)
    {
        $user = $request->user();
        $existingKyc = KycVerification::where('user_id', $user->id)->first();
        
        // Dynamic validation rules based on existing KYC
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'date_of_birth' => 'required|date|before:today',
            'phone' => 'required|string|max:20',
            'street_address' => 'required|string|max:500',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'postal_code' => 'required|string|max:20',
            'country' => 'required|string|max:100',
            'id_type' => 'required|in:passport,drivers_license,national_id,voter_id',
            'id_number' => 'required|string|max:100',
            'utility_type' => 'required|in:electricity,water,gas,internet,phone,bank_statement',
        ];
        
        // File validation - required only if no existing files
        $rules['id_document'] = ($existingKyc && $existingKyc->id_document_path) 
            ? 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
            : 'required|file|mimes:jpg,jpeg,png,pdf|max:5120';
            
        $rules['selfie_video'] = ($existingKyc && $existingKyc->selfie_video_path) 
            ? 'nullable|file|max:10240'
            : 'required|file|max:10240';
            
        $rules['utility_bill'] = ($existingKyc && $existingKyc->utility_bill_path) 
            ? 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120'
            : 'required|file|mimes:jpg,jpeg,png,pdf|max:5120';
        
        $validated = $request->validate($rules);

        try {
            $user = $request->user();

            // Check if user already has approved KYC
            if ($user->kyc_status === 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'Your KYC is already approved'
                ], 422);
            }

            // Get existing KYC or create new one
            $kycVerification = KycVerification::where('user_id', $user->id)->first();
            
            // Handle file uploads - only upload if new files provided
            $idDocumentPath = null;
            $selfieVideoPath = null;
            $utilityBillPath = null;
            
            if ($request->hasFile('id_document')) {
                $idDocumentPath = $request->file('id_document')->store('kyc/documents', 'public');
                // Delete old file if exists
                if ($kycVerification && $kycVerification->id_document_path) {
                    Storage::disk('public')->delete($kycVerification->id_document_path);
                }
            } else if ($kycVerification) {
                $idDocumentPath = $kycVerification->id_document_path;
            }
            
            if ($request->hasFile('selfie_video')) {
                $selfieVideoPath = $request->file('selfie_video')->store('kyc/videos', 'public');
                // Delete old file if exists
                if ($kycVerification && $kycVerification->selfie_video_path) {
                    Storage::disk('public')->delete($kycVerification->selfie_video_path);
                }
            } else if ($kycVerification) {
                $selfieVideoPath = $kycVerification->selfie_video_path;
            }
            
            if ($request->hasFile('utility_bill')) {
                $utilityBillPath = $request->file('utility_bill')->store('kyc/utility-bills', 'public');
                // Delete old file if exists
                if ($kycVerification && $kycVerification->utility_bill_path) {
                    Storage::disk('public')->delete($kycVerification->utility_bill_path);
                }
            } else if ($kycVerification) {
                $utilityBillPath = $kycVerification->utility_bill_path;
            }

            $kycData = [
                'user_id' => $user->id,
                'first_name' => $validated['first_name'],
                'last_name' => $validated['last_name'],
                'date_of_birth' => $validated['date_of_birth'],
                'phone' => $validated['phone'],
                'street_address' => $validated['street_address'],
                'city' => $validated['city'],
                'state' => $validated['state'],
                'postal_code' => $validated['postal_code'],
                'country' => $validated['country'],
                'id_type' => $validated['id_type'],
                'id_number' => $validated['id_number'],
                'id_document_path' => $idDocumentPath,
                'selfie_video_path' => $selfieVideoPath,
                'utility_type' => $validated['utility_type'],
                'utility_bill_path' => $utilityBillPath,
                'status' => 'pending',
                'submitted_at' => now(),
            ];

            // Create or update KYC verification record
            if ($kycVerification) {
                $kycVerification->update($kycData);
            } else {
                $kycVerification = KycVerification::create($kycData);
            }

            // Update user KYC status
            $user->update(['kyc_status' => 'pending']);

            return response()->json([
                'success' => true,
                'message' => 'KYC application submitted successfully! We will review your documents within 2-3 business days.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error submitting KYC application: ' . $e->getMessage()
            ], 500);
        }
    }
}