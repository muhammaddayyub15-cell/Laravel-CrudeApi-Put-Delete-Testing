<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    // GET - Ambil semua data produk
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'message' => 'Data produk berhasil diambil',
            'data' => $products
        ], 200);
    }

    // POST - Tambah produk baru
    public function store(Request $request)
    {
        // DEBUG: cek request masuk atau tidak
        // dd($request->all());

        // Validasi input
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'description' => 'required'
        ]);

        // Simpan ke database
        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'description' => $request->description
        ]);

        // Response JSON
        return response()->json([
            'message' => 'Produk berhasil ditambahkan',
            'data' => $product
        ], 201);
    }

    // PUT/PATCH - Update produk
    public function update(Request $request, $id)
    {
        // DEBUG
        // dd($request->all(), $id);

        // Cari produk
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        // Validasi (fleksibel untuk update sebagian)
        $request->validate([
            'name' => 'sometimes|required',
            'price' => 'sometimes|required|numeric',
            'description' => 'sometimes|required'
        ]);

        // Update data (manual seperti style kamu)
        $product->update([
            'name' => $request->name ?? $product->name,
            'price' => $request->price ?? $product->price,
            'description' => $request->description ?? $product->description
        ]);

        // Response
        return response()->json([
            'message' => 'Produk berhasil diupdate',
            'data' => $product
        ], 200);
    }

    // DELETE - Hapus produk
    public function destroy($id)
    {
        // DEBUG
        // dd($id);

        // Cari produk
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Produk tidak ditemukan'
            ], 404);
        }

        // Hapus
        $product->delete();

        // Response
        return response()->json([
            'message' => 'Produk berhasil dihapus'
        ], 200);
    }
}
