<?php

namespace App\Http\Controllers;

use App\Models\DetailProdukMasuk;
use App\Models\Produk;
use App\Models\ProdukMasuk;
use App\Models\Suppliers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProdukMasukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produkMasuk = ProdukMasuk::paginate(10);

        return view('pages.produkMasuk.index', compact('produkMasuk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $supplier = Suppliers::all();
        $produk = Produk::all();

        return view('pages.produkMasuk.create_edit', compact('supplier', 'produk'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $this->validate($request, [
            'suppliers_id' => 'required|exists:suppliers,id',
            'tanggal_masuk' => 'required',
            'jumlah' => 'required',
            'produk_id.*' => 'required|exists:produks,id',
            'satuan'=> 'required'
        ]);
        DB::beginTransaction();
        try {
            $cekid= ProdukMasuk::max('id');
            $subtotal = 0;
            foreach ($request->produk_id as $key => $value) {

                $subtotal += replaceRp(replaceRpSeparator($request->harga_satuan[$key])) * $request->jumlah[$key];
                
            }

            $header = ProdukMasuk::create([
                'nota' => '123'.$cekid ,
                'suppliers_id' => $request->suppliers_id,
                'subtotal' => $subtotal,
                'created_by' => Auth::user()->id,
                'tanggal_masuk' => parseFormat($request->tanggal_masuk)
            ]);

            foreach ($request->produk_id as $key => $value) {
                
                $data = DetailProdukMasuk::create([
                    'jumlah' => $request->jumlah[$key],
                    'prod_masuk_id' => $header->id,
                    'satuan' => $request->satuan[$key],
                    'harga_satuan' => replaceRp(replaceRpSeparator($request->harga_satuan[$key])),
                    'produk_id' => $value
                ]);

                if ($request->satuan[$key] == 'rim') {
                    $stok = $request->jumlah[$key] * 500;
                }else{
                    $stok = $request->jumlah[$key];
                }

                Produk::find($data->produk_id)->increment('stok', $stok);
            }

            DB::commit();

            return redirect()->route('produk-masuk.index')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            return redirect()->route('produk-masuk.index')->with('danger', $th->getMessage());

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProdukMasuk  $produkMasuk
     * @return \Illuminate\Http\Response
     */
    public function show(ProdukMasuk $produkMasuk)
    {
        return view('pages.produkMasuk.show_data', compact('produkMasuk'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProdukMasuk  $produkMasuk
     * @return \Illuminate\Http\Response
     */
    public function edit(ProdukMasuk $produkMasuk)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ProdukMasuk  $produkMasuk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProdukMasuk $produkMasuk)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProdukMasuk  $produkMasuk
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProdukMasuk $produkMasuk)
    {
        DB::beginTransaction();
        try {
            foreach ($produkMasuk->detail as $key => $value) {

                if ($value->satuan == 'rim') {
                    $stok = $value->jumlah * 500;
                }else{
                    $stok = $value->jumlah;
                }

                Produk::find($value->produk_id)->decrement('stok', $stok);

                $value->delete();

            }

            $produkMasuk->delete();

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Berhasil Menghapus Data',
            ]);

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            dd($th);
            return response()->json([
                'success' => false,
                'message' => 'Gagal Menghapus Data',
            ]);
        }
    }
}
