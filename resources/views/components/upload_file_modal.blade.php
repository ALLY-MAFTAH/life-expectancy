<div class="modal fade" id="uploadFileModal">
    <div class="modal-dialog modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Upload Life Expectancy Data File</h5>
                <button class="btn" class="close" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('upload') }}" enctype="multipart/form-data">
                    @csrf
                    @if ($errors->bulk->any())
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="btn close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <ul class="m-0">
                                @foreach ($errors->bulk->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="form-group row">
                        <label for="csv_file"
                            class="col-md-4 col-form-label text-md-right">{{ __('Data File') }}</label>
                        <div class="col-md-6">
                            <input id="csv_file" type="file"
                                class="form-control @error('csv_file', 'bulk') is-invalid @enderror"
                                name="csv_file" required>
                            <span class="form-group">.csv</span>
                            @error('csv_file', 'bulk')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary btn-sm">Upload</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
