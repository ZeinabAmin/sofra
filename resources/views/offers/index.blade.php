@extends('layouts.app')
@section('page_title')
    Offers
@endsection
@section('content')



    <!-- Main content -->
    <section class="content">

        <!-- Default box -->
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">list of offers</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip"
                        title="Collapse">
                        <i class="fas fa-minus"></i></button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip"
                        title="Remove">
                        <i class="fas fa-times"></i></button>
                </div>
            </div>


            <div class="card-body">




                <div class="filter">
                    {!! Form::open([
                        'method' => 'get',
                    ]) !!}


                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                
                                {!! Form::text('keyword', request('keyword'), [
                                    'class' => 'form-control',
                                    'placeholder' => 'search with name, phone, email and city',
                                ]) !!}
                            </div>
                        </div>

                        <div class="col-sm-3">
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-block">search</button>
                            </div>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>


                @include('flash::message')

                @if (count($records))
                    {{-- @if ($records) --}}
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Restaurant name</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Image</th>
                                    <th>Discount percentage</th>
                                    <th>Time from</th>
                                    <th>Time to</th>
                                    <th class="text-center">Delete</th>



                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($records as $record)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $record->restaurant->name }}</td>

                                        <td>{{ $record->name }}</td>
                                        <td>{{ $record->description }}</td>
                                        <td>{{ $record->image }}</td>
                                        <td>{{ $record->discount_percentage }}</td>
                                        <td>{{ $record->time_from }}</td>
                                        <td>{{ $record->time_to }}</td>


                                        <td class="text-center">
                                            {!! Form::open([
                                                'action' => ['App\Http\Controllers\Admin\OfferController@destroy', $record->id],
                                                'method' => 'delete',
                                            ]) !!}
                                            <button type="submit" class="btn btn-danger btn-xs"><i
                                                    class="fa fa-trash"></i></button>

                                            {!! Form::close() !!}

                                        </td>




                                    </tr>
                                @endforeach
                            </tbody>
                        </table>

                    </div>
                @else
                    <p class='text-center h3'>No Data</p>
                @endif
                <!-- /.card-body -->

            </div>

        </div>
        <!-- /.card -->

    </section>
    <!-- /.content -->
@endsection
