@extends('layouts.template')

@section('content')

    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Hallo, apa kabar!!!</h3>
            <div class="card-tools"></div>
        </div>
        <div class="card-body">
            Sealamat datang semua, ini adalah halaman utama dari aplikasi ini.
        </div>
    </div>
    <!-- Post -->
    <div class="card">
        <div class="card-body">
            <div class="tab-content">
                <div class="post">
                    <div class="row mb-3">
                        <div class="col-sm-6">
                            <a href="{{ url('mobil') }}">
                                <img class="img-fluid" src="{{ asset('adminlte/dist/img/mobil/skyline.png') }}" alt="Photo">
                            </a>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-6">
                                    <a href="{{ url('mobil') }}">
                                        <img class="img-fluid mb-3" src="{{ asset('adminlte/dist/img/mobil/supra.png') }}"
                                            alt="Photo">
                                    </a>
                                    <a href="{{ url('mobil') }}">
                                        <img class="img-fluid" src="{{ asset('adminlte/dist/img/mobil/ec1.png') }}"
                                            alt="Photo">
                                    </a>
                                </div>
                                <!-- /.col -->
                                <div class="col-sm-6">
                                    <a href="{{ url('mobil') }}">
                                        <img class="img-fluid mb-3" src="{{ asset('adminlte/dist/img/mobil/evo.png') }}"
                                            alt="Photo">
                                    </a>
                                    <a href="{{ url('mobil') }}">
                                        <img class="img-fluid" src="{{ asset('adminlte/dist/img/mobil/evo2.png') }}"
                                            alt="Photo">
                                    </a>
                                </div>
                                <!-- /.col -->
                            </div>
                            <!-- /.row -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
            </div>
        </div>
    </div>
@endsection