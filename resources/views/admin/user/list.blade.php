<div class="page-content">
    <!-- -----header-breadcrumb-start-- -->
    <div class="header-breadcrumb">
        <h5>Interest and hobbies</h5>
        <nav style="--bs-breadcrumb-divider: '/';" aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('dashboard')}}">Dashboard</a></li>
                <li class="breadcrumb-item active" aria-current="page">Users</li>
            </ol>
        </nav>
    </div>
    <!-- -----header-breadcrumb-end-- -->
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Users</div>
            <div class="card-body">
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
</div>

@push('scripts')
{{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush