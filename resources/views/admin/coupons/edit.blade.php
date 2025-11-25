<x-admin-layout title="Edit Coupon">
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Edit Coupon</h1>
        </div>

        <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
            @csrf
            @method('PUT')
            @include('admin.coupons._form')
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</x-admin-layout>
