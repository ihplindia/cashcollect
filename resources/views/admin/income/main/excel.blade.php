<table>
    <thead>
    <tr>
      <th>Income Date</th>
      <th>Income Title</th>
      <th>Category</th>
      <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    @foreach($all as $dating)
        <tr>
            <td>{{ $dating->income_date }}</td>
            <td>{{ $dating->income_title }}</td>
            <td>{{$dating->category->incate_name}}</td>
            <td>{{ $dating->income_amount }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
