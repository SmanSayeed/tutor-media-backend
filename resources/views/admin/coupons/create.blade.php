<x-admin-layout title="Add New Coupon">
    <div class="container-fluid">
        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
            <h1 class="h2">Add New Coupon</h1>
        </div>

        <form action="{{ route('admin.coupons.store') }}" method="POST">
            @csrf
            @include('admin.coupons._form')
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</x-admin-layout>
