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
}
