<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sanpham;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Loaisp;
use App\Models\Thuonghieu;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class SanphamController extends Controller
{
    function index()
    {
        $sanphams = Sanpham::with(['loaisp', 'thuonghieu'])
            ->orderBy('id', 'desc')
            ->get();
        $loaisps = Loaisp::all();
        $thuonghieus = Thuonghieu::all();

        return Inertia::render('Admin/Sanpham/Index', [
            'sanphams' => $sanphams,
            'loaisps' => $loaisps,
            'thuonghieus' => $thuonghieus
        ]);
    }

    function store(Request $request)
    {
        $validated = $request->validate([
            'tensp' => 'required|string|max:255',
            'chitietsp' => 'nullable|string',
            'sku' => 'nullable|string|max:50|unique:Sanpham,sku',
            'gia' => 'required|numeric|min:0',
            'giakhuyenmai' => 'nullable|numeric|lt:gia',
            'soluongtonkho' => 'required|integer|min:0',
            'hdsd' => 'nullable|string',
            'thanhphansp' => 'nullable|string',
            'id_loaisp' => 'required|exists:Loaisp,id',
            'id_thuonghieu' => 'required|exists:Thuonghieu,id',
            'image_url' => 'nullable|array',
            'image_url.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'trangthaihienthi' => 'boolean'
        ]);
        if (empty($validated['sku'])) {
            $validated['sku'] = 'SP-' . Str::upper(Str::random(6));
        } else {
            $validated['sku'] = Str::upper($validated['sku']);
        }

        if ($request->hasFile('image_url')) {
            $paths = [];
            foreach ($request->file('image_url') as $file) {
                $paths[] = $file->store('sanphams', 'public');
            }
            $validated['image_url'] = json_encode($paths);
        }

        Sanpham::create($validated);

        return redirect()->route('admin.sanphams.index')->with('success', 'Đã thêm sản phẩm mới thành công!');
    }

    function update(Request $request, $id)
    {
        $sanpham = Sanpham::findOrFail($id);

        $sanpham->tensp = $request->input('tensp');
        $sanpham->chitietsp = $request->input('chitietsp');
        $sanpham->sku = Str::upper($request->input('sku'));
        $sanpham->gia = $request->input('gia');
        $sanpham->giakhuyenmai = $request->input('giakhuyenmai');
        $sanpham->soluongtonkho = $request->input('soluongtonkho');
        $sanpham->hdsd = $request->input('hdsd');
        $sanpham->thanhphansp = $request->input('thanhphansp');
        $sanpham->id_loaisp = $request->input('id_loaisp');
        $sanpham->id_thuonghieu = $request->input('id_thuonghieu');
        $sanpham->trangthaihienthi = $request->input('trangthaihienthi') ? 1 : 0;
        if ($request->filled('sku')) {
            $sanpham->sku = Str::upper($request->input('sku'));
        }
        if ($request->hasFile('image_url')) {
            if ($sanpham->image_url && Storage::disk('public')->exists($sanpham->image_url)) {
                Storage::disk('public')->delete($sanpham->image_url);
            }
            $path = $request->file('image_url')->store('sanphams', 'public');
            $sanpham->image_url = $path;
        }
        $sanpham->update();

        return redirect()->back()->with('success', 'Đã cập nhật sản phẩm thành công!');
    }

    function destroy($id)
    {
        $sanpham = Sanpham::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Đã xóa sản phẩm thành công!');
    }
}
