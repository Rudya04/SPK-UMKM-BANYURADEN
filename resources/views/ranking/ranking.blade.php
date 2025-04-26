@extends("base-admin")

@section("title", "Dashboard")

@section("content")
    <div class="main-content">
        <!-- Charts Row -->
        <div class="row mb-2">

            <div class="col-xl-12 mb-4">
                <div class="card fade-in" style="animation-delay: 0.4s">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">List Ranking</h5>
                        <a href="{{ route('ranking.save') }}" class="btn btn-primary float-left">Buat Ranking</a>
                    </div>
                    <div class="card-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Sub Name</th>
                                <th scope="col">Nilai</th>
                                <th scope="col">Name</th>
                                <th scope="col">Bobot</th>
                            </tr>
                            </thead>
                            <tbody>
{{--                            @php($i = 1)--}}
{{--                            @foreach($criterias as $criteria)--}}
{{--                                <tr>--}}
{{--                                    <th scope="row">{{ $i }}</th>--}}
{{--                                    <td>{{ $criteria->name }}</td>--}}
{{--                                    <td>{{ $criteria->value }}</td>--}}
{{--                                    <td>{{ $criteria->criteria->name }}</td>--}}
{{--                                    <td>{{ $criteria->criteria->value }}</td>--}}
{{--                                </tr>--}}
{{--                                @php($i++)--}}
{{--                            @endforeach--}}
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
