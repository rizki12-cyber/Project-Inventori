<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index(Request $request)
{
    $query = Supplier::query();

    // Filter search hanya berdasarkan nama_supplier
    if ($request->has('search') && $request->search != '') {
        $search = $request->search;
        $query->where('nama_supplier', 'like', "%{$search}%");
    }

    // Ambil data terbaru, paginasi 10 per halaman
    $suppliers = $query->latest()->paginate(10);
    $suppliers->appends($request->all()); // agar query search tetap terbawa saat pindah halaman

    return view('admin.supplier.index', compact('suppliers'));
}


    public function create()
    {
        return view('admin.supplier.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
        ]);

        Supplier::create($request->all());
        return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil ditambahkan.');
    }

    public function edit(Supplier $supplier)
    {
        return view('admin.supplier.edit', compact('supplier'));
    }

    public function update(Request $request, Supplier $supplier)
    {
        $request->validate([
            'nama_supplier' => 'required|string|max:255',
            'alamat' => 'required|string',
            'telepon' => 'required|string|max:20',
        ]);

        $supplier->update($request->all());
        return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil dihapus.');
    }

    // 🔹 Export ke Excel
    public function exportExcel()
    {
        return Excel::download(new SupplierExport, 'data_supplier.xlsx');
    }
}
