@extends("base-admin")

@section("title", "Dashboard")

@section("content")
    <div class="main-content">
        <h1 class="h3 mb-4">Formulir {{$form->title}}</h1>

        <!-- Charts Row -->
        <div class="row mb-2">
            <div class="col-xl-4 mb-4">
                <div class="card fade-in" style="animation-delay: 0.4s">
                    <div class="card-body">
                        @if ($errors->has('error'))
                            <div class="alert alert-danger">
                                {{ $errors->first('error') }}
                            </div>
                        @endif
                        @if(session('success'))
                            <div class="alert alert-success" role="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                        @unlessrole('admin')
                        <form id="form-submit" action="{{ route("ranking.submit") }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <input type="hidden" class="form-control" name="form_id"
                                       value="{{ $form->id }}">
                                <input type="hidden" class="form-control" name="alternative_id"
                                       value="{{ $alternative->id }}">
                                <label for="alternative" class="form-label">Nama Alternative</label>
                                <input type="text" class="form-control" id="alternative" name="alternative"
                                       value="{{ $alternative->pengusaha->email }}" readonly disabled>
                            </div>
                            @foreach($criterias as $criteria)
                                <div class="mb-2">
                                    <label for="{{ $criteria->slug }}" class="form-label">{{ $criteria->name }}</label>
                                    <select class="form-select" id="criteria_id" name="data[{{ $criteria->slug }}]">
                                        <option value="">-- Pilih {{ $criteria->name }} --</option>
                                        @foreach ($criteria->subCriterias as $sub)
                                            <option
                                                value="{{ $sub->id }}" {{ old($criteria->slug) == $sub->id ? 'selected' : '' }}>
                                                {{ $sub->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @if($errors->has("data.$criteria->slug"))
                                        <div id="data[{{ $criteria->slug }}]" class="form-text text-danger">
                                            {{ $errors->first("data.$criteria->slug" ) }}
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            @if(count($rankings) <= 0)
                                <button type="submit" class="btn btn-primary">Tambah</button>
                            @endif
                        </form>
                        @endunlessrole
                    </div>
                </div>
            </div>

            <div class="col-xl-8 mb-4">
                <div class="card fade-in" style="animation-delay: 0.4s">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-2">List Perankingan</h5>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper">
                            <table class="table">
                                <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Alternative</th>
                                    <th>Criteria</th>
                                    @role('admin')
                                    <th>Bobot</th>
                                    @endrole
                                    <th>Sub Criteria</th>
                                    @role('admin')
                                    <th>Nilai</th>
                                    @endrole
                                    <th>Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i = 1)
                                @foreach($rankings as $ranking)
                                    @php($count = count($ranking->rankings))
                                    @php($j = 1)
                                    @foreach($ranking->rankings as $rank)
                                        <tr>
                                            @if($j == 1)
                                                <td rowspan="{{ $count }}">{{ $i }}</td>
                                                <td rowspan="{{ $count }}">{{ $ranking->alternative->name }}</td>
                                            @endif
                                            <td>{{ $rank->criteria->name }}</td>
                                            @role('admin')
                                            <td>{{ $rank->criteria->value }}</td>
                                            @endrole
                                            <td>{{ $rank->sub_criteria->name }}</td>
                                            @role('admin')
                                            <td>{{ $rank->sub_criteria->value }}</td>
                                            @endrole
                                            @if($j == 1)
                                                <td rowspan="{{ $count }}">
                                                    <button data-id="{{ $ranking->id }}"
                                                            class="btn btn-sm btn-warning mb-1 edit"
                                                            data-bs-toggle="modal" data-bs-target="#edit-ranking"><i
                                                            class="fas fa-edit"></i></button>
                                                    <button data-id="{{ $ranking->id }}"
                                                            class="btn btn-sm btn-danger delete"><i
                                                            class="fas fa-trash"></i></button>
                                                </td>
                                            @endif
                                        </tr>
                                        @php($j++)
                                    @endforeach
                                    @php($i++)
                                @endforeach
                                <!-- Tambahkan baris lain di sini -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!-- Modal -->
    <div class="modal fade" id="edit-ranking" tabindex="-1" aria-labelledby="edit-ranking" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Ranking</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="edit-form">
                    <div class="modal-body">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="edit-id">
                        <div class="mb-2">
                            <input type="hidden" class="form-control" name="form_id"
                                   value="{{ $form->id }}">
                            <input type="hidden" class="form-control" id="alternative_id" name="alternative_id"
                                   value="{{ $alternative->id }}">
                            <label for="alternative" class="form-label">Nama Alternative</label>
                            <input type="text" class="form-control" id="alternative" name="alternative"
                                   value="{{ $alternative->pengusaha->email }}" readonly disabled>
                        </div>
                        @foreach($criterias as $criteria)
                            <div class="mb-2">
                                <label for="{{ $criteria->slug }}" class="form-label">{{ $criteria->name }}</label>
                                <select class="form-select edit-criteria" id="edit-criteria_id-{{ $criteria->id }}"
                                        name="edit-data[{{ $criteria->slug }}]">
                                    <option value="">-- Pilih {{ $criteria->name }} --</option>
                                    @foreach ($criteria->subCriterias as $sub)
                                        <option
                                            value="{{ $sub->id }}" {{ old($criteria->slug) == $sub->id ? 'selected' : '' }}>
                                            {{ $sub->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        @endforeach
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal List -->
    <div class="modal fade" id="list-criteria" tabindex="-1" aria-labelledby="list-criteria" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">List Criteria</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Nama</th>
                            <th scope="col">Bobot</th>
                            <th scope="col">Bobot Normal</th>
                        </tr>
                        </thead>
                        <tbody id="criterias">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
    <script>
        $(document).ready(function () {
            $('#form-submit').on('submit', function () {
                $('#loading-overlay').css('display', 'flex');
                $('#loading-overlay').fadeIn();
            });

            $('#find-criteria').on('click', function (e) {
                e.preventDefault();
                $.get('/ranking/criteria', function (data) {
                    let tbody = $('#criterias');
                    tbody.empty();
                    let totalBobotNormal = 0;
                    data.forEach(function (item, index) {
                        totalBobotNormal += item.bobot_normal;
                        let row = `<tr>
                                    <td>${index + 1}</td>
                                    <td>${item.name}</td>
                                    <td>${item.value}</td>
                                    <td>${item.bobot_normal}</td>
                                  </tr>`;
                        tbody.append(row);
                    })
                    let totalRow = `<tr>
                                          <td colspan="3"><strong>Total Bobot Normal</strong></td>
                                          <td><strong>${totalBobotNormal}</strong></td>
                                        </tr>`;
                    tbody.append(totalRow);

                })
            })

            $('.edit').on('click', function () {
                let id = $(this).data('id');
                $.get('/ranking/rank/' + id, function (data) {
                    $('#edit-id').val(data.id)
                    $('#edit-alternative_id').val(data.alternative_id)
                    $.each(data.rankings, function (index, item) {
                        $('#edit-criteria_id-' + item.criteria_id).val(item.sub_criteria_id)
                    })
                })
            });

            $('#edit-form').submit(function (e) {
                e.preventDefault();
                $('#loading-overlay').css('display', 'flex');
                $('#loading-overlay').fadeIn();
                let id = $('#edit-id').val();
                $.ajax({
                    url: '/ranking/rank/' + id,
                    method: 'POST',
                    data: $(this).serialize(),
                    success: function (res) {
                        alert("Update data berhasil !");
                        $('#edit-ranking').hide();
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
                    url: '/ranking/rank/' + id + '/delete',
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
