<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Thuonghieu;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Storage;

class ThuonghieuController extends Controller
{
    public function index()
    {
        $thuonghieus = Thuonghieu::orderBy('id', 'desc')->get();
        return Inertia::render('Admin/Thuonghieu/Index', [
            'thuonghieus' => $thuonghieus
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenthuonghieu' => 'required|string|max:255|unique:Thuonghieu,tenthuonghieu',
            'mota_thuonghieu' => 'nullable|string',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo_url')) {
            $path = $request->file('logo_url')->store('thuonghieus', 'public');
            $validated['logo_url'] = $path;
        }

        Thuonghieu::create($validated);

        return redirect()->route('admin.thuonghieus.index')->with('success', 'Đã thêm thương hiệu mới thành công!');
    }

    public function update(Request $request, $id)
    {
        $thuonghieu = Thuonghieu::findOrFail($id);

        $validated = $request->validate([
            'tenthuonghieu' => 'required|string|max:255|unique:Thuonghieu,tenthuonghieu,' . $id,
            'mota_thuonghieu' => 'nullable|string',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('logo_url')) {
            if ($thuonghieu->logo_url && Storage::disk('public')->exists($thuonghieu->logo_url)) {
                Storage::disk('public')->delete($thuonghieu->logo_url);
            }
            $path = $request->file('logo_url')->store('thuonghieus', 'public');
            $validated['logo_url'] = $path;
        }

        $thuonghieu->update($validated);

        return redirect()->back()->with('success', 'Đã cập nhật thương hiệu thành công!');
    }

    public function destroy($id)
    {
        $thuonghieu = Thuonghieu::findOrFail($id);
        if ($thuonghieu->logo_url && Storage::disk('public')->exists($thuonghieu->logo_url)) {
            Storage::disk('public')->delete($thuonghieu->logo_url);
        }
        $thuonghieu->delete();

        return redirect()->back()->with('success', 'Đã xóa thương hiệu thành công!');
    }
}
