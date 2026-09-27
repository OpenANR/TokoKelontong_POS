<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\Extension\CommonMark\Node\Inline\Strong;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::all();
        $total = Product::count();
        return view('admin.product.product', compact(['product', 'total']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.product.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'gambar' => 'nullable|image|mimes:png,jpg|max:2048',
            'nama_produk' => 'required|string',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string',
            'harga' => 'required|integer',
            'stok' => 'required|integer'
        ]);

        $data = [
            'gambar' => null,
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'stok' => $request->stok
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('product', 'public');
        }

        Product::create($data);
        return redirect()->route('product.index')->with('success', 'Produk berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return view('admin.product.edit', compact('product'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'gambar' => 'nullable|images|mimes:png,jpg|max:2048',
            'nama_produk' => 'required|string',
            'deskripsi' => 'required|string',
            'kategori' => 'required|string',
            'harga' => 'required|integer',
            'stok' => 'required|integer'
        ]);

        $data = [
            'nama_produk' => $request->nama_produk,
            'deskripsi' => $request->deskripsi,
            'kategori' => $request->kategori,
            'harga' => $request->harga,
            'stok' => $request->stok
        ];

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('product', 'public');
        }

        $product->update($data);
        return redirect()->route('product.index')->with('success', 'Produk berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        if($product->gambar && Storage::disk('public')->exists($product->gambar)) {
            Storage::disk('public')->delete($product->gambar);
        }

        $product->delete();
        return redirect()->route('product.index')->with('success', 'Produk berhasil dihapus');
    }
}