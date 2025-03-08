@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah To Do</h1>
                    </div>
                    <form class="row g-3 needs-validation" novalidate method="POST" action="{{ route('todo.store') }}"
                        enctype="multipart/form-data">
                        @csrf

                        <!-- Judul -->
                        <div class="mb-3">
                            <label for="title" class="form-label">Judul</label>
                            <input type="text" name="title" class="form-control" id="title" placeholder="Judul"
                                required>
                            @error('title')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label for="description" class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" id="description" rows="3"
                                required></textarea>
                            @error('description')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <!-- Dokumentasi -->
                        <div class="mb-3">
                            <label for="documentation" class="form-label">Dokumentasi</label>
                            <input class="form-control" name="documentation" type="file" id="documentation">
                            @error('documentation')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>

                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="completed" id="flexCheckDefault">
                            <label class="form-check-label" for="flexCheckDefault">
                                Selesai
                            </label>
                        </div>


                        <!-- Tombol -->
                        <div class="col-12">
                            <button class="btn btn-info" type="submit">Tambah</button>
                            <a href="{{ route('todo.index') }}" class="btn btn-primary">Kembali</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection