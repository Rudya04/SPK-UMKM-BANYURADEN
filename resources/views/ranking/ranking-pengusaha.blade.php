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
                    </div>
{{--                    @dd($curentUserRanking);--}}
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Tanggal</th>
                                <th scope="col">Title</th>
                                <th scope="col">Nama</th>
                                <th scope="col">Score</th>
                                <th scope="col">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @php($i = 1)
                            @foreach($curentUserRanking as $userRanking)
                                <tr>
                                    <th scope="row">{{ $i }}</th>
                                    <td>{{ $userRanking['created_at'] }}</td>
                                    <td>{{ $userRanking['title'] }}</td>
                                    <td>{{ $userRanking['name'] }}</td>
                                    <td>{{ $userRanking['score_akhir'] }}</td>
                                    <td>{{ $userRanking['status'] }}</td>
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
