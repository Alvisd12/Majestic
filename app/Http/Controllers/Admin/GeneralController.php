<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\General;
use Illuminate\Http\Request;

class GeneralController extends Controller
{
    public function index()
    {
        $general = General::getSingle();
        return view('admin.general.index', compact('general'));
    }

    public function edit()
    {
        $general = General::getSingle();
        return view('admin.general.edit', compact('general'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'persyaratan' => 'required|string',
            'jam_operasional' => 'required|string|max:255',
            'lokasi' => 'required|string',
            'syarat_ketentuan' => 'required|string'
        ]);

        General::updateOrCreateSingle($request->all());

        return redirect()->route('admin.general.index')
                        ->with('success', 'Pengaturan umum berhasil diperbarui.');
    }
}
