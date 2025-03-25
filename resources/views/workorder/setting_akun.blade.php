@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Setting Akun</h1>

    <!-- Button Tambah Akun -->
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#addUserModal">Tambah Akun</button>

    <!-- Filter -->
<div class="d-flex mb-3">
    <input type="text" id="searchInput" class="form-control me-2" placeholder="Cari akun..." style="max-width: 300px;">
    <select id="filterColumn" class="form-select" style="max-width: 200px;">
        <option value="all">Cari di semua kolom</option>
        <option value="name">Nama</option>
        <option value="username">Username</option>
        <option value="role">Role</option>
    </select>
</div>


    <!-- Tabel Akun -->
    <table class="table table-bordered " id="userTable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Username</th>
                <th>Role</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($users as $user)
            <tr>
                <td>{{ $user->id }}</td>
                <td>{{ $user->name }}</td>
                <td>{{ $user->username }}</td>
                <td>{{ ucfirst($user->role) }}</td>
                <td>
                    <!-- Edit -->
                    <button class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">Edit</button>

                    <!-- Reset Password -->
                    <form action="{{ route('setting_akun.reset_password', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Reset password user ini ke default?');">
                        @csrf
                        <button type="submit" class="btn btn-secondary btn-sm">Reset Password</button>
                    </form>

                    <!-- Hapus -->
                    <form action="{{ route('setting_akun.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Yakin ingin menghapus akun ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </td>
            </tr>

            <!-- Modal Edit Akun -->
            <div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Edit Akun</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('setting_akun.update', $user->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="mb-3">
                                    <label>Nama</label>
                                    <input type="text" name="name" class="form-control" value="{{ $user->name }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Username</label>
                                    <input type="text" name="username" class="form-control" value="{{ $user->username }}" required>
                                </div>
                                <div class="mb-3">
                                    <label>Role</label>
                                    <select name="role" class="form-select">
                                        <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>User</option>
                                        <option value="executor" {{ $user->role == 'executor' ? 'selected' : '' }}>Executor</option>
                                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label>Password (Kosongkan jika tidak ingin mengubah)</label>
                                    <input type="password" name="password" class="form-control">
                                </div>

                                <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </tbody>
    </table>
</div>

<!-- Modal Tambah Akun -->
<div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('setting_akun.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label>Nama</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Username</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Role</label>
                        <select name="role" class="form-select">
                            <option value="user">User</option>
                            <option value="executor">Executor</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" required>
                    </div>

                    <button type="submit" class="btn btn-success">Tambah Akun</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Script untuk Filter Pencarian -->
<script>
    document.getElementById('searchInput').addEventListener('keyup', function() {
        let filter = this.value.toLowerCase();
        let column = document.getElementById('filterColumn').value;
        let rows = document.querySelectorAll('#userTable tbody tr');

        rows.forEach(row => {
            let cells = row.getElementsByTagName('td');
            let found = false;

            for (let i = 0; i < cells.length; i++) {
                if (column === 'all' || column === ['id', 'name', 'username', 'role'][i]) {
                    if (cells[i].innerText.toLowerCase().includes(filter)) {
                        found = true;
                    }
                }
            }
            row.style.display = found ? '' : 'none';
        });
    });
</script>
@endsection
