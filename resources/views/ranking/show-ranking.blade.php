@extends("base-admin")

@section("title", "Dashboard")

@section("content")
    <div class="main-content">
        <h1 class="h3 mb-4">Perankingan {{$form->title}}</h1>

        <!-- Charts Row -->
        <div class="row mb-2">
            <div class="col-xl-12 mb-4">
                <div class="card fade-in" style="animation-delay: 0.4s">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <div>
                            <h5 class="card-title mb-2">List Perankingan</h5>
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
                            <a href="#" id="find-criteria" data-bs-toggle="modal" data-bs-target="#list-criteria"><span
                                    class="badge bg-secondary">Lihat Bobot</span></a>
                        </div>
                        <a href="{{ route('ranking.calculation', ['reference_code' => $form->code]) }}" class="btn btn-primary float-left text-white">Hitung Ranking</a>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper">
                            <table class="table">
                                <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Alternative</th>
                                    <th>Criteria</th>
                                    <th>Bobot</th>
                                    <th>Sub Criteria</th>
                                    <th>Nilai</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i = 1)
                                @foreach($form->user_rankings as $ranking)
                                    @php($count = count($ranking->rankings))
                                    @php($j = 1)
                                    @foreach($ranking->rankings as $rank)
                                        <tr>
                                            @if($j == 1)
                                                <td rowspan="{{ $count }}">{{ $i }}</td>
                                                <td rowspan="{{ $count }}">{{ $ranking->alternative->name }}</td>
                                            @endif
                                            <td>{{ $rank->criteria->name }}</td>
                                            <td>{{ $rank->criteria->value }}</td>
                                            <td>{{ $rank->sub_criteria->name }}</td>
                                            <td>{{ $rank->sub_criteria->value }}</td>
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
        });
    </script>
@endsection
