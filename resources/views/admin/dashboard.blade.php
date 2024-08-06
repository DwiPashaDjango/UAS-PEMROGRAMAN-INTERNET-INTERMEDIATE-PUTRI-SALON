@extends('layouts.admin')

@section('title')
    Dashboard
@endsection

@section('content')
    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="far fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Jumlah Pengguna</h4>
                    </div>
                    <div class="card-body">
                        {{$usersCount}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fas fa-users"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Jumlah Designer</h4>
                    </div>
                    <div class="card-body">
                        {{$designerCount}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-shopping-bag"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Jumlah Produk</h4>
                    </div>
                    <div class="card-body">
                        {{$produkCount}}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-money-bill"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Pendapatan</h4>
                    </div>
                    <div class="card-body">
                        {{number_format($ammount)}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-8 col-md-12">
            <div class="card">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Penyewaan & Pengembalian</h6>
                    <div class="dropdown no-arrow">
                    <a class="dropdown-toggle btn btn-primary btn-sm" href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Filter 
                        <i class="fas fa-chevron-down"></i>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" aria-labelledby="dropdownMenuLink">
                        <div class="dropdown-header">Pilih Tahun</div>
                            <form id="form-masuk">
                                <select name="years" id="years" class="form-control">
                                    @for ($tahun = date('Y'); $tahun >= date('Y') - 5; $tahun--)
                                        <option value="{{ $tahun }}">{{ $tahun }}</option>
                                    @endfor
                                </select>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <canvas id="chart-penjualan" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="{{asset('admin')}}/modules/chart.min.js"></script>
    <script src="{{asset('admin')}}/js/page/index.js"></script>
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        var currentYear = new Date().getFullYear();
        $('#years').val(currentYear);
        fetchJadwalMonth(currentYear);

        $("#years").change(function(e) {
            e.preventDefault();
            var years = $(this).val();
            fetchJadwalMonth(years);
        })

        function fetchJadwalMonth(years) {
            $.ajax({
                url: "{{route('dashboard.statistikRent')}}",
                method: 'POST',
                data: {years: years},
                dataType: 'json',
                success: function(data) {
                    console.log(data);
                    
                    if(window.myChart instanceof Chart)
                    {
                        window.myChart.destroy();
                    }

                    const monthRents = data.rent.map(entry => entry.month);
                    const countRents = data.rent.map(entry => entry.count);
                    const countRenteds = data.rented.map(entry => entry.count);

                    var ctx = document.getElementById('chart-penjualan').getContext('2d');
                    window.myChart = new Chart(ctx, {
                        type: 'bar',
                        data: {
                            labels: monthRents.map(month => getMonthName(month)),
                            datasets: [
                                    {
                                        label: 'Jumlah Penyewaan',
                                        data: countRents,
                                        backgroundColor: 'rgba(63,82,227,.8)',
                                        borderWidth: 0,
                                        borderColor: 'transparent',
                                        pointBorderWidth: 0,
                                        pointRadius: 3.5,
                                        pointBackgroundColor: 'transparent',
                                        pointHoverBackgroundColor: 'rgba(63,82,227,.8)',
                                    },
                                    {
                                        label: 'Jumlah Pengembalian',
                                        data: countRenteds,
                                        borderWidth: 2,
                                        backgroundColor: 'rgba(254,86,83,.7)',
                                        borderWidth: 0,
                                        borderColor: 'transparent',
                                        pointBorderWidth: 0,
                                        pointRadius: 3.5,
                                        pointBackgroundColor: 'transparent',
                                        pointHoverBackgroundColor: 'rgba(254,86,83,.7)',
                                    }
                                ]
                        },
                    options: {
                            animations: {
                                tension: {
                                    duration: 1000,
                                    easing: 'linear',
                                    from: 1,
                                    to: 0,
                                    loop: true
                                }
                                },
                            scales: {
                                y: { 
                                    min: 0,
                                    max: 100,
                                },
                                yAxes: [{
                                    display: true,
                                    ticks: {
                                        steps: 10,
                                        stepValue: 5,
                                    }
                                }]
                            }
                        }
                    });
                },
                error: function(err) {
                    console.log(err);
                }
            })
        }

        function getMonthName(month) {
            const monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];
            return monthNames[month - 1];
        }
    </script>
@endpush