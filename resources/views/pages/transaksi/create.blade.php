@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-sm-12 my-3 p-3 bg-body rounded shadow-sm">
            <div class="card ">
                <div class="card-header">
                    <h6 class="pb-2 mb-0">Tambah Data Transaksi</h6>
                </div>
                <form action="{{ route('transaksi.store') }}" method="post">
                    @csrf
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-6">
                                        <h6>Data Produk</h6>
                                    </div>
                                    <div class="col-6">
                                        <div class="text-end">
                                            <button type="button" class="btn btn-primary" onclick="TujuanClick()"><i
                                                    class="fa fa-plus"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Produk</label>
                                    <select class="form-select js-example-basic-single" name="produk_id[]">
                                        <option selected>Pilih Produk</option>
                                        @foreach ($produk as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama }} //
                                                {{ $item->jenis->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Jumlah</label>
                                    <input type="text" class="form-control" name="jumlah[]">
                                </div>
                            </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label for="nama" class="form-label">Satuan</label>
                                    <select class="form-select js-example-basic-single" name="satuan[]">
                                        <option selected>Pilih Satuan</option>
                                        <option value="rim">Rim</option>
                                        <option value="lembar">Lembar</option>
                                        <option value="buah">Buah</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-12" id="tambahData"></div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <div class="col-12 text-end">
                            <div class="mb-3">
                                <a type="button" class="btn btn-warning" href="{{ route('transaksi.index') }}">Close</a>
                                <button type="submit" class="btn btn-primary">Simpan</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div> <!-- end col-->
    </div>
@endsection

@push('js')
    <script>
        let hitung = 0;

        function makeid(length) {
            var result = '';
            var characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
            var charactersLength = characters.length;
            for (var i = 0; i < length; i++) {
                result += characters.charAt(Math.floor(Math.random() * charactersLength));
            }
            return result;
        }

        function TujuanClick() {
            hitung++;
            console.log(hitung);
            let count = makeid(10);
            let html = `
                <div class="row" id="bodyData_${count}">
                    <hr>
                    <div class="col-6">
                        <h6>Data Produk</h6>
                    </div>
                    <div class="col-6">
                        <div class="text-end">
                            <button type="button" class="btn btn-danger delete3_${count}" data-target="${ count }" onclick="delTujuan(this)"><i class="fa fa-close"></i></button>
                        </div>
                    </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Produk</label>
                                <select class="form-select js-example-basic-single" name="produk_id[]">
                                    <option selected>Pilih Produk</option>
                                    @foreach ($produk as $item)
                                        <option value="{{ $item->id }}">{{ $item->nama }} // {{ $item->jenis->nama }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Jumlah</label>
                                <input type="text" class="form-control" name="jumlah[]">
                            </div>
                        </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label for="nama" class="form-label">Satuan</label>
                                <select class="form-select js-example-basic-single" name="satuan[]">
                                    <option selected>Pilih Jenis Produk</option>
                                    <option value="rim">Rim</option>
                                    <option value="lembar">Lembar</option>
                                    <option value="buah">Buah</option>
                                </select>
                            </div>
                        </div>
                </div>
                `;
            $('#tambahData').append(html);
            $('.rupiah').keyup(function(e) {
                $(this).val(formatRupiah(this.value, "Rp. "));
            });
            $(".js-example-basic-single").select2();
        }

        function delTujuan(e) {
            hitung--;
            let id = $(e).data('target');
            $('#bodyData_' + id).remove();
        }
    </script>
@endpush
