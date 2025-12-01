<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PriorityMatrixController extends Controller
{
    public function index()
    {
        // Data Business Priority Matrix
        $matrixData = [
            'pentingMendesak' => [
                [
                    'id' => 1,
                    'nama' => 'Bayar Gaji Karyawan',
                    'jumlah' => 'Rp 8,500,000',
                    'tenggat_waktu' => '2024-01-25',
                    'status' => 'Pending',
                    'deskripsi' => 'Pembayaran gaji bulanan untuk seluruh karyawan',
                    'prioritas' => 'Tinggi',
                    'kategori' => 'Operasional'
                ],
                [
                    'id' => 2,
                    'nama' => 'Pajak Bulanan',
                    'jumlah' => 'Rp 3,750,000',
                    'tenggat_waktu' => '2024-01-30',
                    'status' => 'Pending',
                    'deskripsi' => 'Pembayaran pajak bulanan perusahaan',
                    'prioritas' => 'Tinggi',
                    'kategori' => 'Pajak'
                ]
            ],
            'mendesakTidakPenting' => [
                [
                    'id' => 3,
                    'nama' => 'Team Building',
                    'jumlah' => 'Rp 3,500,000',
                    'tenggat_waktu' => '2024-01-20',
                    'status' => 'Direncanakan',
                    'deskripsi' => 'Kegiatan team building untuk meningkatkan kohesivitas tim',
                    'prioritas' => 'Sedang',
                    'kategori' => 'SDM'
                ]
            ],
            'pentingTidakMendesak' => [
                [
                    'id' => 4,
                    'nama' => 'Investasi Peralatan',
                    'jumlah' => 'Rp 15,000,000',
                    'tenggat_waktu' => '2024-03-28',
                    'status' => 'Direncanakan',
                    'deskripsi' => 'Pembelian peralatan baru untuk meningkatkan produktivitas',
                    'prioritas' => 'Sedang',
                    'kategori' => 'Investasi'
                ],
                [
                    'id' => 5,
                    'nama' => 'Dana Ekspansi',
                    'jumlah' => 'Rp 50,000,000',
                    'tenggat_waktu' => '2024-06-30',
                    'status' => 'Direncanakan',
                    'deskripsi' => 'Dana untuk ekspansi bisnis ke wilayah baru',
                    'prioritas' => 'Rendah',
                    'kategori' => 'Ekspansi'
                ]
            ],
            'tidakMendesakTidakPenting' => [
                [
                    'id' => 6,
                    'nama' => 'Renovasi Kantor',
                    'jumlah' => 'Rp 25,000,000',
                    'tenggat_waktu' => 'Belum ditentukan',
                    'status' => 'Ide',
                    'deskripsi' => 'Renovasi kantor untuk meningkatkan kenyamanan kerja',
                    'prioritas' => 'Rendah',
                    'kategori' => 'Infrastruktur'
                ]
            ]
        ];

        return view('pages.advance.priority-matrix', compact('matrixData'));
    }

    public function show($id)
    {
        // Data yang sama seperti di index
        $allItems = [
            [
                'id' => 1,
                'nama' => 'Bayar Gaji Karyawan',
                'jumlah' => 'Rp 8,500,000',
                'tenggat_waktu' => '2024-01-25',
                'status' => 'Pending',
                'deskripsi' => 'Pembayaran gaji bulanan untuk seluruh karyawan',
                'prioritas' => 'Tinggi',
                'kategori' => 'Operasional',
                'kuadran' => 'Penting & Mendesak'
            ],
            [
                'id' => 2,
                'nama' => 'Pajak Bulanan',
                'jumlah' => 'Rp 3,750,000',
                'tenggat_waktu' => '2024-01-30',
                'status' => 'Pending',
                'deskripsi' => 'Pembayaran pajak bulanan perusahaan',
                'prioritas' => 'Tinggi',
                'kategori' => 'Pajak',
                'kuadran' => 'Penting & Mendesak'
            ],
            [
                'id' => 3,
                'nama' => 'Team Building',
                'jumlah' => 'Rp 3,500,000',
                'tenggat_waktu' => '2024-01-20',
                'status' => 'Direncanakan',
                'deskripsi' => 'Kegiatan team building untuk meningkatkan kohesivitas tim',
                'prioritas' => 'Sedang',
                'kategori' => 'SDM',
                'kuadran' => 'Mendesak & Tidak Penting'
            ],
            [
                'id' => 4,
                'nama' => 'Investasi Peralatan',
                'jumlah' => 'Rp 15,000,000',
                'tenggat_waktu' => '2024-03-28',
                'status' => 'Direncanakan',
                'deskripsi' => 'Pembelian peralatan baru untuk meningkatkan produktivitas',
                'prioritas' => 'Sedang',
                'kategori' => 'Investasi',
                'kuadran' => 'Penting & Tidak Mendesak'
            ],
            [
                'id' => 5,
                'nama' => 'Dana Ekspansi',
                'jumlah' => 'Rp 50,000,000',
                'tenggat_waktu' => '2024-06-30',
                'status' => 'Direncanakan',
                'deskripsi' => 'Dana untuk ekspansi bisnis ke wilayah baru',
                'prioritas' => 'Rendah',
                'kategori' => 'Ekspansi',
                'kuadran' => 'Penting & Tidak Mendesak'
            ],
            [
                'id' => 6,
                'nama' => 'Renovasi Kantor',
                'jumlah' => 'Rp 25,000,000',
                'tenggat_waktu' => 'Belum ditentukan',
                'status' => 'Ide',
                'deskripsi' => 'Renovasi kantor untuk meningkatkan kenyamanan kerja',
                'prioritas' => 'Rendah',
                'kategori' => 'Infrastruktur',
                'kuadran' => 'Tidak Mendesak & Tidak Penting'
            ]
        ];

        $item = collect($allItems)->firstWhere('id', $id);

        if (!$item) {
            abort(404);
        }

        return view('pages.advance.priority-matrix-detail', compact('item'));
    }
}
