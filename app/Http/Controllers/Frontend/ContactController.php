<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ContactRequest;
use App\Models\LandingSection;
use App\Models\Pesan;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function index(): View
    {
        $section = LandingSection::get('contact_page');

        abort_unless($section && $section->is_active, 404);

        return view('frontend.contact.index', compact('section'));
    }

    public function store(ContactRequest $request): RedirectResponse
    {
        $data = $request->validated();

        $data['status'] = 'unread';

        Pesan::create($data);

        return redirect()
            ->route('frontend.contact')
            ->with('contact_success', 'Terima kasih! Pesan Anda telah kami terima. Kami akan segera menghubungi Anda.');
    }
}