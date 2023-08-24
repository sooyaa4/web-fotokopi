<?php

namespace App\Http\Controllers;

use App\Models\JenisProduk;
use App\Models\Produk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $produk = Produk::paginate(10);

        return view('pages.produk.index', compact('produk'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $jenis = JenisProduk::all();
        return view('pages.produk.create_edit', compact('jenis'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $this->validate($request, [
            'nama' => 'required',
            'stok' => 'required|numeric',
            'harga' => 'required|numeric',
            'jenis_id' => 'required|exists:jenis_produks,id',
            'satuan' => 'required',
        ]);

        DB::beginTransaction();
        try {
            if ($request->satuan == 'rim') {
                $stok = $request->stok * 500;
            }else{
                $stok = $request->stok;
            }

            Produk::create([
                'nama' => $request->nama,
                'stok' => $stok,
                'harga' => replaceRp(replaceRpSeparator($request->harga)),
                'status' => 'on',
                'jenis_id' => $request->jenis_id,
                'created_by' => Auth::user()->id,
            ]);

            DB::commit();

            return redirect()->route('produk.index')->with('success', 'Data berhasil disimpan');

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('produk.index')->with('danger', $th->getMessage());

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function show(Produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function edit(Produk $produk)
    {
        $jenis = JenisProduk::all();
        return view('pages.produk.create_edit', compact('jenis', 'produk'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Produk $produk)
    {
        $this->validate($request, [
            'jenis_id' => 'exists:jenis_produks,id',
        ]);

        DB::beginTransaction();
        try {

            if ($request->statusa != null) {
                $produk->update([
                    'status' => 'off'
                ]);
            }
            

            if ($request->statusb != null) {
                $produk->update([
                    'status' => 'on'
                ]);
            }

            if ($request->nama != null) {
                $produk->update([
                    'nama' => $request->nama
                ]);
            }
            if ($request->harga != null) {
                $produk->update([
                    'harga' => replaceRp(replaceRpSeparator($request->harga))
                ]);
            }
            if ($request->jenis_id != null) {
                $produk->update([
                    'jenis_id' => $request->jenis_id
                ]);
            }

            DB::commit();

            return redirect()->route('produk.index')->with('success', 'Data berhasil dirubah');

        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return redirect()->route('produk.index')->with('danger', $th->getMessage());

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Produk  $produk
     * @return \Illuminate\Http\Response
     */
    public function destroy(Produk $produk)
    {
        //
    }
}
