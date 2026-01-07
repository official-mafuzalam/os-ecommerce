<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attribute;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AttributeController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:attributes_manage')->only([
            'index',
            'create',
            'store',
            'edit',
            'update',
            'destroy',
            'showAssignForm',
            'assignToProduct',
            'removeFromProduct'
        ]);
    }

    /**
     * Display a listing of the attributes.
     */
    public function index()
    {
        $attributes = Attribute::withCount('products')->orderBy('name')->paginate(15);

        return view('admin.attributes.index', compact('attributes'));
    }

    /**
     * Show the form for creating a new attribute.
     */
    public function create()
    {
        return view('admin.attributes.create');
    }

    /**
     * Store a newly created attribute in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:attributes,name',
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $attribute = Attribute::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->is_active ?? true
        ]);

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribute created successfully.');
    }

    /**
     * Display the specified attribute.
     */
    public function show($id)
    {
        $attribute = Attribute::with([
            'products' => function ($query) {
                $query->select('products.id', 'products.name');
            }
        ])->findOrFail($id);

        return view('admin.attributes.show', compact('attribute'));
    }

    /**
     * Show the form for editing the specified attribute.
     */
    public function edit($id)
    {
        $attribute = Attribute::findOrFail($id);

        return view('admin.attributes.edit', compact('attribute'));
    }

    /**
     * Update the specified attribute in storage.
     */
    public function update(Request $request, $id)
    {
        $attribute = Attribute::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255|unique:attributes,name,' . $id,
            'description' => 'nullable|string',
            'is_active' => 'boolean'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $attribute->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'is_active' => $request->is_active ?? $attribute->is_active
        ]);

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribute updated successfully.');
    }

    /**
     * Remove the specified attribute from storage.
     */
    public function destroy($id)
    {
        $attribute = Attribute::findOrFail($id);

        // Check if attribute is used by any products
        if ($attribute->products()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete attribute. It is being used by one or more products.');
        }

        $attribute->delete();

        return redirect()->route('admin.attributes.index')
            ->with('success', 'Attribute deleted successfully.');
    }

    /**
     * Show form to assign attributes to a product
     */
    public function showAssignForm($productId)
    {
        $product = Product::with('attributes')->findOrFail($productId);
        $attributes = Attribute::where('is_active', true)->get();

        return view('admin.products.assign-attributes', compact('product', 'attributes'));
    }

    /**
     * Assign attributes to a product
     */
    public function assignToProduct(Request $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $validator = Validator::make($request->all(), [
            'attributes' => 'required|array',
            'attributes.*.id' => 'required|exists:attributes,id',
            'attributes.*.values' => 'required|array',
            'attributes.*.values.*' => 'string|max:255'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Sync attributes with the product
        $attributesToSync = [];
        foreach ($request->attributes as $attributeData) {
            $attributeId = $attributeData['id'];
            foreach ($attributeData['values'] as $value) {
                if (!empty(trim($value))) {
                    $attributesToSync[$attributeId][] = ['value' => trim($value)];
                }
            }
        }

        // Use sync to update the relationship
        foreach ($attributesToSync as $attributeId => $values) {
            $product->attributes()->syncWithoutDetaching([$attributeId => ['value' => implode(',', $values)]]);
        }

        return redirect()->route('admin.products.edit', $productId)
            ->with('success', 'Attributes assigned successfully.');
    }

    /**
     * Remove attribute from a product
     */
    public function removeFromProduct($productId, $attributeId)
    {
        $product = Product::findOrFail($productId);
        $product->attributes()->detach($attributeId);

        return redirect()->back()
            ->with('success', 'Attribute removed from product.');
    }
}