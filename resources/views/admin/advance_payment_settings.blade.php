<x-admin-layout title="Advance Payment Settings">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Advance Payment Settings</h3>
                    </div>
                    <div class="card-body">
                        <div id="message"></div>
                        <form id="advancePaymentForm">
                            @csrf
                            <div class="form-group">
                                <label for="advance_payment_status">Enable Advance Payment</label>
                                <div class="custom-control custom-switch">
                                    <input type="hidden" name="advance_payment_status" value="0">
                                    <input type="checkbox" class="custom-control-input" id="advance_payment_status" name="advance_payment_status" value="1" {{ $settings->advance_payment_status ? 'checked' : '' }}>
                                    <label class="custom-control-label" for="advance_payment_status"></label>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="advance_payment_amount">Advance Payment Amount (BDT)</label>
                                <input type="number" class="form-control" id="advance_payment_amount" name="advance_payment_amount" value="{{ $settings->advance_payment_amount }}" {{ !$settings->advance_payment_status ? 'disabled' : '' }}>
                            </div>
                            <button type="submit" class="btn btn-primary">Save</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const statusCheckbox = document.getElementById('advance_payment_status');
                const amountInput = document.getElementById('advance_payment_amount');
                const form = document.getElementById('advancePaymentForm');
                const saveButton = form.querySelector('button[type="submit"]');

                // Store initial values
                let initialStatus = statusCheckbox.checked;
                let initialAmount = amountInput.value;

                function checkFormChanges() {
                    const currentStatus = statusCheckbox.checked;
                    const currentAmount = amountInput.value;

                    const statusChanged = currentStatus !== initialStatus;
                    const amountChanged = currentAmount !== initialAmount;

                    saveButton.disabled = !(statusChanged || amountChanged);
                }

                form.addEventListener('submit', async (e) => {
                    e.preventDefault();
                    const formData = new FormData(form);
                    saveButton.disabled = true;
                    saveButton.innerHTML = 'Saving...';

                    const response = await fetch('{{ route("admin.advance-payment.update") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData
                    });

                    const data = await response.json();
                    const msg = document.getElementById('message');

                    if (response.ok) {
                        msg.innerHTML = `<div class="alert alert-success">${data.message}</div>`;
                        // Update initial state after successful save
                        initialStatus = statusCheckbox.checked;
                        initialAmount = amountInput.value;
                        checkFormChanges(); // Re-check to disable button
                    } else {
                        let errorMessages = '';
                        if (data.errors) {
                            for (const key in data.errors) {
                                errorMessages += `<p>${data.errors[key][0]}</p>`;
                            }
                        } else {
                            errorMessages = data.message || 'An unexpected error occurred.';
                        }
                        msg.innerHTML = `<div class="alert alert-danger">${errorMessages}</div>`;
                    }
                    
                    saveButton.disabled = false;
                    saveButton.innerHTML = 'Save';
                });

                statusCheckbox.addEventListener('change', function() {
                    amountInput.disabled = !this.checked;
                    if (!this.checked) {
                        amountInput.value = '';
                    }
                    checkFormChanges();
                });

                amountInput.addEventListener('input', checkFormChanges);

                // Initial check to set button state
                checkFormChanges();
            });
        </script>
    @endpush
</x-admin-layout>
