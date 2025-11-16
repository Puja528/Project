<?php
// app/Http/Controllers/ProdukController.php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Produk::latest()->get();
        return view('pages.produk.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategories = $this->getKategories();
        $satuans = $this->getSatuans();
        return view('pages.produk.create', compact('kategories', 'satuans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string',
            'satuan' => 'required|string',
            'barcode' => 'nullable|string|unique:produks,barcode',
            'status' => 'boolean'
        ]);

        // Convert to float untuk memastikan tipe data
        $data = $request->all();
        $data['harga'] = (float) $data['harga'];
        $data['status'] = $data['status'] ?? true;

        Produk::create($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Produk $produk)
    {
        return view('pages.produk.show', compact('produk'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $kategories = $this->getKategories();
        $satuans = $this->getSatuans();
        return view('pages.produk.edit', compact('produk', 'kategories', 'satuans'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'harga' => 'required|numeric|min:0',
            'stok' => 'required|integer|min:0',
            'kategori' => 'required|string',
            'satuan' => 'required|string',
            'barcode' => 'nullable|string|unique:produks,barcode,' . $produk->id,
            'status' => 'boolean'
        ]);

        $data = $request->all();
        $data['harga'] = (float) $data['harga'];
        $data['status'] = $data['status'] ?? true;

        $produk->update($data);

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();
        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus!');
    }

    /**
     * Get list of categories
     */
    private function getKategories()
    {
        return [
            'elektronik' => 'Elektronik',
            'pakaian' => 'Pakaian',
            'makanan' => 'Makanan',
            'minuman' => 'Minuman',
            'kesehatan' => 'Kesehatan & Kecantikan',
            'rumah-tangga' => 'Rumah Tangga',
            'olahraga' => 'Olahraga',
            'mainan' => 'Mainan & Hobi',
            'buku' => 'Buku & Alat Tulis',
            'lainnya' => 'Lainnya'
        ];
    }

    /**
     * Get list of units
     */
    private function getSatuans()
    {
        return [
            'pcs' => 'Pcs',
            'kg' => 'Kilogram',
            'gram' => 'Gram',
            'liter' => 'Liter',
            'ml' => 'Mililiter',
            'dus' => 'Dus',
            'pak' => 'Pak',
            'unit' => 'Unit',
            'lusin' => 'Lusin'
        ];
    }
}
