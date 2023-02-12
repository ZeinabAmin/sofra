
@extends('layouts.app')
@section('page_title')
Create Category
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
        <h3 class="card-title">Create Category</h3>

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


        @inject('model','App\Models\Category')
        {!! Form::model($model,[
            'action' => 'App\Http\Controllers\Admin\CategoryController@store'
        ]) !!}

@include('categories.form')

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

