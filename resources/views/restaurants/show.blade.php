{{-- 

















@extends('layouts.app')

@section('page_title')
  Restaurant details
@endsection

@section('content')


<!-- Main content -->

<section class="content">

  <!-- Default box -->
  <div class="card">
    <div class="card-header">
      <h3 class="card-title">Restaurant details</h3>

      <div class="card-tools">
        <button type="button" class="btn btn-tool" data-card-widget="collapse" data-toggle="tooltip" title="Collapse">
          <i class="fas fa-minus"></i></button>
        <button type="button" class="btn btn-tool" data-card-widget="remove" data-toggle="tooltip" title="Remove">
          <i class="fas fa-times"></i></button>
      </div>
    </div>
    <div class="card-body">
      @include('flash::message')
        <div class="table-responsive">
          <table class="table table-bordered">

            <tr>
              <th class="text-center" width="40%">Name</th>
              <td class="text-center">{{$record->name}}</td>
            </tr>

            <tr>
              <th class="text-center" width="40%">Email</th>
              <td class="text-center">{{$record->email}}</td>
            </tr>

            <tr>
              <th class="text-center" >Phone</th>
              <td class="text-center">{{$record->phone}}</td>
            </tr>
            <tr>
              <th class="text-center">Whatsapp</th>
              <td class="text-center">{{$record->whatsapp}}</td>
            </tr>
            <tr>
              <th class="text-center">Region</th>
              <td class="text-center">{{optional($record->region)->name}}</td>
            </tr>
            <tr>
              <th class="text-center">Image</th>
              <td class="text-center">{{optional($record->region)->image}}</td>
            </tr>

            <tr>
              <th class="text-center">Minimum order</th>
              <td class="text-center">{{$record->minimum_order}}</td>
            </tr>

            <tr>
              <th class="text-center">Delivery charge</th>
              <td class="text-center">{{$record->delivery_charge}}</td>
            </tr>

            <tr>
              <th class="text-center">Available</th>
              <td class="text-center">{{$record->available}}</td>
            </tr>

            <tr>
              <th class="text-center">Created at</th>
              <td class="text-center">{{$record->created_at}}</td>
            </tr>

            <tr>
              <th class="text-center">Contact phone</th>
              <td class="text-center">{{$record->contact_phone}}</td>
            </tr>

          </table>

        </div>


    </div>
    <!-- /.card-body -->

  </div>
  <!-- /.card -->

</section>
<!-- /.content -->


@endsection
 --}}



{{-- @extends('admin.index') --}}
@section('title') Restaurants  @endsection

@section('content')

<section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title"> Restaurants  Table </h3> <br>

            </div>
            @include('flash::message')
            <!-- /.card-header -->
            @if(count($record))

            <div class="card-body">
              <table id="example1" class="table table-bordered table-striped">
                <thead>
                <tr>
                  <th>ID </th>
                  <th>Name </th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>Whatsapp</th>
                  <th>City </th>
                  <th>Status</th>
                  <th>Minimum Order</th>
                  <th>Delivery Cost</th>
                  <th>Active de-Active </th>
                  <th>Image</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($record as $restaurant)
                <tr>
                    <td>{{$loop->iteration}}</td>
                    <td>{{$restaurant->name}}</td>
                    <td>{{$restaurant->email}}</td>
                    <td>{{$restaurant->phone}}</td>
                    <td>{{$restaurant->whatsapp}}</td>
                    <td>{{$restaurant->region->name}}</td>
                    <td>{{$restaurant->status}}</td>
                    <td>{{$restaurant->minimum_order}}</td>
                    <td>{{$restaurant->delivery_cost}}</td>
                    @if ($restaurant->activated == 0)
                       <td>
                          {!! Form::model($restaurant, ['action' => ['Admin\RestaurantController@active',$restaurant->id], 'method' => 'PUT']) !!}

                          <button type="submit" class="btn btn-danger btn-xs"><i class="fas fa-times"></i>  De Active </button>
                          {!! Form::close() !!}
                       </td>
                    @else
                        <td>
                          {!! Form::model($restaurant, ['action' => ['Admin\RestaurantController@deActive',$restaurant->id], 'method' => 'PUT']) !!}

                          <button type="submit" class="btn btn-success btn-xs"><i class="fas fa-check"></i>    Active </button>
                          {!! Form::close() !!}
                        </td>
                    @endif
                    <td> <img src="{{asset('images/restaurants/profile/' .$restaurant->image)}}" alt="restaurant - {{$restaurant->name}}"> </td>

                  </tr>
                @endforeach

                </tbody>
                <tfoot>
                <tr>
                  <th>ID </th>
                  <th>Name </th>
                  <th>Email</th>
                  <th>Phone</th>
                  <th>whatsapp</th>
                  <th>City </th>
                  <th>Status</th>
                  <th>Minimum Order</th>
                  <th>Delivery Cost</th>
                  <th>Active de-Active </th>
                  <th>Image</th>

                </tr>
                </tfoot>
              </table>
            </div>
            <!-- /.card-body -->
            @else
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>No </strong> Data.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
            @endif
          </div>
          <!-- /.card -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </div>
    <!-- /.container-fluid -->
  </section>
  <!-- /.content -->

@endsection
