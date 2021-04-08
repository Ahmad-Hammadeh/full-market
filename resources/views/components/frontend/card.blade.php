@push('extra-css')
<script src="https://js.stripe.com/v3/"></script>
@endpush

<div class="form-group">
    <label for="name_on_card">@lang('frontend.name_on_card')</label>
    <input type="text" class="form-control" id="name_on_card" name="name_on_card">
</div>
<div class="form-group">
    <label for="card-element">@lang('frontend.credit_card')</label>
    <div id="card-element">
        <!-- A Stripe Element will be inserted here. -->
    </div>

    <!-- Used to display form errors. -->
    <div id="card-errors" role="alert"></div>
</div>

@push('extra-js')
<script src="{{ asset('js/stripe.js') }}"></script>
@endpush
