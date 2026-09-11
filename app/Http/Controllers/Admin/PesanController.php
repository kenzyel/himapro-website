<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pesan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PesanController extends Controller
{
    /**
     * Menampilkan daftar pesan.
     */
    public function index(Request $request): View
    {
        $query = Pesan::query();

        if ($request->filled('search')) {
            $search = (string) $request->input('search');

            $query->where(function ($q) use ($search) {
                $q->where('nama', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subjek', 'like', "%{$search}%")
                    ->orWhere('pesan', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $pesans = $query->latest()->paginate(15)->withQueryString();

        $stats = [
            'total' => Pesan::count(),
            'unread' => Pesan::where('status', 'unread')->count(),
            'read' => Pesan::where('status', 'read')->count(),
            'replied' => Pesan::where('status', 'replied')->count(),
        ];

        return view('admin.pesan.index', compact('pesans', 'stats'));
    }

    /**
     * Menampilkan detail pesan.
     */
    public function show(Pesan $pesan): View
    {
        // Tandai sebagai "read" otomatis jika masih "unread"
        if ($pesan->status === 'unread') {
            $pesan->update([
                'status' => 'read',
                'dibaca_at' => now(),
            ]);
        }

        return view('admin.pesan.show', compact('pesan'));
    }

    /**
     * Menghapus pesan.
     */
    public function destroy(Pesan $pesan): RedirectResponse
    {
        $pesan->delete();

        return redirect()
            ->route('admin.pesan.index')
            ->with('success', 'Pesan berhasil dihapus.');
    }

    /**
     * Update status pesan.
     */
    public function updateStatus(Request $request, Pesan $pesan): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:unread,read,replied,archived',
        ]);

        $data = ['status' => $validated['status']];

        if ($validated['status'] === 'replied' && ! $pesan->dibalas_at) {
            $data['dibalas_at'] = now();
        }

        if ($validated['status'] === 'read' && ! $pesan->dibaca_at) {
            $data['dibaca_at'] = now();
        }

        $pesan->update($data);

        return back()->with('success', 'Status pesan berhasil diperbarui.');
    }

    /**
     * Tandai semua pesan sebagai sudah dibaca.
     */
    public function markAllRead(): RedirectResponse
    {
        Pesan::where('status', 'unread')->update([
            'status' => 'read',
            'dibaca_at' => now(),
        ]);

        return back()->with('success', 'Semua pesan ditandai sudah dibaca.');
    }
}