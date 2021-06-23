<!doctype html>
<html lang="en">
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <title>Reporting Dashboard!</title>
</head>
<body>
<div class="container" style="padding-top: 100px;">
    <div class="row">
        <div class="col-md-12" style="padding: 10px;">
            <label for="">Date Range</label>
            @if(!request()->has('start_date'))
                <input type="text" class="form-control" name="daterange"
                       value="{{ date('m/d/Y', time() - 7 * 24 * 60 * 60) }} - {{ date('m/d/Y', time()) }}"
                       style="padding: 10px;"/>
            @else
                <input type="text" class="form-control" name="daterange"
                       value="{{ date('m/d/Y', strtotime(request()->get('start_date'))) }} - {{ date('m/d/Y', strtotime(request()->get('end_date'))) }}"
                       style="padding: 10px;"/>
            @endif
        </div>

        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Success Action</h5>
                    <p class="card-text">{{ $successTotal }} ₺</p>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Total Fail Action</h5>
                    <p class="card-text">{{ $failTotal }} ₺</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row">

        <div class="col-md-12">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Company Name</th>
                    <th scope="col">Price</th>
                    <th scope="col">Status</th>
                    <th scope="col">Date</th>
                </tr>
                </thead>
                <tbody>
                @foreach($payments as $payment)
                    <tr>
                        <th scope="row">{{ $payment->id }}</th>
                        <td>{{ $payment->company->company_name }}</td>
                        <td>{{ $payment->price }} ₺</td>
                        <td>
                            @if($payment->status == 'fail')
                                <span class="badge bg-danger">Fail</span>
                            @else
                                <span class="badge bg-success">Success</span>
                            @endif
                        </td>
                        <td>{{ $payment->created_at }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{ $payments->links() }}
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM"
        crossorigin="anonymous"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

</body>

<script>
    $(function () {
        $('input[name="daterange"]').daterangepicker({
            opens: 'center'
        }, function (start, end, label) {
            window.location.href = "{{ url('/') }}?start_date=" + start.format('YYYY-MM-DD') + '&end_date=' + end.format('YYYY-MM-DD')
        });
    });
</script>
</html>
