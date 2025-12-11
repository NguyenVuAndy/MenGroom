<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loaisp;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LoaispController extends Controller
{
    public function index()
    {
        $loaisps = Loaisp::with('children')->whereNull('parent_id')->orderBy('id', 'desc')->get();
        return Inertia::render('Admin/Loaisp/Index', [
            'loaisps' => $loaisps
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'tenloai' => 'required|string|max:255|unique:Loaisp,tenloai',
            'mota_loaisp' => 'nullable|string',
            'parent_id' => 'nullable|exists:Loaisp,id',
        ]);

        Loaisp::create($validated);

        return redirect()->route('admin.loaisps.index')->with('success', 'Đã thêm loại sản phẩm mới thành công!');
    }

    public function update(Request $request, $id)
    {
        $loaisp = Loaisp::findOrFail($id);

        $validated = $request->validate([
            'tenloai' => 'required|string|max:255|unique:Loaisp,tenloai,' . $id,
            'mota_loaisp' => 'nullable|string',
            'parent_id' => 'nullable|exists:Loaisp,id',
        ]);

        $loaisp->update($validated);

        return redirect()->back()->with('success', 'Đã cập nhật loại sản phẩm thành công!');
    }

    public function destroy($id)
    {
        $loaisp = Loaisp::findOrFail($id);
        $loaisp->delete();

        return redirect()->back()->with('success', 'Đã xóa loại sản phẩm thành công!');
    }
}
