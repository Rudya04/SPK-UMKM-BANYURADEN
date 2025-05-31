@extends("base-admin")

@section("title", "Dashboard")

@section("content")
    <div class="main-content">
        <div class="d-flex justify-content-between">
            <h1 class="h3 mb-4">Detail Perankingan</h1>
            @role('admin')
            <section>
                <a href="{{ route('ranking.export', [ 'reference_code' => $referenceCode]) }}" class="btn btn-primary">Export</a>
            </section>
            @endrole
        </div>

        <!-- Charts Row -->
        <div class="row mb-2">
            <div class="col-xl-4 mb-4">
                <div class="card fade-in" style="animation-delay: 0.4s">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Nilai Bobot</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper">
                            <table class="table">
                                <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Nama</th>
                                    <th>Bobot</th>
                                    <th>Bobot Normal</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i = 1)
                                @foreach($normalizations as $normal)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{ $normal['criteria_name'] }}</td>
                                        <td>{{ $normal['value'] }}</td>
                                        <td>{{ $normal['bobot_normal'] }}</td>
                                    </tr>
                                    @php($i++)
                                @endforeach
                                <!-- Tambahkan baris lain di sini -->
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-8 mb-4">
                <div class="card fade-in" style="animation-delay: 0.4s">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Nilai Dasar</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper">
                            <table class="table">
                                <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Alternative</th>
                                    @foreach($bobots as $bobot)
                                        <th>{{ $bobot->criteria_name }}</th>
                                    @endforeach
                                </tr>
                                </thead>
                                <tbody>
                                @php($i = 1)
                                @foreach($datas as $data)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{ $data['alternative_name'] }}</td>
                                        @foreach($data['current_criterias'] as $criteria)
                                            <td>{{ $criteria['sub_criteria_value'] }}</td>
                                        @endforeach
                                    </tr>
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
        <div class="row mb-2">
            <div class="col-xl-12 mb-4">
                <div class="card fade-in" style="animation-delay: 0.4s">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">Nilai Ranking</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-wrapper">
                            <table class="table">
                                <thead class="table-dark">
                                <tr>
                                    <th>#</th>
                                    <th>Alternative</th>
                                    @foreach($bobots as $bobot)
                                        <th>{{ $bobot->criteria_name }}</th>
                                    @endforeach
                                    <th>Score</th>
                                    <th>Status</th>
                                </tr>
                                </thead>
                                <tbody>
                                @php($i = 1)
                                @foreach($datas as $data)
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{ $data['alternative_name'] }}</td>
                                        @foreach($data['current_criterias'] as $criteria)
                                            <td>{{ $criteria['score'] }}</td>
                                        @endforeach
                                        <td>{{ $data['score'] }}</td>
                                        <th>{{ $data['status'] }}</th>
                                    </tr>
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
@endsection
