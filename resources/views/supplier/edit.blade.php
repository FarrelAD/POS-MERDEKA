@extends('layouts.template')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3 class="card-title">{{ $page->title }}</h3>
            <div class="card-tools"></div>
        </div>

        <div class="card-body">
            @empty($supplier)
                <div class="alert alert-danger alert-dismissable">
                    <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
                    Data yang Anda cari tidak ditemukan.
                </div>
                <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
            @else
                <form action="{{ route('supplier.update', ['id' => $supplier->supplier_id]) }}" method="post" class="form-horizontal">
                    @csrf
                    {!! method_field('PUT') !!}

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Nama supplier</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="supplier_nama" name="supplier_nama" value="{{ old('supplier_nama', $supplier->supplier_nama) }}" required>

                            @error('supplier_nama')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Kontak</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="kontak" name="kontak" value="{{ old('kontak', $supplier->kontak) }}" required>

                            @error('kontak')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-1 control-label col-form-label">Alamat</label>
                        <div class="col-11">
                            <input type="text" class="form-control" id="alamat" name="alamat" value="{{ old('alamat', $supplier->alamat) }}" required>

                            @error('alamat')
                                <small class="form-text text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row">
                        <div class="col-11">
                            <button type="submit" class="btn btn-primary btn-sm">Simpan</button>
                            <a href="{{ route('supplier.index') }}" class="btn btn-sm btn-default ml-1">Kembali</a>
                        </div>
                    </div>
                </form>
            @endempty
        </div>
    </div>
@endsection
