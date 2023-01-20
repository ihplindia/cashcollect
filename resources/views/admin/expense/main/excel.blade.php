<table>
    <thead>
    <tr>
      <th>Expense Date</th>
      <th>Expense Title</th>
      <th>Category</th>
      <th>Amount</th>
    </tr>
    </thead>
    <tbody>
    @foreach($all as $dating)
        <tr>
            <td>{{ $dating->expense_date }}</td>
            <td>{{ $dating->expense_title }}</td>
            <td>{{$dating->category->expcate_name}}</td>
            <td>{{ $dating->expense_amount }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
