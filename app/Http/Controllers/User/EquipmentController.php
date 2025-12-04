<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Equipment;
use App\Models\Category;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function browse(Request $request)
    {
        $categories = Category::orderBy('name')->get();
        
        $query = Equipment::with('category')
            ->where('status', 'available');
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }
        
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }
        
        $equipment = $query->orderBy('name')->get();
        
        return view('user.equipment.browse', compact('equipment', 'categories'));
    }
}