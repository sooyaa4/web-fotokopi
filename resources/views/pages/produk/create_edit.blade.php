@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-sm-12 my-3 p-3 bg-body rounded shadow-sm">
            <div class="card ">
                <div class="card-header">
                    @if (Route::is('produk.create'))
                        <h6 class="pb-2 mb-0">Tambah Data Produk</h6>
                    @else
                        <h6 class="pb-2 mb-0">Edit Data Produk</h6>
                    @endif
                </div>
                @if (Route::is('produk.create'))
                    <div class="card-body">
                        <form action="{{ route('produk.store') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Jenis Produk</label>
                                        <select class="form-select js-example-basic-single" name="jenis_id">
                                            <option selected>Pilih Jenis Produk</option>
                                            @foreach ($jenis as $item)
                                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Produk</label>
                                        <input type="text" class="form-control" name="nama">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Stok</label>
                                        <input type="text" class="form-control" name="stok">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Satuan</label>
                                        <select class="form-select js-example-basic-single" name="satuan">
                                            <option selected>Pilih Jenis Produk</option>
                                            <option value="rim">Rim</option>
                                            <option value="lembar">Lembar</option>
                                            <option value="buah">Buah</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Harga</label>
                                        <input type="text" class="form-control rupiah" name="harga">
                                    </div>
                                </div>
                                <div class="col-12 text-end">
                                    <div class="mb-3">
                                        <a type="button" class="btn btn-warning"
                                            href="{{ route('produk.index') }}">Close</a>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @else
                    <div class="card-body">
                        <form action="{{ route('produk.update', $produk->id) }}" method="post">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Jenis Produk</label>
                                        <select class="form-select js-example-basic-single" name="jenis_id">
                                            <option selected>Pilih Jenis Produk</option>
                                            @foreach ($jenis as $item)
                                                <option value="{{ $item->id }}" {{ old('jenis_id', $produk->jenis_id) == $item->id ? 'selected' : null}}>{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Nama Produk</label>
                                        <input type="text" class="form-control" name="nama" value="{{ $produk->nama }}">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="nama" class="form-label">Harga</label>
                                        <input type="text" class="form-control rupiah" name="harga" value="{{ replaceRp($produk->harga) }}">
                                    </div>
                                </div>
                                <div class="col-12 text-end">
                                    <div class="mb-3">
                                        <a type="button" class="btn btn-warning"
                                            href="{{ route('produk.index') }}">Close</a>
                                        <button type="submit" class="btn btn-primary">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endif
            </div>
        </div> <!-- end col-->
    </div>
@endsection

@push('js')
@endpush
