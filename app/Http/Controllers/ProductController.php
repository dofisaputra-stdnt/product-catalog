<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar semua produk.
     *
     * Metode ini mengambil semua data produk dari model Product dan mengirimkannya
     * ke tampilan 'products.index' untuk ditampilkan.
     *
     * @return \Illuminate\View\View Tampilan yang menampilkan daftar produk.
     */
    public function index(Request $request)
    {
        $query = Product::query();

        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        if ($request->has('search') && $request->search != '') {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $products = $query->get();
        return view('products.index', compact('products'));
    }

    /**
     * Menampilkan halaman untuk membuat produk baru.
     *
     * @return \Illuminate\View\View Halaman view untuk membuat produk baru.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Menampilkan halaman untuk mengedit produk.
     *
     * @param  \App\Models\Product  $product  Instance dari model Product yang akan diedit.
     * @return \Illuminate\View\View  Mengembalikan tampilan view 'products.edit' dengan data produk yang akan diedit.
     */
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    /**
     * Menghapus produk yang diberikan dari basis data dan menghapus file gambar terkait.
     *
     * @param \App\Models\Product $product Produk yang akan dihapus.
     * @return \Illuminate\Http\RedirectResponse Redirect ke halaman indeks produk dengan pesan sukses.
     */
    public function destroy(Product $product)
    {
        // Delete the image file
        $imagePath = public_path('images/' . $product->image);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        // Delete the product from the database
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }


    /**
     * Menyimpan produk baru ke dalam database.
     *
     * @param \Illuminate\Http\Request $request Objek permintaan yang berisi data produk.
     * 
     * Validasi yang dilakukan:
     * - 'name' harus diisi.
     * - 'description' harus diisi.
     * - 'price' harus diisi dan berupa angka.
     * - 'stock' harus diisi dan berupa bilangan bulat.
     * - 'status' harus diisi.
     * - 'image' harus diisi, berupa gambar dengan format jpeg, png, jpg, gif, atau svg, dan ukuran maksimal 2048 kilobyte.
     * - 'image_tag' harus diisi.
     *
     * @return \Illuminate\Http\RedirectResponse Mengarahkan kembali ke halaman indeks produk dengan pesan sukses.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'status' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_tag' => 'required',
        ]);

        $imageName = time() . '.' . $request->image->extension();
        $request->image->move(public_path('images'), $imageName);

        Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'status' => $request->status,
            'image' => $imageName,
            'image_tag' => $request->image_tag,
        ]);

        return redirect()->route('products.index')
            ->with('success', 'Product created successfully.');
    }

    /**
     * Memperbarui data produk yang ada.
     *
     * @param \Illuminate\Http\Request $request Objek permintaan yang berisi data yang akan diperbarui.
     * @param \App\Models\Product $product Objek produk yang akan diperbarui.
     * @return \Illuminate\Http\RedirectResponse Mengarahkan kembali ke halaman indeks produk dengan pesan sukses.
     *
     * Validasi:
     * - 'name' harus diisi.
     * - 'description' harus diisi.
     * - 'price' harus diisi dan berupa angka.
     * - 'stock' harus diisi dan berupa integer.
     * - 'status' harus diisi.
     * - 'image' harus berupa gambar dengan tipe: jpeg, png, jpg, gif, svg dan ukuran maksimal 2048 kilobyte.
     * - 'image_tag' harus diisi.
     *
     * Jika ada file gambar yang diunggah, gambar tersebut akan dipindahkan ke direktori 'public/images' 
     * dan nama file gambar akan disimpan dalam atribut 'image' produk.
     */
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'status' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'image_tag' => 'required',
        ]);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images'), $imageName);
            $product->image = $imageName;
        }

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;
        $product->status = $request->status;
        $product->image_tag = $request->image_tag;
        $product->save();

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }
}
