<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Produk Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-10">

    <div class="max-w-6xl mx-auto bg-white p-6 rounded-lg shadow-md">
        
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Daftar Produk (Admin)</h1>
            <a href="{{ route('products.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                + Tambah Produk Baru
            </a>
        </div>

        @if ($message = Session::get('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ $message }}
            </div>
        @endif
        
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white border border-gray-200">
                <thead>
                    <tr class="bg-gray-50 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6 text-left">Foto</th>
                        <th class="py-3 px-6 text-left">Nama Produk</th>
                        <th class="py-3 px-6 text-left">Kategori</th>
                        <th class="py-3 px-6 text-right">Harga</th>
                        <th class="py-3 px-6 text-center">Stok</th>
                        @if(auth()->user()->role === 'admin')
                        <th class="py-3 px-6 text-center">Aksi</th>
                        @endif                    
                    </tr>
                </thead>


                <tbody class="text-gray-600 text-sm font-light">
                    @forelse($products as $product)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6 text-left">
                            @if($product->foto_produk)
                                <img src="{{ asset('storage/' . $product->foto_produk) }}" class="w-16 h-16 object-cover rounded">
                            @else
                                <span class="text-gray-400">No Image</span>
                            @endif
                        </td>


                        @if (auth()->user()->role === 'admin')
                         <td class="py-3 px-6 text-left font-medium">{{ $product->nama_produk }}</td>
                        <td class="py-3 px-6 text-left">{{ $product->kategori_produk }}</td>
                        <td class="py-3 px-6 text-right">Rp {{ number_format($product->harga_produk, 0, ',', '.') }}</td>
                        <td class="py-3 px-6 text-center">
                            <span class="bg-blue-200 text-blue-600 py-1 px-3 rounded-full text-xs">
                                {{ $product->stok_produk }}
                            </span>
                        </td>
                        <td class="py-3 px-6 text-center">
                            <div class="flex item-center justify-center gap-2">
                        <a href="{{ route('products.edit', $product->id) }}" class="text-yellow-500 hover:text-yellow-600">Edit</a>                                <form action="{{ route('products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Yakin hapus?');">
                                    @csrf
                                    @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                            <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                        </svg>
                            </button>
                        </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="py-4 text-center text-gray-500">
                            Belum ada produk. Silakan tambah dulu.
                        </td>
                    </tr>
                    @endif

                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>