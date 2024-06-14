<?php

namespace App\Http\Controllers;

use GuzzleHttp\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ToApiKosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index_kos(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $url = "http://localhost:8000/api/kos";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];

        if ($request->has('keyword')) {
            $keyword = $request->keyword;
            $data = array_filter($data, function ($item) use ($keyword) {
                return stripos($item['nama'], $keyword) !== false ||
                    stripos($item['deskripsi'], $keyword) !== false ||
                    stripos($item['lokasi'], $keyword) !== false;
            });
        }

        if ($request->ajax()) {
            return view('partials.search-results', ['data' => $data])->render();
        }

        return view('search', ['data' => $data]);
    }
    public function index_kos_login(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $url = "http://localhost:8000/api/kos";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];

        if ($request->has('keyword')) {
            $keyword = $request->keyword;
            $data = array_filter($data, function ($item) use ($keyword) {
                return stripos($item['nama'], $keyword) !== false ||
                    stripos($item['deskripsi'], $keyword) !== false ||
                    stripos($item['lokasi'], $keyword) !== false;
            });
        }

        if ($request->ajax()) {
            return view('partials.search-results', ['data' => $data])->render();
        }

        return view('search-login', ['data' => $data]);
    }
    public function produk_kos(Request $request)
    {
        $client = new \GuzzleHttp\Client();
        $url = "http://localhost:8000/api/kos";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $contentArray = json_decode($content, true);
        $data = $contentArray['data'];

        if ($request->has('keyword')) {
            $keyword = $request->keyword;
            $data = array_filter($data, function ($item) use ($keyword) {
                return stripos($item['nama'], $keyword) !== false ||
                    stripos($item['deskripsi'], $keyword) !== false ||
                    stripos($item['lokasi'], $keyword) !== false;
            });
        }

        if ($request->ajax()) {
            return view('partials.search-results', ['data' => $data])->render();
        }

        return view('produk-kos', ['data' => $data]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $nama_kost = $request->nama;
        $deskripsi = $request->deskripsi;
        $lokasi = $request->lokasi;
        $harga = $request->harga;

        $validator = Validator::make($request->all(), [
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'lokasi' => 'required',
            'gambar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Ambil file gambar dari request
        $gambar = $request->file('gambar');

        // Simpan gambar sementara di storage laravel
        $gambarPath = $gambar->store('public/kos');

        // Ubah path ke URL yang bisa diakses
        $gambarUrl = asset('storage/' . str_replace('public/', '', $gambarPath));

        // Buat array untuk dikirimkan sebagai body request
        $data = [
            'nama' => $nama_kost,
            'deskripsi' => $deskripsi,
            'lokasi' => $lokasi,
            'harga' => $harga,
            'gambar_url' => $gambarUrl, // kirimkan URL gambar untuk disimpan di database
        ];

        // Kirim request ke API menggunakan Guzzle HTTP Client
        $client = new Client();
        $url = "http://localhost:8000/api/kos";

        try {
            $response = $client->post($url, [
                'multipart' => [
                    [
                        'name' => 'nama',
                        'contents' => $data['nama']
                    ],
                    [
                        'name' => 'deskripsi',
                        'contents' => $data['deskripsi']
                    ],
                    [
                        'name' => 'lokasi',
                        'contents' => $data['lokasi']
                    ],
                    [
                        'name' => 'harga',
                        'contents' => $data['harga']
                    ],
                    [
                        'name' => 'gambar',
                        'contents' => fopen($gambar->getPathname(), 'r'), // membuka gambar untuk dikirim
                        'filename' => $gambar->getClientOriginalName(),
                    ],
                ],
            ]);

            $content = $response->getBody()->getContents();
            $contentArray = json_decode($content, true);

            if ($contentArray['status']) {
                return redirect()->route('beranda')->with('success', 'Data berhasil ditambahkan');
            } else {
                return redirect()->route('beranda')->withErrors($contentArray['data'])->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->route('beranda')->with('error', 'Gagal memproses data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $client = new \GuzzleHttp\Client();
        $url = "http://localhost:8000/api/kos/{$id}";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $item = json_decode($content, true)['data'];

        return view('detail', ['item' => $item]);
    }
    public function show_login(string $id)
    {
        $client = new \GuzzleHttp\Client();
        $url = "http://localhost:8000/api/kos/{$id}";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $item = json_decode($content, true)['data'];

        return view('detail-login', ['item' => $item]);
    }
    public function produk_kos_update(string $id)
    {
        $client = new \GuzzleHttp\Client();
        $url = "http://localhost:8000/api/kos/{$id}";
        $response = $client->request('GET', $url);
        $content = $response->getBody()->getContents();
        $item = json_decode($content, true)['data'];

        return view('produk_kos_update', ['item' => $item]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $client = new Client();
        $url = "http://localhost:8000/api/kos/{$id}";

        // Validasi data
        $request->validate([
            'nama' => 'required',
            'deskripsi' => 'required',
            'harga' => 'required|numeric',
            'lokasi' => 'required',
            'gambar' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Persiapkan data untuk dikirim
        $data = [
            [
                'name' => 'nama',
                'contents' => $request->nama
            ],
            [
                'name' => 'deskripsi',
                'contents' => $request->deskripsi
            ],
            [
                'name' => 'harga',
                'contents' => $request->harga
            ],
            [
                'name' => 'lokasi',
                'contents' => $request->lokasi
            ]
        ];

        // Jika ada file gambar yang diunggah
        if ($request->hasFile('gambar')) {
            $gambar = $request->file('gambar');
            $data[] = [
                'name' => 'gambar',
                'contents' => fopen($gambar->getPathname(), 'r'),
                'filename' => $gambar->getClientOriginalName(),
            ];
        }

        try {
            $response = $client->request('PUT', $url, [
                'multipart' => $data
            ]);

            $content = $response->getBody()->getContents();
            $contentArray = json_decode($content, true);

            if ($contentArray['status']) {
                return redirect()->route('produk-kos')->with('success', 'Data berhasil diperbarui');
            } else {
                return redirect()->route('produk-kos-update', $id)->withErrors($contentArray['data'])->withInput();
            }
        } catch (\Exception $e) {
            return redirect()->route('produk-kos-update', $id)->with('error', 'Gagal memproses data: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
