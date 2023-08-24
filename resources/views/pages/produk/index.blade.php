@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-sm-12 my-3 p-3 bg-body rounded shadow-sm">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h6 class="pb-2 mb-0">Data Produk</h6>
                        </div>
                        <div class="col-6 text-end">
                            <a class="btn btn-primary" type="button" href="{{ route('produk.create') }}">Tambah Data</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nama Produk</th>
                                    <th>Jenis Produk</th>
                                    <th>Stok</th>
                                    <th>Harga</th>
                                    <th>Status</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produk as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->jenis->nama }}</td>
                                        <td>{{ $item->stok }}</td>
                                        <td>{{ toRp($item->harga) }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>
                                            <div class="col-auto m-0 row">
                                                <div class="col-auto g-1">
                                                    <a class="btn btn-primary" href="{{ route('produk.edit', $item->id) }}"><span
                                                            class="fa fa-pencil"></span></a>
                                                </div>
                                                <div class="col-auto g-1">
                                                    <form action="{{ route('produk.update', $item->id) }}" method="post">
                                                        @method('PUT')
                                                        @csrf
                                                        @if ($item->status == 'off')
                                                            <button type="submit" name="statusb" value="off"
                                                                class="btn btn-danger"><span
                                                                    class="fa fa-toggle-off"></span></button>
                                                        @else
                                                            <button type="submit" name="statusa" value="on"
                                                                class="btn btn-warning"><span
                                                                    class="fa fa-toggle-on"></span></button>
                                                        @endif
                                                    </form>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-start mt-2">
                        {{ $produk->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div> <!-- end col-->
    </div>
@endsection

@push('js')
@endpush
