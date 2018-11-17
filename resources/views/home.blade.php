@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">{{ config('app.name') }}</div>
                
                <div class="panel-body">
                    <div class="row">
                        <div class="col-sm-12" style="margin-bottom: 10px">
                            <a class="btn_add btn btn-default"><i class="fa fa-plus"></i> Add</a>
                        </div>
                        <div class="col-sm-12 form_view hidden" style="margin-bottom: 10px">
                            <div class="row">
                                <div class="col-sm-6" style="text-align: center">
                                    <i class="fa fa-user img_pp hidden" style="font-size: 120px"></i>
                                    <img class="img_pp hidden" style="width: 50%; border-radius: 50%;">
                                </div>
                                <div class="col-sm-6">
                                    <div class="row">
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                {{ Form::label('first_name') }}
                                            </div>
                                            <div class="col-sm-8">
                                                {{ Form::label('first_name', null, ['name' => 'first_name_val']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                {{ Form::label('last_name') }}
                                            </div>
                                            <div class="col-sm-8">
                                                {{ Form::label('last_name', null, ['name' => 'last_name_val']) }}
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                {{ Form::label('age') }}
                                            </div>
                                            <div class="col-sm-8">
                                                {{ Form::label('age', null, ['name' => 'age_val']) }}
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <div class="col-sm-3">
                                                {{ Form::label('country') }}
                                            </div>
                                            <div class="col-sm-8">
                                                {{ Form::label('country', null, ['name' => 'country_val']) }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 hidden">
                            {{ Form::open(['id' => 'form_add', 'class' => 'form_add form-horizontal', 'files' => true]) }}
                                <div class="row">
                                    <div class="col-sm-6" style="text-align: center">
                                        <a href="#" class="btn_upload_pp"><i class="fa fa-user" style="font-size: 120px"></i></a>
                                        {{ Form::file('avatar', ['accept' => 'image/*', 'class' => 'hidden']) }}
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row">
                                            <div class="form-group">
                                                <div class="col-sm-8">
                                                    {{ Form::text('first_name', null, ['class' => 'form-control', 'placeholder' => 'First Name']) }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-8">
                                                    {{ Form::text('last_name', null, ['class' => 'form-control', 'placeholder' => 'Last Name']) }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-3">
                                                    {{ Form::number('age', null, ['class' => 'form-control', 'placeholder' => 'Age', 'min' => 17, 'max' => 65, 'step' => 1]) }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    {{ Form::select('country_id', $countries, null, ['class' => 'form-horizontal', 'placeholder' => 'Select country']) }}
                                                </div>
                                            </div>
                                            <div class="form-group">
                                                <div class="col-sm-12" style="margin-top: 20px">
                                                    <button class="btn btn-primary btn_save"><i class="fa fa-user"></i> Save Employee</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            {{ Form::close() }}
                        </div>
                        <div class="col-sm-12">
                            <table id="data_list" class="table table-striped table-hover">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Country</th>
                                        <th>Age</th>
                                    </tr>
                                </thead>
                                <tfoot>
                                    <tr>
                                        <th>Name</th>
                                        <th>Country</th>
                                        <th>Age</th>
                                    </tr>
                                </tfoot>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('script')
    <script src="{{ asset('/appjs/employees/index.js') }}"></script>
@endsection