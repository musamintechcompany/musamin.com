<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Artisan;

class JobController extends Controller
{
    public function jobs()
    {
        $jobs = DB::table('jobs')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('management.portal.admin.jobs.index', compact('jobs'));
    }

    public function batches()
    {
        $batches = DB::table('job_batches')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('management.portal.admin.jobs.batches', compact('batches'));
    }

    public function failedJobs()
    {
        $failedJobs = DB::table('failed_jobs')
            ->orderBy('failed_at', 'desc')
            ->paginate(20);

        return view('management.portal.admin.jobs.failed', compact('failedJobs'));
    }

    public function retryFailedJobs()
    {
        $failedCount = DB::table('failed_jobs')->count();
        
        if ($failedCount === 0) {
            return redirect()->back()->with('info', 'No failed jobs to retry.');
        }

        try {
            Artisan::call('queue:retry', ['id' => 'all']);
            
            // Check remaining failed jobs after retry
            $remainingFailed = DB::table('failed_jobs')->count();
            $successCount = $failedCount - $remainingFailed;

            if ($remainingFailed === 0) {
                return redirect()->back()->with('success', "All {$successCount} failed jobs successfully retried!");
            } else {
                return redirect()->back()->with('warning', "{$successCount} jobs retried successfully, but {$remainingFailed} jobs still failed.");
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to retry jobs: ' . $e->getMessage());
        }
    }

    public function retryFailedJob($id)
    {
        try {
            Artisan::call('queue:retry', ['id' => $id]);
            
            // Check if job still exists in failed_jobs table
            $stillFailed = DB::table('failed_jobs')->where('id', $id)->exists();
            
            if (!$stillFailed) {
                return redirect()->back()->with('success', 'Job retried successfully!');
            } else {
                return redirect()->back()->with('error', 'Job retry failed.');
            }
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Failed to retry job: ' . $e->getMessage());
        }
    }
}