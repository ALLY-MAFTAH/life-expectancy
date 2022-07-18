<div class="card mt-3">

    @if ($expects != [])

        <div hidden>
            {{ $totalPay = 0 }}
            @foreach ($expects as $expect)
                {{ $totalPay += $expect->total }}
            @endforeach
        </div>
        <div class="card overflow-hidden" style="box-shadow: 4px 4px 6px #aaa4f3;">
            <div class="p-3 d-flex justify-content-between">
                <div class="card-body">
                    <h2 class="f-w-400">{{ $currentCountry }}</h2>
                </div>
                <div>
                    <form action="{{ route('welcome') }}" method="GET" class="filter-form">
                        @csrf
                        <label for="country">Country:

                            <select class="dropdown-select dropdown-select form-control" id="country" name="country"
                                onchange="this.form.submit()">
                                @foreach ($countries as $country)
                                    <option value="{{ $country }}"
                                        {{ $currentCountry == $country ? 'selected' : '' }}>
                                        {{ $country }}</option>
                                @endforeach
                            </select></label>
                    </form>
                </div>

            </div>

            <div id="subtotal-class">
            </div>
        </div>
    @endif
</div>
