@extends('layouts.app')

@section('content')
    <div class="container-fluid">
        <h1 class="text-black-50">Welcome to Inventory</h1>
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-body">
                        <canvas id="myChart" height="100px"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('script')
<script>

const list = [
        { year: 2010, count: 10 },
        { year: 2011, count: 20 },
        { year: 2012, count: 15 },
        { year: 2013, count: 25 },
        { year: 2014, count: 22 },
        { year: 2015, count: 30 },
        { year: 2016, count: 28 },
    ];

    const data = {
        labels: list.map(row => row.year),
        datasets: [{
            label: 'Example dataset',
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: list,
        }]
    };

    const config = {
        type: 'bar',
        data: data,
        options: {}
    };

    $(document).ready(function () {
        const myChart = new Chart(
            document.getElementById('myChart'),
            config
        );
    });


</script>
@endsection
