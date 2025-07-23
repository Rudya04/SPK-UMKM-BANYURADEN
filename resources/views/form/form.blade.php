@extends("base-admin")

@section("title", "Dashboard")

@section("content")
    <div class="main-content">
        <!-- Charts Row -->
        <div class="row mb-2">

            <div class="col-xl-12 mb-4">
                <div class="card fade-in" style="animation-delay: 0.4s">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Daftar Formulir</h5>
                        @role('admin')
                        <button class="btn btn-sm btn-primary"
                                data-bs-toggle="modal" data-bs-target="#tambah-form">Tambah Formulir
                        </button>
                        @endrole
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Title</th>
                                <th scope="col">Batas Pengisian</th>
                                @role('admin')
                                <th scope="col">Bagikan Link</th>
                                @endrole
                                <th scope="col">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i = 1)
                            @foreach($forms as $form)
                                <tr>
                                    <th scope="row">{{ $i }}</th>
                                    <td data-name="created_at">{{ $form->created_at }}</td>
                                    <td data-name="title">{{ $form->title }}</td>
                                    <td data-name="expired_at">{{ $form->expired_date }}</td>
                                    @role('admin')
                                    <td>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="linkInput"
                                                   value="https://example.com/my-link" readonly>
                                            <button class="btn btn-outline-secondary" type="button" id="copyButton">
                                                Copy
                                            </button>
                                        </div>
                                        <!-- Feedback -->
                                        <div id="copyFeedback" class="text-success small mt-1" style="display: none;">
                                            Link berhasil disalin!
                                        </div>
                                    </td>
                                    @endrole
                                    <td>
                                        @role('admin')
                                        <a href="{{ route('ranking.show-detail', [ 'reference_code' => $form->code]) }}"
                                           class="btn btn-sm btn-info view"><i
                                                class="fas fa-eye"></i></a>
                                        <button data-id="{{ $form->id }}" class="btn btn-sm btn-warning edit"
                                                data-bs-toggle="modal" data-bs-target="#edit-criteria"><i
                                                class="fas fa-edit"></i></button>
                                        <button data-id="{{ $form->id }}" class="btn btn-sm btn-danger delete"><i
                                                class="fas fa-trash"></i></button>
                                        @endrole
                                        @unlessrole('admin')
                                        <a href="{{ route('ranking.save', [ 'reference_code' => $form->code]) }}"
                                           class="btn btn-sm btn-info view"><i
                                                class="fas fa-eye"></i></a>
                                        @endunlessrole
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
    <div class="modal fade" id="tambah-form" tabindex="-1" aria-labelledby="tambah-form" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Formulir</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('ranking.form-create') }}" method="POST">
                    <div class="modal-body">
                        @csrf
                        <input type="hidden" id="edit-id">
                        <div class="mb-2">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control" id="title" name="title">
                        </div>
                        <div class="mb-2">
                            <label for="expired_date" class="form-label">Batas Pengisian</label>
                            <input type="date" class="form-control" id="expired_date" name="expired_date">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script>
        document.getElementById('copyButton').addEventListener('click', function () {
            const input = document.getElementById('linkInput');
            input.select();
            input.setSelectionRange(0, 99999);

            navigator.clipboard.writeText(input.value).then(function () {
                const feedback = document.getElementById('copyFeedback');
                feedback.style.display = 'block';
                setTimeout(() => feedback.style.display = 'none', 2000);
            }).catch(function (err) {
                console.error('Gagal menyalin: ', err);
            });
        });
    </script>

@endsection
