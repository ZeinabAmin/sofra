 @extends('layouts.app')
 @inject('restaurant','App\Models\Restaurant')
@inject('client','App\Models\Client')
@inject('order','App\Models\Order')
@inject('paymentmethod','App\Models\PaymentMethod')

@section('page_title')
Dashboard
@endsection

 @section('small_title')
  statistics
@endsection

@section('content')



  <!-- Main content -->
  <section class="content">

    <!-- Default box -->
    <div class="card">
      <div class="card-header">
        <h3 class="card-title">Sofra</h3>

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














  <div class="row">
    <div class="col-lg-3 col-6">

    <div class="small-box bg-info">
    <div class="inner">
    <h3>{{$client->count()}}</h3>
    <p>Clients</p>
    </div>
    <div class="icon">
    <i class="ion ion-bag"></i>
    </div>
    <a href="{{url(route('clients.index'))}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
    </div>

    <div class="col-lg-3 col-6">

    <div class="small-box bg-success">
    <div class="inner">
    <h3>{{$restaurant->count()}}<sup style="font-size: 20px"></sup></h3>
    <p>Restaurants</p>
    </div>
    <div class="icon">
    <i class="ion ion-stats-bars"></i>
    </div>
    <a href="{{url(route('restaurants.index'))}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
    </div>

    <div class="col-lg-3 col-6">

    <div class="small-box bg-warning">
    <div class="inner">
    <h3>Orders</h3>
    <p>{{$order->count()}}</p>
    </div>
    <div class="icon">
    <i class="ion ion-person-add"></i>
    </div>
    <a href="#" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
    </div>

    <div class="col-lg-3 col-6">

    <div class="small-box bg-danger">
    <div class="inner">
    <h3>Payment Methods</h3>
    <p>{{$paymentmethod->count()}}</p>
    </div>
    <div class="icon">
    <i class="ion ion-pie-graph"></i>
    </div>
    <a href="{{url(route('payment-methods.index'))}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
    </div>
    </div>

    </div>



</div>
<!-- /.card-body -->






    <div class="card-footer">

      </div>
      <!-- /.card-footer-->
    </div>
    <!-- /.card -->

  </section>
  <!-- /.content -->

    @endsection

















{{-- @extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection --}}
