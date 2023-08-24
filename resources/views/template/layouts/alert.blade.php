@if (session()->get('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <strong>Berhasil!</strong> {{ session()->get('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger dark alert-dismissible fade show" role="alert" id="alert">
    <b>Terjadi Beberapa Kesalahan.</b><br>
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</div>
@endif

@if (session()->get('danger'))
    <div class="alert alert-danger alert-dismissible fade show mb-xl-0 mb-2" role="alert" id="alert">
        <strong> Gagal! </strong> {{ session()->get('danger') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    <br>
@endif