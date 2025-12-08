<?php

namespace App\Http\Controllers;

use App\Models\Saving;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SavingsController extends Controller
{
    public function index(Request $request)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login.index')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Query dasar
        $query = Saving::where('user_id', $userId);

        // Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status') && $request->status != '') {
            if ($request->status === 'completed') {
                $query->whereRaw('current_amount >= target_amount');
            } elseif ($request->status === 'in_progress') {
                $query->whereRaw('current_amount < target_amount')
                      ->where('target_date', '>=', now()->format('Y-m-d'));
            } elseif ($request->status === 'overdue') {
                $query->whereRaw('current_amount < target_amount')
                      ->where('target_date', '<', now()->format('Y-m-d'));
            }
        }

        // Order dan get data
        $savings = $query->orderBy('target_date', 'asc')->get();

        // Hitung statistik berdasarkan filter yang sama
        $totalTarget = (clone $query)->sum('target_amount');
        $totalCurrent = (clone $query)->sum('current_amount');
        $averageProgress = $totalTarget > 0 ? ($totalCurrent / $totalTarget) * 100 : 0;

        return view('pages.standard.savings.index', [
            'savings' => $savings,
            'totalTarget' => $totalTarget,
            'totalCurrent' => $totalCurrent,
            'averageProgress' => $averageProgress,
            'filters' => $request->all()
        ]);
    }
    public function create()
    {
        return view('pages.standard.savings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'required|numeric|min:0',
            'target_date' => 'required|date|after:today',
            'description' => 'nullable|string'
        ]);

        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login.index')->with('error', 'Sesi tidak valid. Silakan login kembali.');
        }

        try {
            DB::beginTransaction();

            Saving::create([
                'user_id' => $userId,
                'name' => $validated['name'],
                'target_amount' => $validated['target_amount'],
                'current_amount' => $validated['current_amount'],
                'target_date' => $validated['target_date'],
                'description' => $validated['description']
            ]);

            DB::commit();

            return redirect()->route('standard.savings.index')
                ->with('success', 'Target tabungan berhasil ditambahkan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('standard.savings.create')
                ->with('error', 'Gagal menambahkan target tabungan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function edit($id)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login.index')->with('error', 'Sesi tidak valid. Silakan login kembali.');
        }

        $saving = Saving::where('user_id', $userId)->find($id);

        if (!$saving) {
            return redirect()->route('standard.savings.index')
                ->with('error', 'Target tabungan tidak ditemukan.');
        }

        return view('pages.standard.savings.edit', compact('saving'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'target_amount' => 'required|numeric|min:0',
            'current_amount' => 'required|numeric|min:0',
            'target_date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login.index')->with('error', 'Sesi tidak valid. Silakan login kembali.');
        }

        $saving = Saving::where('user_id', $userId)->find($id);

        if (!$saving) {
            return redirect()->route('standard.savings.index')
                ->with('error', 'Target tabungan tidak ditemukan.');
        }

        try {
            DB::beginTransaction();

            $saving->update($validated);

            DB::commit();

            return redirect()->route('standard.savings.index')
                ->with('success', 'Target tabungan berhasil diperbarui!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('standard.savings.edit', $id)
                ->with('error', 'Gagal memperbarui target tabungan: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        $userId = session('user_id');

        if (!$userId) {
            return redirect()->route('login.index')->with('error', 'Sesi tidak valid. Silakan login kembali.');
        }

        $saving = Saving::where('user_id', $userId)->find($id);

        if (!$saving) {
            return redirect()->route('standard.savings.index')
                ->with('error', 'Target tabungan tidak ditemukan.');
        }

        try {
            DB::beginTransaction();

            $saving->delete();

            DB::commit();

            return redirect()->route('standard.savings.index')
                ->with('success', 'Target tabungan berhasil dihapus!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('standard.savings.index')
                ->with('error', 'Gagal menghapus target tabungan: ' . $e->getMessage());
        }
    }
}
