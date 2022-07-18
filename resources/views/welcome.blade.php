<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Life Expectancy</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@200;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.12.1/css/dataTables.bootstrap4.min.css">
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

</head>

<body>

    <div class="container pb-5">

        @if ($years == [])
            <div class="row pt-5 mt-5">
                <div class="col text-center">
                    <h4 class="pb-5 mb-5">
                        NO YEARS IN DATABASE, TO ADD YEARS PLEASE
                    </h4>
                    <h5>
                        <b style="font-family:  Ubuntu, sans-serif"> Run Command:</b> <span>php artisan migrate:refresh
                            --seed</span> <b style="font-family:  Ubuntu, sans-serif"> in the Terminal Then Reload
                            Page</b>
                    </h5>
                    <h4>
                        OR
                    </h4>
                    <h5>
                        <b> Press This Button:</b>
                        <form id="add-years" method="POST" action="{{ route('store-years') }}">@csrf
                            @method('POST')
                        </form>
                        <a href="#!" class="btn  btn-primary"
                            onclick="if(confirm('Are you sure want to add years ?')) document.getElementById('add-years').submit()">&nbsp;Add
                            Years
                        </a>
                    </h5>
                </div>
            </div>
        @else
            <div class="col-md col-md-offset-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        {{ session('success') }}
                        <button type="button" data-dismiss="alert" aria-label="Close" class="close btn"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-error alert-dismissible" role="alert">
                        {{ session('error') }}
                        <button type="button" data-dismiss="alert" aria-label="Close" class="close btn"><span
                                aria-hidden="true">&times;</span></button>
                    </div>
                @endif


                <div class="row pt-5">
                    <div class="col-md-6 text-center">
                        <h1 style="font-size: 30px; color:rgb(44, 11, 189);"><b>Life Expectancy At Birth</b></h1>
                    </div>
                    <div class="col-md-6">
                        <div class="row">

                            <div class="col-sm-6 text-center">
                                <a href="#" data-toggle="modal" data-target="#uploadFileModal"
                                    class="btn  btn-sm btn-primary {{ $expectancies->count() != 0 ? 'disabled' : '' }}">Upload
                                    Expectancy Data</a>
                            </div>
                            <div class="col-sm-6 text-center">
                                <form id="delete-all" method="post" action="{{ route('delete-all') }}">@csrf
                                    @method('delete')
                                </form>
                                <a href="#!"
                                    class="btn  btn-danger btn-sm {{ $expectancies->count() == 0 ? 'disabled' : '' }}"
                                    onclick="if(confirm('Are you sure want to delete all data ?')) document.getElementById('delete-all').submit()">&nbsp;Delete
                                    All
                                    Expectancy
                                    Data</a>
                            </div>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="tab container">
                    <ul class="row nav nav-tabs text-center" id="myTab"
                        style="height: 100%; border: solid rgb(212, 209, 209);background:rgb(194, 219, 236)">
                        <li class="nav-item  col-6">
                            <a href="#tabular" class="nav-link active" data-toggle="tab" id="tabular-pre">
                                <b style="">Tabular Presentation
                                </b>
                            </a>
                        </li>
                        <li class="nav-item  col-6">
                            <a href="#graphical" class="nav-link" data-toggle="tab" id="graphical-pre">
                                <b style="">Graphical Presentation
                                </b>
                            </a>
                        </li>
                    </ul>
                </div>
                <form action="{{ route('welcome') }}" method="GET" id="filter-form">
                    @csrf
                    <div class="tab-content">
                        <div id="tabular" class="tab-pane fade tabcontent show active">
                            @include('components.tabular')
                        </div>
                        <div id="graphical" class="tab-pane fade tabcontent">
                            @include('components.graphical')
                        </div>
                    </div>
                </form>
            </div>
        @endif

    </div>



    </div>
    <div class="container">
        @include('components.upload_file_modal')


        <script src="{{ asset('js/app.js') }}"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"
            integrity="sha256-T0Vest3yCU7pafRw9r+settMBX6JkKN06dqBnpQ8d30=" crossorigin="anonymous"></script>

        <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.12.1/js/dataTables.bootstrap4.min.js "></script>
        <script>
            $(document).ready(function() {
                $('#d-table').DataTable();
            });
        </script>
        <script>
            $(document).ready(function() {
                $(document).on('submit', 'form', function() {
                    $('button').attr('disabled', 'disabled');
                });
            });
        </script>
        <script>
            $("#filter-form").on("submit", function(e) {
                e.preventDefault();
                var url = $("#filter-form").attr("action");
                var newUrl =
                    `${url}?year=${$(e.target).val()}?country=${$(e.target).val()}`;
                window.location.assign(newUrl);
            });
        </script>
        <script>
            $('#myTab a').click(function(e) {
                e.preventDefault();
                $(this).tab('show');
            });

            // store the currently selected tab in the hash value
            $("ul.nav-tabs > li > a").on("shown.tab", function(e) {
                var id = $(e.target).attr("href").substr(1);
                window.location.hash = id;
            });

            // on load of the page: switch to the currently selected tab
            var hash = window.location.hash;
            $('#myTab a[href="' + hash + '"]').tab('show');
        </script>

        <script>
            var s = @json($expects);
            if (s != null) {
                $(function() {
                    var options = {
                        chart: {
                            type: 'area',
                            height: 300,
                            toolbar: {
                                show: true
                            }
                        },

                        dataLabels: {
                            enabled: true
                        },
                        colors: ["#5880ff"],

                        fill: {
                            type: 'solid',
                            opacity: 0.2,
                        },
                        markers: {
                            size: 2,
                            opacity: 0.9,
                            colors: "#fff",
                            strokeColor: "#4680ff",
                            strokeWidth: 2,
                            hover: {
                                size: 7,
                            }
                        },
                        stroke: {
                            curve: 'straight',
                            width: 2,
                        },
                        series: [{
                            name: 'Life expectancy at birth, years',
                            data: @json($expects)
                                .map(v => {
                                    return v.total
                                })
                        }],
                        xaxis: {
                            categories: @json($years),
                            title: {
                                text: 'Years'
                            }
                        },
                        tooltip: {
                            fixed: {
                                enabled: false
                            },
                            x: {
                                show: true
                            },
                            y: {
                                title: {
                                    formatter: function(seriesName) {
                                        return 'Life expectancy at birth, years'
                                    }
                                }
                            },
                            marker: {
                                show: true
                            }
                        },
                        theme: {
                            palette: 'palette1'
                        },
                        yaxis: {
                            title: {
                                text: 'Life expectance at birth'
                            }
                        }
                    };
                    new ApexCharts(document.querySelector("#subtotal-class"), options).render();
                });
            }
        </script>
        <script src="{{ asset('js/apexchart.min.js') }}"></script>

</body>

</html>
