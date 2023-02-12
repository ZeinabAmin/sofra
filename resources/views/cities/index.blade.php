
@extends('layouts.app')

@section('page_title')
Cities
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
        <h3 class="card-title">list of cities</h3>

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



        <a href="{{url(route('cities.create'))}}" class="btn btn-primary mb-3"><i class="fa fa-plus"> </i>New City</a>
        @include('flash::message')

              @if(count($records))
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Name</th>
                                        <th class="text-center">Edit</th>
                                        <th class="text-center">Delete</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($records as $record)
                                        <tr>
                                            <td>{{$loop->iteration}}</td>
                                          <td>{{$record->name}}</td>
                                            <td class="text-center">
                                                <a href="{{url(route('cities.edit',$record->id))}}" class="btn btn-success btn-xs"><i class="fa fa-edit"> </i></a>
                                            </td>
                                            <td class="text-center">
                                                {!! Form::open([

        'action' => ['App\Http\Controllers\Admin\CityController@destroy', $record->id],
                    'method' => 'delete'
                                                ]) !!}
                                                <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-trash"></i></button>
                                                {!! Form::close() !!}

                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>



                                {{-- @else

                                <div class="alert alert-success" role="alert">
                                  No data
                                </div>

                              @endif --}}




      </div>
      <!-- /.card-body -->



      @else

      <div class="alert alert-success" role="alert">
        No data
      </div>

    @endif












    {{-- <div class="card-footer">
        Footer
      </div> --}}
      <!-- /.card-footer-->


    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->

    @endsection













