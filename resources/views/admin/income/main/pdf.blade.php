<!DOCTYPE html>
<html>
  <head>
      <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
      <title>All Income Information</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css">
      <style>
          *{
            margin: 0px;
            padding: 0px;
            outline: 0px;
          }

          .wrapper{
            width: 90%;
            padding: 20px 40px;
          }

          h2.title{
            text-align: center;
            font-family: sans-serif;
            font-size: 20px;
            line-height: 30px;
          }

          .table_data{
              font-family: sans-serif;
              font-size: 13px;
          }

          .table_data tr{

          }

          .table_data tr th{
              text-align: left;
              font-weight: bold;
              background-color: #000;
              color: #f7f7f7;
              padding: 5px;
          }

          .table_data tr td{
              text-align: left;
              padding: 5px;

          }
      </style>
  </head>
  <body>
      <div class="wrapper">
          <h2 class="title">All Income Information</h2>
          <hr>
          <table class="table table-bordered table-striped table_data">
              <thead>
                <tr>
                    <th>Income Date</th>
                    <th>Income Title</th>
                    <th>Category</th>
                    <th>Amount</th>
                </tr>
              </thead>
              <tbody>
              @foreach($all as $data)
                  <tr>
                      <td>{{$data->income_date}}</td>
                      <td>{{Str::words($data->income_title,3)}}</td>
                      <td>{{$data->category->incate_name}}</td>
                      <td>{{$data->income_amount}}</td>
                  </tr>
              @endforeach
              </tbody>
          </table>
      </div>
      <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"></script>
  </body>
</html>
