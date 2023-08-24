@extends('template.app')

@section('content')
    <div class="row">
        <div class="col-sm-12 my-3 p-3 bg-body rounded shadow-sm">
            <div class="card ">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h6 class="pb-2 mb-0">Data Supplier</h6>
                        </div>
                        <div class="col-6 text-end">
                            <button class="btn btn-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#exampleModal">Tambah Data</button>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Nama</th>
                                    <th>Nomor Hp</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($suppliers as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->nama }}</td>
                                        <td>{{ $item->no_hp }}</td>
                                        <td>
                                            <button class="btn btn-primary editPost" data-id="{{ $item->id }}"><span
                                                    class="fa fa-pencil"></span></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="text-start mt-2">
                        {{ $suppliers->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div> <!-- end col-->
    </div>
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form action="{{ route('supplier.store') }}" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Supplier</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Supplier</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nomor Handphone</label>
                            <input type="text" class="form-control" id="noHp" name="no_hp">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Tambah</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="postForm" name="postForm" method="post">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Edit Supplier</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Supplier</label>
                            <input type="text" class="form-control" id="namaa" name="nama">
                            <input type="hidden" name="id" id="id">
                        </div>
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nomor Handphone</label>
                            <input type="text" class="form-control" id="noHpp" name="no_hp">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" id="savedata" class="btn btn-primary">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $('body').on('click', '.editPost', function() {
            var id = $(this).data('id');
            $.get("{{ route('supplier.index') }}" + '/' + id + '/edit', function(data) {
                console.log(data)
                $('#editModal').modal('show');
                $('#id').val(data.id);
                $('#namaa').val(data.nama);
                $('#noHpp').val(data.no_hp);
            })
        });

        $('#savedata').click(function(e) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            var isi = {
                'id': $('#id').val(),
                'nama': $('#namaa').val(),
                'no_hp': $('#noHpp').val()
            }
            console.log(isi)
            isi['_method'] = 'PUT';
            e.preventDefault();
            $(this).html('Sending..');
            let id_supplier = isi.id;
            $.ajax({
                url: "{{ url('supplier') }}/" + id_supplier,
                method: "PUT",
                dataType: 'json',
                data: isi,
                success: function(data) {
                    console.log(data)
                    Swal.fire({
                        icon: 'success',
                        title: data.message,
                        timer: 1500
                    })
                    $('#postForm').trigger("reset");
                    $('#editModal').modal('hide');
                    setTimeout(function() {
                        location.reload();
                    }, 1500);
                },
                error: function(data) {
                    console.log('Error:', data.responseJSON.errors);
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal, data tidak sesuai',
                        timer: 1500
                    })
                    $('#savedata').html('Save Changes');
                }
            });
        });
    </script>
@endpush
