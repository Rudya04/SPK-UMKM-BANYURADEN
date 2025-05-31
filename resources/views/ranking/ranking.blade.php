@extends("base-admin")

@section("title", "Dashboard")

@section("content")
    <div class="main-content">
        <!-- Charts Row -->
        <div class="row mb-2">

            <div class="col-xl-12 mb-4">
                <div class="card fade-in" style="animation-delay: 0.4s">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">History Ranking</h5>
                        <a href="{{ route('ranking.save') }}" class="btn btn-primary float-left">Buat Ranking</a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Title</th>
                                <th scope="col">Aksi</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i = 1)
                            @foreach($curentUserRanking as $userRanking)
                                <tr>
                                    <th scope="row">{{ $i }}</th>
                                    <td>{{ $userRanking->created_at }}</td>
                                    <td>{{ $userRanking->title }}</td>
                                    <td>
                                        <a href="{{ route('ranking.show', ['reference_code' => $userRanking->reference_code]) }}"><span class="badge bg-primary">Detail</span></a>
                                        <a href="{{ route('ranking.export', ['reference_code' => $userRanking->reference_code]) }}"><span class="badge bg-info">Export</span></a>
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
@endsection
