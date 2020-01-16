<div class="row">
        <div class="col-lg-12 grid-margin">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <h4 class="card-title mr-2 mt-2">Orders not delivered</h4>
                <form method="post" action="{{route('admin.orderFiltered')}}" enctype="multipart/form-data"
                  autocomplete="off">
                  @csrf
                  From: <input type="date" name="from" value="{{$orderFrom}}">
                  To: <input type="date" name="to" value="{{$orderTo}}">
                  <input class="btn btn-success" type="submit" value="Filter">
                </form>
                <a class="btn btn-primary btn-reset" href="{{route('admin.index')}}">Reset</a>
                {{-- <form method="post" action="{{route('admin.exportOrdersPDF')}}" enctype="multipart/form-data"
                  autocomplete="off">
                  @csrf
                  <input hidden value="{{$orders}}" name="orderNotdelivered"/> --}}
                  <button onclick="javascript:xport.toCSV('ordersNotDelivered');" class="btn btn-warning btn-reset" id="ordersNotDeliveredPdf">Download</button>
                {{-- </form> --}}
              </div>
              <div class="table-responsive">
                <table class="table table-bordered" id="ordersNotDelivered">
                  <thead>
                    <tr>
                      <th>
                        Id
                      </th>
                      <th>
                        ক্রেতা
                      </th>
                      <th>
                        প্রাপকের লোকেশন
                      </th>
                      <th>
                        প্রাপকের ঠিকানা
                      </th>
                      <th>
                        বইয়ের নাম
                      </th>
                      <th>
                        লেখক
                      </th>
                      <th>
                        প্রকাশনীর নাম
                      </th>
                      <th>
                        পরিমাণ
                      </th>
                      <th>
                        মোট মূল্য
                      </th>
                      <th>
                        পেমেন্ট মেথড
                      </th>
                      <th>
                        ট্রানজেকশন আইডি
                      </th>
                      <th>
                        ডেলিভারি
                      </th>
                      <th>
                        অর্ডার টাইপ
                      </th>
                      <th>
                        একশন
                      </th>
                    </tr>
                  </thead>
                  <tbody>
                    @if(count($orders) > 0)
                    {{-- @php
                    $count = 0;
                    @endphp --}}
                    @foreach ($orders as $order)
                    {{-- @php
                    $count++;
                    @endphp --}}
                    <tr>
                      <td class="font-weight-medium">
                        {{$order->id}}
                      </td>
                      <td>
                        {{$order->name}}
                      </td>
                      <td>
                        {{$order->location}}
                      </td>
                      <td>
                        {{$order->shiping_address}}
                      </td>
                      <td class="text-danger">
                        {{$order->book}}
                      </td>
                      <td>
                        {{$order->author}}
                      </td>
                      <td>
                        {{$order->publisher}}
                      </td>
                      <td>
                        {{$order->quantity}}
                      </td>
                      <td>
                        ৳{{$order->total_price}}
                      </td>
                      <td>
                        {{$order->payment_method}}
                      </td>
                      <td>
                        {{$order->transection_id}}
                      </td>
                      <td>
                        @if ($order->is_completed == 0)
                        <form action="{!! route('admin.order.delivered', $order->id) !!}" method="post">
                          {{ csrf_field() }}
                          <button type="submit" class="btn btn-success">Set to delivered</button>
                        </form>
                        @else
                        <span class="text-success">Delivered</span>
                        @endif
                      </td>
                      <td>
                        @if ($order->order_type == 0)
                        Normal order
                        @else
                        Order as gift
                        @endif
                      </td>
                      <td>
                        @if ($order->is_seen_by_admin == 0)
                        <form action="{!! route('admin.order.seen', $order->id) !!}" method="post">
                          {{ csrf_field() }}
                          <button type="submit" class="btn btn-success">Set to seen</button>
                        </form>
                        @else
                        <span class="text-success">seen</span> <br>
                        @endif
                        <button type="submit" href="#deletecatModal{{ $order->id }}" data-toggle="modal"
                          class="btn btn-danger mt-2">Delete</button>
                      </td>
                    </tr>
  
                    <!-- Modal -->
                    <div class="modal fade" id="deletecatModal{{ $order->id }}" tabindex="-1" role="dialog"
                      aria-labelledby="exampleModalLabel" aria-hidden="true">
                      <div class="modal-dialog" role="document">
                        <div class="modal-content">
                          <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Are you sure to delete this order</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                              <span aria-hidden="true">&times;</span>
                            </button>
                          </div>
                          <div class="modal-body">
                            <p>Please confirm your action.</p>
                          </div>
                          <div class="modal-footer">
                            <form action="{!! route('admin.order.delete', $order->id) !!}" method="post">
                              {{ csrf_field() }}
                              <button type="submit" class="btn btn-danger">Yes</button>
                            </form>
                            <button type="button" class="btn btn-primary" data-dismiss="modal">cancel</button>
                          </div>
                        </div>
                      </div>
                      @endforeach
                      @else
                      <div class="alert alert-danger text-center" role="alert">
                        &#128546; No data found..
                      </div>
                      @endif
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>