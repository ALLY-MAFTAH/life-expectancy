<div class="card  mt-3">
    <div class="card p-3 overflow-hidden" style="box-shadow: 4px 4px 6px #aaa4f3;">

        <div class="text-center" style="">
            <form action="{{ route('welcome') }}" method="GET" class="filter-form">
                @csrf
                <label for="year">Year:
                    <select name="year" id="year" class="dropdown-select form-control"
                        onchange="this.form.submit()">
                        @foreach ($years as $year)
                            <option value="{{ $year }}" {{ $currentYear == $year ? 'selected' : '' }}>
                                {{ $year }}</option>
                        @endforeach
                    </select></label>
            </form>
        </div>
        <table id="d-table" class="table table-striped table-bordered" style="width:100%">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Country Name</th>
                    <th>Country Code</th>
                    <th>Indicator Name</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($expectancies as $index => $item)
                    <tr>
                        <td>{{ ++$index }}</td>
                        <td>{{ $item->country_name }}</td>
                        <td>{{ $item->country_code }}</td>
                        <td>{{ $item->indicator_name }}</td>
                        <td>{{ $item->total }}</td>

                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
