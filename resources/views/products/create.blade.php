@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0 fw-bold">Tambah Menu Baru</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

<div class="mb-3">
<label>Nama Produk</label>
<input type="text" name="nama_produk" class="form-control" required>
@error('nama_produk') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="mb-3">
<label>Deskripsi</label>
<textarea name="deskripsi_produk" class="form-control"></textarea>
</div>

<div class="mb-3">
<label>Harga</label>
<input type="number" name="harga_produk" class="form-control" required>
@error('harga_produk') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="mb-3">
<label>Stok</label>
<input type="number" name="stok_produk" class="form-control" required>
@error('stok_produk') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<div class="mb-3">
<label>Kategori</label>
<select name="kategori_produk" class="form-control">
<option value="coffe">Coffee</option>
<option value="non-coffe">Non-Coffee</option>
<option value="food">Food</option>
</select>
</div>

<div class="mb-3">
<label>Foto Produk</label>
<input type="file" name="foto_produk" class="form-control" required>
@error('foto_produk') <span class="text-danger">{{ $message }}</span> @enderror
</div>

<button type="submit" class="btn btn-primary">Simpan Produk</button>
</form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection