@extends("base-admin")

@section("title", "Dashboard")

@section("content")
    <div class="main-content">
        <h1 class="h3 mb-4">Sub Kriteria</h1>

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
                        <form action="{{ route("sub-criteria.submit") }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <select class="form-select" name="criteria_id">
                                    <option value="">-- Pilih Kriteria --</option>
                                    @foreach ($criterias as $criteria)
                                        <option value="{{ $criteria->id }}" {{ old('criteria_id') == $criteria->id ? 'selected' : '' }}>
                                            {{ $criteria->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @if($errors->has('criteria_id'))
                                    <div id="criteria_id" class="form-text text-danger">
                                        {{ $errors->first('criteria_id') }}
                                    </div>
                                @endif
                            </div>
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
                                <label for="value" class="form-label">Nilai</label>
                                <input type="number" class="form-control" id="value" name="value" placeholder="1 - 100" value="{{ old("value") }}">
                                @if($errors->has('value'))
                                    <div id="value" class="form-text text-danger">
                                        {{ $errors->first('value') }}
                                    </div>
                                @endif
                            </div>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </form>
                    </div>
                </div>
            </div>

            <div class="col-xl-8 mb-4">
                <div class="card fade-in" style="animation-delay: 0.4s">
                    <div class="card-header bg-white border-0 d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0">List Sub Kriteria</h5>
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
                            @php($i = 1)
                            @foreach($subCriterias as $subCriteria)
                                <tr>
                                    <th scope="row">{{ $i }}</th>
                                    <td>{{ $subCriteria->name }}</td>
                                    <td>{{ $subCriteria->value }}</td>
                                    <td>{{ $subCriteria->criteria->name }}</td>
                                    <td>{{ $subCriteria->criteria->value }}</td>
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
