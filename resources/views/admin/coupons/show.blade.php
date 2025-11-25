<x-admin-layout title="Show Coupon">
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Show Coupon</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="{{ route('admin.coupons.index') }}" class="btn btn-sm btn-outline-secondary">
                    Back
                </a>
            </div>
        </div>

        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Code:</strong>
                    {{ $coupon->code }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Type:</strong>
                    {{ $coupon->type }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Value:</strong>
                    {{ $coupon->value }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Expires At:</strong>
                    {{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : 'N/A' }}
                </div>
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12">
                <div class="form-group">
                    <strong>Is Active:</strong>
                    {{ $coupon->is_active ? 'Yes' : 'No' }}
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
