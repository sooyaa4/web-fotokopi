@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-sm-12 my-3 p-3 bg-body rounded shadow-sm">
            <div class="card ">
                <div class="card-header">
                    <h6 class="pb-2 mb-0">Data Detail Transaksi</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nama Produk</th>
                                    <th>Jumlah Beli</th>
                                    <th>Satuan</th>
                                    <th>Harga Produk</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi->detail as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->produk->nama }}</td>
                                        <td>{{ $item->jumlah}}</td>
                                        <td>{{ $item->satuan}}</td>
                                        <td>{{ toRp($item->produk->harga)}}</td>
                                        <td>
                                            @php
                                                $total = 0;
                                                $total = $item->produk->harga* $item->jumlah;
                                            @endphp
                                            {{ toRp($total) }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div> <!-- end col-->
    </div>
@endsection

@push('js')
@endpush
