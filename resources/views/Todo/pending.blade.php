@extends('layouts.app')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card shadow-sm border-0 rounded-3">
                <!-- Navbar -->
                <nav class="navbar bg-primary rounded-top p-3">
                    <div class="container-fluid">
                        <a class="navbar-brand text-white d-flex align-items-center" href="{{ route('todo.index') }}">
                            <i class="fas fa-tasks me-2"></i>
                            <span class="fw-bold">My Todo List</span>
                        </a>
                        <form class="d-flex" role="search" method="GET" action="{{ route('todo.index') }}">
                            <div class="input-group">
                                <input class="form-control" type="search" placeholder="Search todos..." name="search" value="{{ request()->get('search') }}">
                                <button class="btn btn-light" type="submit">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </form>
                    </div>
                </nav>

                <!-- Alerts -->
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show m-3" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show m-3" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                <!-- Search Result -->
                @if(request()->get('search') && $todos->isEmpty())
                    <div class="alert alert-info m-3">
                        <i class="fas fa-info-circle me-2"></i>Kata"{{ request()->get('search') }} Tidak Ditemukan !!!"
                    </div>
                @endif

                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h5 class="mb-0">TASK TODO</h5>
                    </div>

                    <div class="row">
                        @foreach($todos as $todo)
                            <div class="col-12 mb-5">
                                <div class="card h-100 shadow-sm mt-2 mb-2">
                                    <div class="row g-0">
                                        <div class="col-md-8">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">{{ $todo->title }}</h5>
                                                <p class="card-text">{{ $todo->description }}</p>
                                                <span class="badge {{ $todo->completed ? 'bg-success' : 'bg-warning' }}">
                                                    <i class="fas {{ $todo->completed ? 'fa-check-circle' : 'fa-clock' }} me-1"></i>
                                                    {{ $todo->completed ? 'Completed' : 'Pending' }}
                                                </span>
                                                <p class="text-muted mt-2">
                                                    <i class="fas fa-calendar me-2"></i> 
                                                    {{ \Carbon\Carbon::parse($todo->created_at)->format('d M Y, H:i') }}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            @if($todo->documentation)
                                                <img src="{{ asset('storage/' . $todo->documentation) }}" 
                                                     class="img-fluid rounded-end h-100 object-fit-cover" 
                                                     alt="Documentation">
                                            @else
                                                <div class="h-100 d-flex align-items-center justify-content-center bg-light rounded-end">
                                                    <i class="fas fa-image text-muted fa-2x"></i>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <div class="btn-group w-100 mt-1 d-flex justify-content-center">
                                            <!-- Tombol Edit -->
                                            <button type="button" class="btn btn-outline-primary btn-sm px-0 py-1" data-bs-toggle="modal" data-bs-target="#editModal{{ $todo->id }}">
                                                <i class="fas fa-edit fa-xs"> Edit </i>
                                            </button>
                                            <!-- Tombol Hapus -->
                                            <button type="button" class="btn btn-outline-danger btn-sm px-0 py-1" onclick="confirmDelete('{{ $todo->id }}')">
                                                <i class="fas fa-trash fa-xs"> Hapus </i>
                                            </button>
                                        </div>
                                        <form id="deleteForm-{{ $todo->id }}" action="{{ route('todo.destroy', $todo->id) }}" method="POST" class="d-none">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Edit Modal -->
                            <div class="modal fade" id="editModal{{ $todo->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header bg-primary text-white">
                                            <h5 class="modal-title">
                                                <i class="fas fa-edit me-2"></i>Edit Todo
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <form method="POST" action="{{ route('todo.update', $todo->id) }}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        <i class="fas fa-heading me-1"></i>Title
                                                    </label>
                                                    <input type="text" name="title" class="form-control" value="{{ $todo->title }}" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        <i class="fas fa-align-left me-1"></i>Description
                                                    </label>
                                                    <textarea name="description" class="form-control" rows="3" required>{{ $todo->description }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label">
                                                        <i class="fas fa-image me-1"></i>Documentation
                                                    </label>
                                                    @if($todo->documentation)
                                                        <div class="mb-2">
                                                            <img src="{{ asset('storage/' . $todo->documentation) }}" 
                                                                 class="img-thumbnail" alt="Current documentation">
                                                        </div>
                                                    @endif
                                                    <input class="form-control" name="documentation" type="file">
                                                </div>
                                                <div class="form-check">
                                                    <input type="hidden" name="completed" value="0">
                                                    <input class="form-check-input" type="checkbox" name="completed" value="1" 
                                                           {{ $todo->completed ? 'checked' : '' }}>
                                                    <label class="form-check-label">
                                                        <i class="fas fa-check-circle me-1"></i>Mark as completed
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                                    <i class="fas fa-times me-1"></i>Close
                                                </button>
                                                <button type="submit" class="btn btn-primary">
                                                    <i class="fas fa-save me-1"></i>Save Changes
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-center mt-4">
                        {{ $todos->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Delete Todo?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: '<i class="fas fa-trash me-1"></i>Yes, delete it!',
        cancelButtonText: '<i class="fas fa-times me-1"></i>Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById(`deleteForm-${id}`).submit();
        }
    });
}
</script>
@endsection
