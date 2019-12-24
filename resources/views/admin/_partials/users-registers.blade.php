@php
    /** @var [] $monthlyRegisters */
@endphp
<div class="card card-dark">
    <div class="card-header with-border">
        <h3 class="card-title">Регистрация пользователей</h3>
        <div class="card-tools pull-right">
            <button type="button" class="btn btn-tool" data-widget="collapse"><i class="fa fa-minus"></i>
            </button>
        </div>
    </div>
    <!-- /.box-header -->
    <div class="card-body no-padding">
        <div class="chart">
            <canvas id="reg-chart" style="height: 273px; width: 547px;" width="547" height="273"></canvas>
        </div>
    </div>
    <!-- /.box-body -->
</div>


@push('js')
    @php
        $days = [];
        for ($i = 0; $i <= 30; $i++) {
            $days[] = date("F d", strtotime("today - $i days"));
        }
        $days = array_reverse($days);
    @endphp
    <script>
        var chart = new Chart(document.getElementById("reg-chart"),
            {
                "type": "line",
                "data": {
                    "labels": [
                        @foreach($days as $day)
                        '{{ $day }}',
                        @endforeach
                    ],
                    "datasets": [ {
                        "label": "Registers Count",
                        "data" : [
                            @foreach($days as $day)
                            {{ $monthlyRegisters[$day] ?? 0}},
                            @endforeach
                        ],
                        "fill": false,
                        "borderColor": "rgb(75, 192, 192)",
                        "lineTension": 0.1
                    } ]
                },
                "options": {}
            });
    </script>
@endpush

