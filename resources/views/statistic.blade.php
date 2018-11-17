@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ config('app.name') }}</div>
                
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <h2>Current Employee: {{ $employee_count }}</h2>
                        </div>
                        <div class="col-sm-6">
                            <h2>Avg. Employee Age:  {{ $employee_avg_age }}</h2>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <canvas id="lineChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('/appjs/employees/statistic.js') }}"></script>
@endsection