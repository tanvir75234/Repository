
<table class="table tale-bordered table-striped">
  <thead>
      <tr class="table-dark">
          <th>Date</th>
          <th>Title</th>
          <th>Category</th>
          <th>Amount</th>
      </tr>
  </thead>
  <tbody>
      @foreach($all as $data)
      <tr>
          <td>{{date('d-M-Y',strtotime($data->income_date))}}</td>
          <td>{{$data->income_title}}</td>
          <td>{{$data->categoryInfo->incate_name}}</td>
          <td>{{number_format($data->income_amount,2)}}</td>
      </tr>
      @endforeach()
  </tbody>
</table>
   