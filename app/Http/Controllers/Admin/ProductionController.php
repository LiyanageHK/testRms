<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductionController extends Controller
{
    public function index()
    {
        $products = DB::select("
            SELECT products.*, 
               (SELECT image FROM product_images WHERE product_images.product_id = products.id LIMIT 1) as thumbnail 
            FROM products
        ");

        return view('admin.production.index', compact('products'));
    }

    public function create()
    {
        $items = DB::select("SELECT * FROM items");
        return view('admin.production.create', compact('items'));
    }

    public function store(Request $request)
    {
        // Insert product
        DB::insert("INSERT INTO products (name, description, status,small,medium,large, created_at, updated_at) VALUES (?, ?, ?,?,?,?, NOW(), NOW())", [
            $request->name,
            $request->description,
            $request->status ? 1 : 0,
            $request->input('small', $request->input('small')),
            $request->input('medium', $request->input('medium')),
            $request->input('large', $request->input('large'))
        ]);

        $productId = DB::getPdo()->lastInsertId();

        // Insert items & quantities
        foreach ($request->item_ids as $index => $itemId) {
            $quantity = $request->quantities[$index];
            DB::insert("INSERT INTO product_items (product_id, item_id, quantity, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())", [
                $productId, $itemId, $quantity
            ]);
        }

        // Insert images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $filename = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products'), $filename);

                DB::insert("INSERT INTO product_images (product_id, image, created_at) VALUES (?, ?, NOW())", [
                    $productId, $filename
                ]);
            }
        }

        return redirect('/admin/production')->with('success', 'Product Created!');
    }

    public function edit($id)
    {
        $product = DB::selectOne("SELECT * FROM products WHERE id = ?", [$id]);
        $items = DB::select("SELECT * FROM items");
        $productItems = DB::select("SELECT * FROM product_items WHERE product_id = ?", [$id]);
        $images = DB::select("SELECT * FROM product_images WHERE product_id = ?", [$id]);

        $selected = [];
        foreach ($productItems as $pi) {
            $selected[$pi->item_id] = $pi->quantity;
        }

        return view('admin.production.edit', compact('product', 'items', 'selected', 'images'));
    }

    public function update(Request $request, $id)
    {
        // Update product
        DB::update("UPDATE products SET name = ?, description = ?, status = ?,small = ?, medium = ?, large = ?,  updated_at = NOW() WHERE id = ?", [
            $request->name,
            $request->description,
            $request->status ? 1 : 0,
            $request->input('small', $request->input('small')),
            $request->input('medium', $request->input('medium')),
            $request->input('large', $request->input('large')),
            $id
        ]);

        // Refresh items
        DB::delete("DELETE FROM product_items WHERE product_id = ?", [$id]);
        foreach ($request->item_ids as $index => $itemId) {
            $quantity = $request->quantities[$index];
            DB::insert("INSERT INTO product_items (product_id, item_id, quantity, created_at, updated_at) VALUES (?, ?, ?, NOW(), NOW())", [
                $id, $itemId, $quantity
            ]);
        }

        // Add new images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $filename = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('uploads/products'), $filename);

                DB::insert("INSERT INTO product_images (product_id, image, created_at) VALUES (?, ?, NOW())", [
                    $id, $filename
                ]);
            }
        }

        return redirect('/admin/production')->with('success', 'Product Updated!');
    }

    public function destroy($id)
    {
        // Delete images from server
        $images = DB::select("SELECT image FROM product_images WHERE product_id = ?", [$id]);
        foreach ($images as $img) {
            @unlink(public_path('uploads/products/' . $img->image));
        }

        DB::delete("DELETE FROM product_images WHERE product_id = ?", [$id]);
        DB::delete("DELETE FROM product_items WHERE product_id = ?", [$id]);
        DB::delete("DELETE FROM products WHERE id = ?", [$id]);

        return redirect('/admin/production')->with('success', 'Product Deleted!');
    }
    public function deleteImage($id)
{
    // Find image by id
    $image = DB::selectOne("SELECT * FROM product_images WHERE id = ?", [$id]);

    if ($image) {
        // Delete file from public/uploads/products
        $filePath = public_path('uploads/products/' . $image->image);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        // Remove from database
        DB::delete("DELETE FROM product_images WHERE id = ?", [$id]);

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'Image not found.'], 404);
}
}