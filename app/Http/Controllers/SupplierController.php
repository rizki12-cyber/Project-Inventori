<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Models\LogAktivitas;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SupplierExport;

class SupplierController extends Controller
{
    // 📝 Fungsi log aktivitas
    private function catatLog($aksi)
    {
        LogAktivitas::create([
            'user_id' => auth()->id(),
            'role'    => auth()->user()->role ?? '-',
            'aksi'    => $aksi,
        ]);
    }

    public function index(Request $request)
    {
        $query = Supplier::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('nama_supplier', 'like', "%{$search}%");
        }

        $suppliers = $query->latest()->paginate(10);
        $suppliers->appends($request->all());

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

        // ✨ Log
        $this->catatLog("Menambah supplier baru: {$request->nama_supplier}");

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

        // ✨ Log
        $this->catatLog("Memperbarui supplier: {$supplier->nama_supplier}");

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil diperbarui.');
    }

    public function destroy(Supplier $supplier)
    {
        $nama = $supplier->nama_supplier;

        $supplier->delete();

        // ✨ Log
        $this->catatLog("Menghapus supplier: {$nama}");

        return redirect()->route('admin.supplier.index')->with('success', 'Supplier berhasil dihapus.');
    }

    // EXPORT EXCEL
    public function exportExcel()
    {
        // ✨ Log
        $this->catatLog("Meng-export data supplier ke Excel");

        return Excel::download(new SupplierExport, 'data_supplier.xlsx');
    }
}
