@extends('layouts.admin')

@section('content')
<div class="card">
    <div class="card-header d-flex justify-content-between align-items-center">
        <h3>Daftar Mobil</h3>
        <a href="{{ route('admin.cars.create') }}" class="btn btn-primary">Tambah Data</a>
    </div>
    <div class="card-body">
        <!-- Filter Form -->
        <form action="{{ route('admin.cars.index') }}" method="get" class="mt-3">
            <div class="form-row">
                <div class="form-group col-md-4">
                    <label for="search">Search by Name</label>
                    <input type="text" name="search" id="search" class="form-control" value="{{ request('search') }}" placeholder="Enter car name">
                </div>
                <div class="form-group col-md-4">
                    <label for="status">Filter by Status</label>
                    <select name="status" id="status" class="form-control">
                        <option value="">All</option>
                        <option value="available" @if(request('status')=='tersedia' ) selected @endif>Available</option>
                        <option value="unavailable" @if(request('status')=='tidak_tersedia' ) selected @endif>Unavailable</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <div class="table-responsive mt-3">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mobil</th>
                        <th>Gambar Mobil</th>
                        <th>Harga Mobil</th>
                        <th>Status Mobil</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cars as $car)
                    <tr>
                        <td>{{ $loop->index + 1 + ($cars->perPage() * ($cars->currentPage() - 1)) }}</td>
                        <td>{{ $car->nama_mobil }}</td>
                        <td>
                            <img src="{{ asset(Storage::url($car->gambar)) }}" width="400">
                        </td>
                        <td>{{ $car->harga_sewa }}</td>
                        <td>{{ $car->status }}</td>
                        <td>
                            <a href="{{ route('admin.cars.edit', $car->id) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form class="d-inline" action="{{ route('admin.cars.destroy', $car->id) }}" method="post">
                                @csrf
                                @method('delete')
                                <button onclick="return confirm('Apakah Anda ingin menghapus data ini?')" type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center">Data Kosong</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-1">
            {{ $cars->onEachSide(1)->appends(request()->input())->render("pagination::bootstrap-4")->with(['class' => 'custom-pagination']) }}
        </div>
    </div>
</div>
@endsection
