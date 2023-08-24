<?php

namespace App\Http\Controllers;

use App\Models\DetailTransaksi;
use App\Models\Produk;
use App\Models\Transaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaksi = Transaksi::paginate(10);

        return view('pages.transaksi.index', compact('transaksi'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $produk = Produk::where('status', 'on')->get();

        return view('pages.transaksi.create', compact('produk'));
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
            'jumlah' => 'required',
            'produk_id.*' => 'required|exists:produks,id',
            'satuan'=> 'required'
        ]);
        DB::beginTransaction();
        try {
            $subtotal = 0;
            foreach ($request->produk_id as $key => $value) {
                $id = Produk::find($value);

                $subtotal += $id->harga * $request->jumlah[$key];
                
            }

            $header = Transaksi::create([
                'subtotal' => $subtotal,
                'created_by' => Auth::user()->id
            ]);

            foreach ($request->produk_id as $key => $value) {
                
                $data = DetailTransaksi::create([
                    'jumlah' => $request->jumlah[$key],
                    'transaksi_id' => $header->id,
                    'satuan' => $request->satuan[$key],
                    'produk_id' => $value
                ]);

                if ($request->satuan[$key] == 'rim') {
                    $stok = $request->jumlah[$key] * 500;
                }else{
                    $stok = $request->jumlah[$key];
                }

                Produk::find($data->produk_id)->decrement('stok', $stok);
            }

            DB::commit();

            return redirect()->route('transaksi.index')->with('success', 'Data berhasil disimpan');
        } catch (\Throwable $th) {
            //throw $th;
            dd($th);
            return redirect()->route('transaksi.index')->with('danger', $th->getMessage());

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function show(Transaksi $transaksi)
    {
        return view('pages.transaksi.show', compact('transaksi'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function edit(Transaksi $transaksi)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Transaksi $transaksi)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Transaksi  $transaksi
     * @return \Illuminate\Http\Response
     */
    public function destroy(Transaksi $transaksi)
    {
        DB::beginTransaction();
        try {
            foreach ($transaksi->detail as $key => $value) {

                if ($value->satuan == 'rim') {
                    $stok = $value->jumlah * 500;
                }else{
                    $stok = $value->jumlah;
                }

                Produk::find($value->produk_id)->increment('stok', $stok);

                $value->delete();

            }

            $transaksi->delete();

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
