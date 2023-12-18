@extends('layouts.frontend')

@section('content')
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1, shrink-to-fit=no"
    />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>MayCar</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <!-- Bootstrap icons-->
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/remixicon@2.5.0/fonts/remixicon.css"
      rel="stylesheet"
    />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{asset('frontend/css/styles.css')}}" rel="stylesheet" />
    <link rel="stylesheet" href="{{asset('frontend/css/custom.css')}}" />
  </head>
  <body>
    <!-- Navigation-->
    <!-- Header-->
    <header class="bg-dark py-5">
      <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
          <h1 class="display-4 fw-bolder">Rental Mobil</h1>
          <p class="lead fw-normal text-white-50 mb-0">
            secepat kedipan mata
          </p>
        </div>
      </div>
    </header>
    <!-- Section-->
    <section class="py-5">
      <div class="container px-4 px-lg-5 mt-5">
        <h3 class="text-center mb-5">Daftar Mobil</h3>
        <div
          class="row gx-4 gx-lg-5 row-cols-2 row-cols-md-3 row-cols-xl-4 justify-content-center"
        >
        @foreach($cars as $car) 
        <div class="col mb-5">
            <div class="card h-100">
              <!-- Sale badge-->
              <div
                class="badge badge-custom {{ $car->status == 'tersedia' ? 'bg-success' : 'bg-warning'}} text-white position-absolute'"
                style="top: 0; right: 0"
              >
                {{$car->status}}
              </div>
              <!-- Product image-->
              <img
                class="card-img-top"
                src="{{Storage::url($car->gambar)}}"
                alt="{{$car->nama_mobil}}"
              />
              <!-- Product details-->
              <div class="card-body card-body-custom pt-4">
                <div class="text-center">
                  <!-- Product name-->
                  <h5 class="fw-bolder">{{$car->nama_mobil}}</h5>
                  <!-- Product price-->
                  <div class="rent-price mb-3">
                    <span class="text-primary">Rp.{{number_format($car->harga_sewa)}}/</span>day
                  </div>
                  <ul class="list-unstyled list-style-group">
                    <li
                      class="border-bottom p-2 d-flex justify-content-between"
                    >
                      <span>Bahan bakar</span>
                      <span style="font-weight: 600">{{$car->bahan_bakar}}</span>
                    </li>
                    <li
                      class="border-bottom p-2 d-flex justify-content-between"
                    >
                      <span>Jumlah Kursi</span>
                      <span style="font-weight: 600">{{$car->jumlah_kursi}}</span>
                    </li>
                    <li
                      class="border-bottom p-2 d-flex justify-content-between"
                    >
                      <span>Transmisi</span>
                      <span style="font-weight: 600">{{$car->transmisi}}</span>
                    </li>
                  </ul>
                </div>
              </div>
              <!-- Product actions-->
              <div class="card-footer border-top-0 bg-transparent">
                <div class="text-center">
                  <a class="btn btn-primary mt-auto" href="#">Sewa</a>
                  <a
                    class="btn btn-info mt-auto text-white"
                    href="{{route('detail',$car->slug)}}"
                    >Detail</a
                  >
                </div>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    </section>
    <!-- Bootstrap core JS-->
    <script src="{{asset('frontend/js/bootstrap.js')}}"></script>
    <!-- Core theme JS-->
    <script src="{{asset('frontend/js/scripts.js')}}"></script>
  </body>
</html>
@endsection