@extends("base-admin")

@section("title", "Dashboard")

@section("content")
    <div class="main-content">
        <div class="d-flex justify-content-between">
            <h1 class="h3 mb-4">Detail Perankingan</h1>
            <section>
                <a href="{{ route('ranking.export', [ 'reference_code' => $referenceCode]) }}" class="btn btn-primary">Export</a>
            </section>
        </div>
        <form method="GET">
            <div class="row my-4">
                <div class="col-12 p-2 border rounded">
                    <div class="d-flex flex-row gap-4 mb-2">
                        @foreach ($bobots as $bobot)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="filter_kriteria[]" value="{{ $bobot->criteria_name }}"
                                    {{ in_array($bobot->criteria_name, $selectedKriteria ?? []) ? 'checked' : '' }}>
                                <label class="form-check-label">
                                    {{ $bobot->criteria_name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <section class="my-4 d-flex justify-content-start">
                        <button type="submit" class="btn btn-sm btn-primary">Filter</button>
                    </section>
                </div>
            </div>
        </form>


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
                                @php($total = 0)
                                @foreach($normalizations as $normal)
                                    @php($total = $total + $normal['bobot_normal'])
                                    <tr>
                                        <td>{{$i}}</td>
                                        <td>{{ $normal['criteria_name'] }}</td>
                                        <td>{{ $normal['value'] }}</td>
                                        <td>{{ $normal['bobot_normal'] }}</td>
                                    </tr>
                                    @php($i++)
                                @endforeach
                                <tr>
                                    <td class="text-center font-bold" colspan="3"><b>Jumlah</b></td>
                                    <td class="font-bold"><b>{{ $total }}</b></td>
                                </tr>
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
                                    @if(isset($datas[0]))
                                        @foreach ($datas[0]['current_criterias'] as $criteria)
                                            <th>{{ $criteria['criteria_name'] }}</th>
                                        @endforeach
                                    @endif
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
                                    @if(isset($datas[0]))
                                        @foreach ($datas[0]['current_criterias'] as $criteria)
                                            <th>{{ $criteria['criteria_name'] }}</th>
                                        @endforeach
                                    @endif
                                    <th>Score</th>
                                    <th>Score Akhir</th>
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
                                        <td>{{ $data['score_akhir'] }}</td>
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
