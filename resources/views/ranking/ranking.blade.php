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
                        <form action="{{ route("sub-criteria.submit") }}" method="POST">
                            @csrf
                            <div class="mb-2">
                                <label for="criteria_id" class="form-label">Alternative</label>
                                <select class="form-select" id="criteria_id" name="criteria_id">
                                    <option value="">-- Pilih Alternative --</option>
{{--                                    @foreach ($criterias as $criteria)--}}
{{--                                        <option value="{{ $criteria->id }}" {{ old('criteria_id') == $criteria->id ? 'selected' : '' }}>--}}
{{--                                            {{ $criteria->name }}--}}
{{--                                        </option>--}}
{{--                                    @endforeach--}}
                                </select>
                                @if($errors->has('criteria_id'))
                                    <div id="criteria_id" class="form-text text-danger">
                                        {{ $errors->first('criteria_id') }}
                                    </div>
                                @endif
                            </div>
                            <div class="mb-2">
                                <label for="criteria_id" class="form-label">Modal</label>
                                <select class="form-select" id="criteria_id" name="criteria_id">
                                    <option value="">-- Pilih Modal --</option>
                                    {{--                                    @foreach ($criterias as $criteria)--}}
                                    {{--                                        <option value="{{ $criteria->id }}" {{ old('criteria_id') == $criteria->id ? 'selected' : '' }}>--}}
                                    {{--                                            {{ $criteria->name }}--}}
                                    {{--                                        </option>--}}
                                    {{--                                    @endforeach--}}
                                </select>
                                @if($errors->has('criteria_id'))
                                    <div id="criteria_id" class="form-text text-danger">
                                        {{ $errors->first('criteria_id') }}
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
