@extends("base-admin")

@section("title", "Dashboard")

@section("content")
    <div class="main-content">
        <h1 class="h3 mb-4">Kriteria</h1>

        <!-- Charts Row -->
        <div class="row mb-2">
            <div class="col-xl-4 mb-4">
                <div class="card fade-in" style="animation-delay: 0.4s">
                    <div class="card-body">
                        @error("error")
                        <div class="alert alert-danger" role="alert">
                            {{ $message }}
                        </div>
                        @enderror
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        <form id="form-submit" action="{{ route("criteria.submit") }}" method="POST">
                            @csrf
                            {{--                            <input type="text" name="id">--}}
                            <div class="mb-2">
                                <label for="name" class="form-label">Nama</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old("name") }}">
                                @if($errors->has('name'))
                                    <div id="name" class="form-text text-danger">
                                        {{ $errors->first('name') }}
                                    </div>
                                @endif
                            </div>
                            <div class="mb-2">
                                <label for="value" class="form-label">Bobot (%)</label>
                                <input type="number" class="form-control" id="value" name="value" placeholder="0 - 100"
                                       value="{{ old("value") }}">
                                @if($errors->has('value'))
                                    <div id="value" class="form-text text-danger">
                                        {{ $errors->first('value') }}
                                    </div>
                                @endif
                            </div>
                            <button type="submit" id="save" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 mb-4">
                <div class="card fade-in" style="animation-delay: 0.4s">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">List Kriteria</h5>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Bobot (%)</th>
                                <th scope="col">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i = 1)
                            @foreach($criterias as $criteria)
                                <tr>
                                    <th scope="row">{{ $i }}</th>
                                    <td data-name="name">{{ $criteria->name }}</td>
                                    <td data-name="value">{{ $criteria->value }}</td>
                                    <td>
                                        <button data-id="{{ $criteria->id }}" class="btn btn-sm btn-warning edit"
                                                data-bs-toggle="modal" data-bs-target="#edit-criteria"><i
                                                class="fas fa-edit"></i></button>
                                        <button data-id="{{ $criteria->id }}" class="btn btn-sm btn-danger delete"><i
                                                class="fas fa-trash"></i></button>
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
    <div class="modal fade" id="edit-criteria" tabindex="-1" aria-labelledby="edit-criteria" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Kriteria</h5>
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
                        <div class="mb-2">
                            <label for="value" class="form-label">Bobot (%)</label>
                            <input type="number" class="form-control" id="edit-value" name="value" placeholder="0 - 100">
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

@section("script")
    <script>
        $(document).ready(function () {
            // Tampilkan overlay saat form disubmit
            $('#form-submit').on('submit', function () {
                $('#loading-overlay').css('display', 'flex');
                $('#loading-overlay').fadeIn();
            });

            // // (Opsional) Untuk semua link atau tombol yang punya data-loading="true"
            // $('[data-loading="true"]').on('click', function () {
            //     $('#loading-overlay').fadeIn();
            // });

            $('.edit').on('click', function () {
                let id = $(this).data('id');
                $.get('/criteria/' + id, function (data) {
                    $('#edit-id').val(data.id);
                    $('#edit-name').val(data.name);
                    $('#edit-value').val(data.value);
                })
            });

            $('#edit-form').submit(function (e) {
                e.preventDefault();
                $('#loading-overlay').css('display', 'flex');
                $('#loading-overlay').fadeIn();
                let id = $('#edit-id').val();
                $.ajax({
                    url: '/criteria/' + id,
                    method: 'POST',
                    data : $(this).serialize(),
                    success: function (res) {
                        alert("Update data berhasil !");
                        $('#edit-criteria').hide();
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
                    url: '/criteria/' + id + '/delete',
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
