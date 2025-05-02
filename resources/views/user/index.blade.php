@extends("base-admin")

@section("title", "Dashboard")

@section("content")
    <div class="main-content">
        <h1 class="h3 mb-4">Pengguna</h1>

        <!-- Charts Row -->
        <div class="row mb-2">

            <div class="col-xl-12 mb-4">
                <div class="card fade-in" style="animation-delay: 0.4s">
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Role</th>
                                <th scope="col">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i = 1)
                            @foreach($users as $user)
                                <tr>
                                    <th scope="row">{{ $i }}</th>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->roles->first()->name }}</td>
                                    <td>
                                        @if(!$user->is_admin)
                                            <button data-id="{{ $user->id }}" class="btn btn-sm btn-warning edit"
                                                    data-bs-toggle="modal" data-bs-target="#edit-alternative"><i
                                                    class="fas fa-edit"></i></button>
                                            <button data-id="{{ $user->id }}" class="btn btn-sm btn-danger delete"><i
                                                    class="fas fa-trash"></i></button>
                                        @endif
                                    </td>
                                </tr>
                                @php($i++)
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="edit-alternative" tabindex="-1" aria-labelledby="edit-alternative" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Alternative</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-form">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit-id">
                        <div class="mb-2">
                            <label for="name" class="form-label">Nama</label>
                            <input type="text" class="form-control" id="edit-name" name="name">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            // Tampilkan overlay saat form disubmit
            $('#form-submit').on('submit', function () {
                $('#loading-overlay').css('display', 'flex');
                $('#loading-overlay').fadeIn();
            });

            $('.edit').on('click', function () {
                let id = $(this).data('id');
                $.get('/alternative/' + id, function (data) {
                    $('#edit-id').val(data.id)
                    $('#edit-name').val(data.name)
                })
            });

            $('#edit-form').submit(function (e) {
                e.preventDefault();
                $('#loading-overlay').css('display', 'flex');
                $('#loading-overlay').fadeIn();
                let id = $('#edit-id').val();
                $.ajax({
                    url: '/alternative/' + id,
                    method: 'POST',
                    data : $(this).serialize(),
                    success: function (res) {
                        alert("Update data berhasil !");
                        $('#edit-alternative').hide();
                        location.reload();
                    },
                    error: function (res) {
                        alert(res.responseJSON.errorFirst);
                        $('#loading-overlay').css('display', 'none');
                        $('#loading-overlay').fadeOut();
                    }
                })
            })

            $('.delete').on('click', function () {
                if (!confirm('Yakin ingin menghapus data ini?')) return;
                $('#loading-overlay').css('display', 'flex');
                $('#loading-overlay').fadeIn();
                let id = $(this).data('id');
                $.ajax({
                    url: '/alternative/' + id + '/delete',
                    method: 'GET',
                    success: function (res) {
                        alert("Hapus data berhasil !");
                        location.reload();
                    },
                    error: function (res) {
                        alert('Gagal menghapus data.');
                        $('#loading-overlay').css('display', 'none');
                        $('#loading-overlay').fadeOut();
                    }
                })
            })
        });
    </script>
@endsection
