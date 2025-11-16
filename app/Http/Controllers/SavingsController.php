<?php
// app/Http/Controllers/SavingsController.php

namespace App\Http\Controllers;

use App\Models\Saving;
use Illuminate\Http\Request;
use Carbon\Carbon;

class SavingsController extends Controller
{
    public function index()
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $savings = Saving::latest()->get();

        // Calculate summary
        $totalTarget = $savings->sum('target_amount');
        $totalCurrent = $savings->sum('current_amount');
        $totalProgress = $totalTarget > 0 ? ($totalCurrent / $totalTarget) * 100 : 0;

        return view('pages.savings.index', [
            'savings' => $savings,
            'totalTarget' => $totalTarget,
            'totalCurrent' => $totalCurrent,
            'totalProgress' => $totalProgress
        ]);
    }

    public function create()
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $icons = $this->getIcons();
        $colors = $this->getColors();

        return view('pages.savings.create', compact('icons', 'colors'));
    }

    public function store(Request $request)
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'required|numeric|min:0',
            'target_date' => 'required|date|after:today',
            'description' => 'nullable|string',
            'color' => 'nullable|string',
            'icon' => 'nullable|string'
        ]);

        Saving::create([
            'name' => $validated['name'],
            'target_amount' => $validated['target_amount'],
            'current_amount' => $validated['current_amount'],
            'target_date' => $validated['target_date'],
            'description' => $validated['description'],
            'color' => $validated['color'] ?? '#3B82F6',
            'icon' => $validated['icon'] ?? 'piggy-bank',
            'status' => 'active'
        ]);

        return redirect()->route('savings.index')->with('success', 'Target tabungan berhasil ditambahkan!');
    }

    public function show($id)
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $saving = Saving::findOrFail($id);

        return view('pages.savings.show', compact('saving'));
    }

    public function edit($id)
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $saving = Saving::findOrFail($id);
        $icons = $this->getIcons();
        $colors = $this->getColors();

        return view('pages.savings.edit', compact('saving', 'icons', 'colors'));
    }

    public function update(Request $request, $id)
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $saving = Saving::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'required|numeric|min:0',
            'target_date' => 'required|date',
            'description' => 'nullable|string',
            'status' => 'required|in:active,completed,cancelled',
            'color' => 'nullable|string',
            'icon' => 'nullable|string'
        ]);

        $saving->update($validated);

        return redirect()->route('savings.show', $saving->id)->with('success', 'Target tabungan berhasil diperbarui!');
    }

    public function destroy($id)
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $saving = Saving::findOrFail($id);
        $saving->delete();

        return redirect()->route('savings.index')->with('success', 'Target tabungan berhasil dihapus!');
    }

    // Method untuk menambah jumlah tabungan
    public function addAmount(Request $request, $id)
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $saving = Saving::findOrFail($id);

        $validated = $request->validate([
            'amount' => 'required|numeric|min:0'
        ]);

        $saving->addAmount($validated['amount']);

        return redirect()->route('savings.show', $saving->id)->with('success', 'Jumlah tabungan berhasil ditambahkan!');
    }

    // Method untuk menandai sebagai selesai
    public function markAsCompleted($id)
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $saving = Saving::findOrFail($id);
        $saving->update([
            'status' => 'completed',
            'current_amount' => $saving->target_amount
        ]);

        return redirect()->route('savings.show', $saving->id)->with('success', 'Tabungan berhasil ditandai sebagai selesai!');
    }

    // Method untuk menandai sebagai dibatalkan
    public function markAsCancelled($id)
    {
        if (!session('logged_in')) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        $saving = Saving::findOrFail($id);
        $saving->update(['status' => 'cancelled']);

        return redirect()->route('savings.show', $saving->id)->with('success', 'Tabungan berhasil ditandai sebagai dibatalkan!');
    }

    // Helper methods untuk icons dan colors
    private function getIcons()
    {
        return [
            'piggy-bank' => 'Celengan',
            'home' => 'Rumah',
            'car' => 'Mobil',
            'graduation-cap' => 'Pendidikan',
            'umbrella-beach' => 'Liburan',
            'heart' => 'Kesehatan',
            'gift' => 'Hadiah',
            'briefcase' => 'Bisnis',
            'shopping-bag' => 'Belanja',
            'plane' => 'Perjalanan'
        ];
    }

    private function getColors()
    {
        return [
            '#3B82F6' => 'Biru',
            '#EF4444' => 'Merah',
            '#10B981' => 'Hijau',
            '#F59E0B' => 'Kuning',
            '#8B5CF6' => 'Ungu',
            '#EC4899' => 'Pink',
            '#06B6D4' => 'Cyan',
            '#84CC16' => 'Lime',
            '#F97316' => 'Orange',
            '#6366F1' => 'Indigo'
        ];
    }
}
