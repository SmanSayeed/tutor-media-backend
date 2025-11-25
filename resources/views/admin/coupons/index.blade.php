<x-admin-layout title="Coupons">
    <div class="container">
        <div class="flex justify-between items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Coupons</h1>
            <div class="btn-toolbar mb-2 mb-md-0">
                <a href="{{ route('admin.coupons.create') }}" class="btn btn-sm btn-outline-secondary">
                    Add Coupon
                </a>
            </div>
        </div>

        @if ($message = Session::get('success'))
            <div class="alert alert-success">
                <p>{{ $message }}</p>
            </div>
        @endif

        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Code</th>
                        <th>Type</th>
                        <th>Value</th>
                        <th>Expires At</th>
                        <th>Active</th>
                        <th width="280px">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($coupons as $coupon)
                        <tr>
                            <td>{{ $coupon->id }}</td>
                            <td>{{ $coupon->code }}</td>
                            <td>{{ $coupon->type }}</td>
                            <td>{{ $coupon->value }}</td>
                            <td>{{ $coupon->expires_at ? $coupon->expires_at->format('Y-m-d') : 'N/A' }}</td>
                            <td>{{ $coupon->is_active ? 'Yes' : 'No' }}</td>
                            <td>
                                <form action="{{ route('admin.coupons.destroy',$coupon->id) }}" method="POST">
                                    <a class="btn btn-info" href="{{ route('admin.coupons.show',$coupon->id) }}">Show</a>
                                    <a class="btn btn-primary" href="{{ route('admin.coupons.edit',$coupon->id) }}">Edit</a>
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {!! $coupons->links() !!}
    </div>
</x-admin-layout>
