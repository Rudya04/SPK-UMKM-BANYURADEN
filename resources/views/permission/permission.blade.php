@extends("base-admin")

@section("title", "Dashboard")

@section("content")
    <div class="main-content">
        <h1 class="h3 mb-4">Pengaturan Perijinan</h1>

        <!-- Dashboard Stats -->
        <div class="container-fluid">
            <div class="row">
                <div class="btn-group nav nav-tabs" id="myTab" role="tablist">
                    @php $i = 0; @endphp
                    @foreach($roles as $role)
                        <button class="btn btn-outline-secondary btn-sm <?= $i == 0 ? "active" : ""?>"
                                id="<?= $role['name']?>-tab" data-bs-toggle="tab"
                                data-bs-target="#<?= $role['name']?>">{{ $role['name'] }}
                        </button>
                        @php $i += 1; @endphp
                    @endforeach
                </div>
            </div>
            <div class="card fade-in mt-3" style="animation-delay: 0.5s">
                <div class="tab-content border border-top-0 p-3" id="myTabContent">
                    @php $j = 0; @endphp
                    @foreach($roles as $role)
                        <div class="card-body tab-pane fade show <?= $j == 0 ? "show active" : ""?>"
                             id="<?= $role['name']?>" role="tabpanel"
                             aria-labelledby="<?= $role['name']?>-tab">
                            <div class="row mb-3">
                                @for($k = 0;  $k < count($role['groups']); $k++)
                                    <span>{{ $role['groups'][$k] }}</span>
                                    @foreach($role['permissions'] as $permission)
                                        <div class="col-lg-3">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" value=""
                                                       id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">
                                                    Default checkbox
                                                </label>
                                            </div>
                                        </div>
                                    @endforeach
                                @endfor
                            </div>
                        </div>
                        @php $j += 1; @endphp
                    @endforeach
                </div>
            </div>
        </div>
    </div>
@endsection
