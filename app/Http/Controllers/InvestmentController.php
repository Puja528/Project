<?php

namespace App\Http\Controllers;

use App\Models\Investment;
use Illuminate\Http\Request;

class InvestmentController extends Controller
{
    public function index()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $userId = session('user_id');

        // Ganti all() menjadi paginate(10) dengan filter user
        $investments = Investment::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        // HITUNG SUMMARY SECARA MANUAL (karena kolom return_percentage belum ada)
        $allInvestments = Investment::where('user_id', $userId)->get();

        $totalInitial = $allInvestments->sum('initial_amount');
        $totalCurrent = $allInvestments->sum('current_value');
        $totalReturn = $totalCurrent - $totalInitial;

        // Hitung avg return secara manual
        $avgReturn = 0;
        if ($allInvestments->count() > 0) {
            $totalReturnPercent = 0;
            $countWithInitialAmount = 0;

            foreach ($allInvestments as $investment) {
                if ($investment->initial_amount > 0) {
                    $returnPercent = (($investment->current_value - $investment->initial_amount) / $investment->initial_amount) * 100;
                    $totalReturnPercent += $returnPercent;
                    $countWithInitialAmount++;
                }
            }

            if ($countWithInitialAmount > 0) {
                $avgReturn = $totalReturnPercent / $countWithInitialAmount;
            }
        }

        $totalSummary = [
            'total_initial' => $totalInitial,
            'total_current' => $totalCurrent,
            'total_return' => $totalReturn,
            'avg_return' => number_format($avgReturn, 1),
        ];

        // Tambahkan return_percentage ke setiap investment untuk display
        $investments->getCollection()->transform(function ($investment) {
            if ($investment->initial_amount > 0) {
                $investment->return_percentage =
                    (($investment->current_value - $investment->initial_amount) / $investment->initial_amount) * 100;
            } else {
                $investment->return_percentage = 0;
            }
            return $investment;
        });

        return view('pages.advance.investments.index', compact('investments', 'totalSummary'));
    }

    public function create()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $types = [
            'saham',
            'reksadana',
            'deposito',
            'obligasi',
            'emas',
            'property',
            'lainnya'
        ];

        return view('pages.advance.investments.create', compact('types'));
    }

    public function store(Request $request)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'risk_level' => 'required|in:low,medium,high',
            'initial_amount' => 'required|numeric|min:0',
            'current_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
        ]);

        // Hitung return percentage
        $initialAmount = $request->initial_amount;
        $currentValue = $request->current_value;
        $returnPercentage = 0;

        if ($initialAmount > 0) {
            $returnPercentage = (($currentValue - $initialAmount) / $initialAmount) * 100;
        }

        Investment::create([
            'name' => $request->name,
            'type' => $request->type,
            'risk_level' => $request->risk_level,
            'initial_amount' => $initialAmount,
            'current_value' => $currentValue,
            'start_date' => $request->start_date,
            'user_id' => session('user_id'),
        ]);

        return redirect()->route('advance.investments.index')
            ->with('success', 'Investasi berhasil ditambahkan!');
    }

    // Di controller show method
    public function edit($id)
    {
        $investment = Investment::findOrFail($id);
        return view('pages.advance.investments.edit', compact('investment'));
    }

    // Di controller update method
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'type' => 'required',
            'risk_level' => 'required|in:low,medium,high',
            'initial_amount' => 'required|numeric|min:0',
            'current_value' => 'required|numeric|min:0',
            'start_date' => 'required|date',
            // return_percentage = accessor → jangan divalidasi
        ]);

        // Jangan update field yang tidak ada di database
        unset($validated['return_percentage']);

        $investment = Investment::findOrFail($id);
        $investment->update($validated);

        return redirect()->route('advance.investments.index')
            ->with('success', 'Investasi berhasil diperbarui!');
    }



    public function destroy($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $investment = Investment::where('user_id', session('user_id'))->findOrFail($id);
        $investment->delete();

        return redirect()->route('advance.investments.index')
            ->with('success', 'Investasi berhasil dihapus!');
    }
}
