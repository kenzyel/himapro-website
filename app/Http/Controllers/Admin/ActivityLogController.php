<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ActivityLogController extends Controller
{
    public function index(Request $request): View
    {
        $query = ActivityLog::with('user');

        if ($request->filled('search')) {
            $search = (string) $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('description', 'like', "%{$search}%")
                    ->orWhere('action', 'like', "%{$search}%")
                    ->orWhere('module', 'like', "%{$search}%");
            });
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->integer('user_id'));
        }

        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }

        if ($request->filled('module')) {
            $query->where('module', $request->input('module'));
        }

        if ($request->filled('from')) {
            $query->whereDate('created_at', '>=', $request->input('from'));
        }

        if ($request->filled('to')) {
            $query->whereDate('created_at', '<=', $request->input('to'));
        }

        $logs = $query->latest('created_at')->paginate(20)->withQueryString();

        // Statistik
        $stats = [
            'total' => ActivityLog::count(),
            'today' => ActivityLog::whereDate('created_at', today())->count(),
            'created' => ActivityLog::where('action', 'created')->count(),
            'updated' => ActivityLog::where('action', 'updated')->count(),
            'deleted' => ActivityLog::where('action', 'deleted')->count(),
        ];

        $users = User::orderBy('name')->get();

        $actions = ActivityLog::query()
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        $modules = ActivityLog::query()
            ->whereNotNull('module')
            ->distinct()
            ->orderBy('module')
            ->pluck('module');

        return view('admin.activity-logs.index', compact(
            'logs',
            'stats',
            'users',
            'actions',
            'modules'
        ));
    }

    public function show(ActivityLog $activityLog): View
    {
        $activityLog->load('user');

        return view('admin.activity-logs.show', [
            'log' => $activityLog,
        ]);
    }
}