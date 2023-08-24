@extends('admin.layout.master')

@section('content')

    <div class="app-main__inner">
        <div class="app-page-title">
            <div class="page-title-wrapper">
                <div class="page-title-heading">
                    <div class="page-title-icon">
                        <i class="pe-7s-ticket icon-gradient bg-mean-fruit"></i>
                    </div>
                    <div>
                        Dashboard
                        <div class="page-title-subheading">
                            Statistics of products, orders, customers, order rate and store revenue.
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div class="cardBox">
            <div class="card">
                <div>
                    <div class="numbers">{{ $data['total_product'] }}</div>
                    <div class="cardName">Products</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="file-tray-stacked-outline" role="img" class="md hydrated" aria-label="file tray stacked outline"></ion-icon>
                </div>
            </div>
            <div class="card">
                <div>
                    <div class="numbers">{{ $data['total_user'] }}</div>
                    <div class="cardName">Users</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="person-circle-outline" role="img" class="md hydrated" aria-label="person circle outline"></ion-icon>
                </div>
            </div>
            <div class="card">
                <div>
                    <div class="numbers">{{ $data['total_order'] }}</div>
                    <div class="cardName">Orders</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="document-text-outline" role="img" class="md hydrated" aria-label="document text outline"></ion-icon>   
                </div>
            </div>
            <div class="card">
                <div>
                    <div class="numbers">{{ number_format($data['total_income']) }}đ</div>
                    <div class="cardName">Earning</div>
                </div>
                <div class="iconBx">
                    <ion-icon name="cash-outline" role="img" class="md hydrated" aria-label="cash outline"></ion-icon>
                </div>
            </div>
        </div>

        <div class="cardChart">
            <div class="cardChart-inner">
                <div class="cardHeader">
                    <h2>Sales Statistics</h2>
                </div>
                <div>
                    <canvas id="chartSales"></canvas>
                </div>
            </div>
            <div class="cardChart-inner">
                <div class="cardHeader">
                    <h2>Order Statistics</h2>
                </div>
                <div class="text-center">
                    <canvas style="padding: 20px" id="pieChart"></canvas>
                    <strong>Total: {{$data['total_order']}} orders</strong>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="/assets/admin/js/chart.umd.min.js"></script>

    <script>
        const today = new Date();
        // Bar chart Sale
        const barCharData = <?php echo json_encode($barCharData) ?>;
        const dates = Object.keys(barCharData);
        const dataSales = Object.values(barCharData);
        createBarChar(document.querySelector('#chartSales'), dates, 'orders', dataSales);

        function createBarChar(query, label, labelName, data){
            new Chart(query, {
                type: 'bar',
                data: {
                    labels: label,
                    datasets: [
                        {
                            label: labelName,
                            data: data,
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        };
        
        //Pie Chart
        const pieChartData = <?php echo json_encode($pieChartData) ?>;
        const status = Object.keys(pieChartData);
        const total_orders = Object.values(pieChartData);

        console.log(pieChart);
        new Chart(document.querySelector('#pieChart'), {
            type: 'pie',
            data: {
                labels: status,
                datasets: [{
                    label: 'Orders',
                    data: total_orders,
                    backgroundColor: [
                        'rgb(255, 205, 86)',
                        'rgb(75, 192, 192)',
                        'rgb(54, 162, 235)',
                        'rgba(255, 99, 132)',
                        'rgb(201, 203, 207)'
                    ],
                    hoverOffset: 4
                }]
            }
        });

    </script>
    
    @endpush

@endsection