<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipment = Equipment::with('category')->orderBy('name')->get();
        $categories = Category::orderBy('name')->get();
        
        return view('admin.equipment.index', compact('equipment', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        $imageName = null;
        if ($request->hasFile('image')) {
            $imageName = 'equip_' . time() . '_' . uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads/equipment'), $imageName);
        }

        Equipment::create([
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
            'description' => $validated['description'],
            'quantity' => $validated['quantity'],
            'available_quantity' => $validated['quantity'],
            'image' => $imageName,
            'status' => 'available',
        ]);

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Equipment added successfully!');
    }

    public function update(Request $request, $id)
    {
        $equipment = Equipment::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'category_id' => 'required|exists:categories,id',
            'description' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
            'available_quantity' => 'required|integer|min:0',
            'status' => 'required|in:available,unavailable,maintenance',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:5120',
        ]);

        $data = $validated;
        unset($data['image']);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete old image
            if ($equipment->image) {
                Storage::delete('public/equipment/' . $equipment->image);
            }

            $imageName = 'equip_' . time() . '_' . uniqid() . '.' . $request->file('image')->extension();
            $request->file('image')->move(public_path('uploads/equipment'), $imageName);
            $data['image'] = $imageName;
        }

        $equipment->update($data);

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Equipment updated successfully!');
    }

    public function destroy($id)
    {
        $equipment = Equipment::findOrFail($id);

        // Delete image
        if ($equipment->image) {
            Storage::delete('public/equipment/' . $equipment->image);
        }

        $equipment->delete();

        return redirect()->route('admin.equipment.index')
            ->with('success', 'Equipment deleted successfully!');
    }
}