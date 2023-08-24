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
                            <a class="btn btn-primary" type="button" href="{{ route('produk-masuk.create') }}">Tambah
                                Data</a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nota</th>
                                    <th>Suppliers</th>
                                    <th>Subtotal</th>
                                    <th>Tanggal Masuk</th>
                                    <th>Jumlah Produk</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($produkMasuk as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nota }}</td>
                                        <td>{{ $item->supplier->nama }}</td>
                                        <td>{{ toRp($item->subtotal) }}</td>
                                        <td>{{ tglIndo($item->tanggal_masuk) }}</td>
                                        <td>{{ $item->detail->count() }}</td>
                                        <td>
                                            <div class="col-auto m-0 row">
                                                <div class="col-auto g-1">
                                                    <a class="btn btn-warning"
                                                        href="{{ route('produk-masuk.show', $item->id) }}"><span
                                                            class="fa fa-eye"></span></a>
                                                </div>
                                                <div class="col-auto g-1">
                                                    <button class="btn btn-danger" type="button" onclick="deleteData({{ $item->id }})"><span
                                                            class="fa fa-trash"></span></button>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-start mt-2">
                        {{ $produkMasuk->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div> <!-- end col-->
    </div>
@endsection

@push('js')
    <script>
        function deleteData(id) {
            swal.fire({
                title: "Delete?",
                icon: 'question',
                text: "Please ensure and then confirm!",
                type: "warning",
                showCancelButton: !0,
                confirmButtonText: "Yes, delete it!",
                cancelButtonText: "No, cancel!",
                reverseButtons: !0
            }).then(function(e) {

                if (e.value === true) {
                    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');

                    $.ajax({
                        type: 'DELETE',
                        url: "{{ url('produk-masuk') }}/" + id,
                        data: {
                            _token: CSRF_TOKEN,
                            id: id
                        },
                        dataType: 'JSON',
                        success: function(results) {
                            console.log(results)

                            if (results.success === true) {
                                console.log(results)
                                Swal.fire(
                                    'Deleted!',
                                    'Data anda Terhapus.',
                                    'Berhasil'
                                )
                                // refresh page after 2 seconds
                                setTimeout(function() {
                                    location.reload();
                                }, 2000);
                            } else {
                                swal.fire("Error!", results.message, "error");
                            }
                        }
                    });

                } else {
                    console.log(e)

                    e.dismiss;
                }

            }, function(dismiss) {
                return false;
            })
        }
    </script>
@endpush
