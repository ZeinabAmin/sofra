
@extends('layouts.app')
@inject('model','App\Models\PaymentMethod')
@section('page_title')
Create Payment Method
@endsection
 {{-- @section('small_title')
 list of cities
@endsection --}}
@section('content')



  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Create Payment Method</h3>

        <div class="card-tools">
          <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
            <i class="fas fa-minus"></i>
          </button>
          <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
            <i class="fas fa-times"></i>
          </button>
        </div>
      </div>
      <div class="card-body">


        @include('partials.validation_errors')



        {!! Form::model($model,[
            'action' => 'App\Http\Controllers\Admin\PaymentMethodController@store'
        ]) !!}

@include('payment-methods.form')

        {!! Form::close() !!}







      </div>
      <!-- /.card-body -->



    {{-- <div class="card-footer">
        Footer
      </div> --}}
      <!-- /.card-footer-->


    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->

    @endsection



