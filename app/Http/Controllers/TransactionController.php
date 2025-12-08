<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $userId = session('user_id');

        // GANTI: get() menjadi paginate(10) untuk menampilkan 10 data per halaman
        $transactions = Transaction::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->paginate(10);

        // Hitung kategori prioritas (Eisenhower Matrix)
        $counts = [
            'urgent_important'         => Transaction::where('user_id', $userId)->where('priority', 'tinggi')->count(),
            'not_urgent_important'     => Transaction::where('user_id', $userId)->where('priority', 'sedang')->count(),
            'urgent_not_important'     => Transaction::where('user_id', $userId)->where('priority', 'rendah')->count(),
            'not_urgent_not_important' => Transaction::where('user_id', $userId)->where('priority', 'tidak_penting')->count(),
        ];

        // Kategori untuk tampilan teks
        $categories = [
            'makanan' => 'Makanan',
            'transportasi' => 'Transportasi',
            'hiburan' => 'Hiburan',
            'kesehatan' => 'Kesehatan',
            'pendidikan' => 'Pendidikan',
            'belanja' => 'Belanja',
            'tagihan' => 'Tagihan',
            'lainnya' => 'Lainnya',
        ];

        return view('pages.advance.transactions.index', compact('transactions', 'categories', 'counts'));
    }

    public function create()
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        return view('pages.advance.transactions.create');
    }

    public function store(Request $request)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'title' => 'required',
            'amount' => 'required|numeric',
            'type' => 'required',
            'category' => 'required',
            'priority' => 'required',
            'date' => 'required|date',
        ]);

        Transaction::create([
            'title' => $request->title,
            'amount' => $request->amount,
            'type' => $request->type,
            'category' => $request->category,
            'priority' => $request->priority,
            'date' => $request->date,
            'user_id' => session('user_id'),
        ]);

        return redirect()->route('advance.transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $transaction = Transaction::where('user_id', session('user_id'))->findOrFail($id);

        return view('pages.advance.transactions.edit', compact('transaction'));
    }

    public function update(Request $request, $id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'type' => 'required|in:pemasukan,pengeluaran',
            'category' => 'required|string|max:255',
            'priority' => 'required|in:rendah,sedang,tinggi,tidak_penting', // TAMBAH: tidak_penting
            'date' => 'required|date',
        ]);

        $transaction = Transaction::where('user_id', session('user_id'))->findOrFail($id);

        $transaction->update([
            'title' => $request->title,
            'amount' => $request->amount,
            'type' => $request->type,
            'category' => $request->category,
            'priority' => $request->priority,
            'date' => $request->date,
        ]);

        return redirect()->route('advance.transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $transaction = Transaction::where('user_id', session('user_id'))->findOrFail($id);
        $transaction->delete();

        return redirect()->route('advance.transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
