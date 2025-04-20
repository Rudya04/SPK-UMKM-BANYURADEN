@extends("base-admin")

@section("title", "Dashboard")

@section("content")
    <div class="main-content">
        <h1 class="h3 mb-4">Perankingan</h1>

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
                        <form action="{{ route("ranking.submit") }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <label for="alternative_id" class="form-label">Alternative</label>
                                <select class="form-select" id="alternative_id" name="alternative_id">
                                    <option value="">-- Pilih Alternative --</option>
                                    @foreach ($alternatives as $alternative)
                                        <option
                                            value="{{ $alternative->id }}" {{ old('alternative_id') == $alternative->id ? 'selected' : '' }}>
                                            {{ $alternative->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($errors->has('alternative_id'))
                                    <div id="alternative_id" class="form-text text-danger">
                                        {{ $errors->first('alternative_id') }}
                                    </div>
                                @endif
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
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 mb-4">
                <div class="card fade-in" style="animation-delay: 0.4s">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">List Perankingan</h5>
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
                                            <td>{{ $rank->criteria->value }}</td>
                                            <td>{{ $rank->sub_criteria->name }}</td>
                                            <td>{{ $rank->sub_criteria->value }}</td>
                                            @if($j == 1)
                                                <td rowspan="{{ $count }}">
                                                    <button class="btn btn-sm btn-primary">Edit</button>
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
@endsection
