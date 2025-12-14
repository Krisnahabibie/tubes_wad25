@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h5 class="mb-0 fw-bold">Edit Produk: {{ $product->nama_produk }}</h5>
                </div>

                <div class="card-body">
                    <form action="{{ route('products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="mb-3">
                            <label>Nama Produk</label>
                            <input type="text" name="nama_produk" class="form-control" value="{{ old('nama_produk', $product->nama_produk) }}" required>
                            @error('nama_produk') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Deskripsi</label>
                            <textarea name="deskripsi_produk" class="form-control">{{ old('deskripsi_produk', $product->deskripsi_produk) }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label>Harga</label>
                            <input type="number" name="harga_produk" class="form-control" value="{{ old('harga_produk', $product->harga_produk) }}" required>
                            @error('harga_produk') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Stok</label>
                            <input type="number" name="stok_produk" class="form-control" value="{{ old('stok_produk', $product->stok_produk) }}" required>
                            @error('stok_produk') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="mb-3">
                            <label>Kategori</label>
                            <select name="kategori_produk" class="form-control">
                                <option value="coffee" {{ $product->kategori_produk == 'coffee' ? 'selected' : '' }}>Coffee</option>
                                <option value="non-coffee" {{ $product->kategori_produk == 'non-coffee' ? 'selected' : '' }}>Non-Coffee</option>
                                <option value="food" {{ $product->kategori_produk == 'food' ? 'selected' : '' }}>Food</option>
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Foto Produk (Biarkan kosong jika tidak ingin mengganti)</label>
                            <input type="file" name="foto_produk" class="form-control">
                            <small class="text-muted">Foto saat ini:</small><br>
                            @if($product->foto_produk)
                                <img src="{{ asset('storage/' . $product->foto_produk) }}" width="100" class="mt-2 rounded">
                            @else
                                <span class="text-muted">Belum ada foto</span>
                            @endif
                            @error('foto_produk') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="{{ route('products.index') }}" class="btn btn-secondary">Batal</a>
                            <button type="submit" class="btn btn-warning">Update Produk</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection