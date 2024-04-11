<!-- -----header-breadcrumb-start-- -->

<div class="page-content">
    <div class="header-breadcrumb">
        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Feedback Review List</li>
            </ol>
        </nav>
    </div>
    <!-- -----header-breadcrumb-end-- -->


    <div class="">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Feedback Review List</h4>
                <a href="{{route('feedbackreviewlist.create')}}" class="btn btn-primary text-right">Add</a>
            </div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>

</div>
@push('scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush