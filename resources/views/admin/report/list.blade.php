<div class="page-content">
    <!-- -----header-breadcrumb-start-- -->
    <div class="header-breadcrumb">
        <!-- <h5>Interest and hobbies</h5> -->
        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">User Report</li>
            </ol>
        </nav>
    </div>
    <!-- -----header-breadcrumb-end-- -->
    <div class="">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title">Users Report</h4>
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