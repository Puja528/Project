<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function index()
    {
        // Cek akses user
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $userId = session('user_id');

        // Ambil transaksi user
        $transactions = Transaction::where('user_id', $userId)
            ->orderBy('date', 'desc')
            ->get();

        // Untuk menampilkan kategori dalam teks rapi
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

        return view('pages.advance.transactions.index', compact('transactions', 'categories'));
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
        // Akses
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        //dd($request->all());

        // Validasi sesuai tabel
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

        return redirect()
            ->route('advance.transactions.index')
            ->with('success', 'Transaksi berhasil ditambahkan!');
    }

    public function edit($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $transaction = Transaction::where('user_id', session('user_id'))->findOrFail($id);

        return view('advance.transactions.edit', compact('transactions'));
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
            'priority' => 'required|in:rendah,sedang,tinggi',
            'date' => 'required|date',
        ], [
            'title.required' => 'Judul wajib diisi.',
            'amount.required' => 'Jumlah wajib diisi.',
            'amount.numeric' => 'Jumlah harus berupa angka.',
            'type.required' => 'Tipe transaksi wajib dipilih.',
            'category.required' => 'Kategori wajib dipilih.',
            'priority.required' => 'Prioritas wajib dipilih.',
            'date.required' => 'Tanggal wajib diisi.',
        ]);
        $transactions = Transaction::where('user_id', session('user_id'))->findOrFail($id);

        return redirect()->route('advance.transactions.index')
            ->with('success', 'Transaksi berhasil diperbarui.');
    }

    public function destroy($id)
    {
        if (!session('logged_in') || session('user_type') !== 'advance') {
            return redirect()->route('login.index')->with('error', 'Akses ditolak.');
        }

        $transactions = Transaction::where('user_id', session('user_id'))->findOrFail($id);
        $transactions->delete();

        return redirect()->route('advance.transactions.index')
            ->with('success', 'Transaksi berhasil dihapus.');
    }
}
