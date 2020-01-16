@extends('backend.layouts.master')

@section('content')
<style>
  .btn-reset{
  height: 34px;
  margin-left: 10px;
  margin-top: 0px;  
}
</style>
<!-- partial -->
<div class="main-panel" style="width: 100%">
  <div class="content-wrapper">
    <div class="row">
      <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
          <div class="card-body">
            <div class="clearfix">
              <div class="float-left">
                <i class="mdi mdi-cube text-danger icon-lg"></i>
              </div>
              <div class="float-right">
                <p class="mb-0 text-right">Total Revenue</p>
                <div class="fluid-container">
                  <h3 class="font-weight-medium text-right mb-0">৳{{$total_revenue}}</h3>
                </div>
              </div>
            </div>
            <p class="text-muted mt-3 mb-0">
              <i class="mdi mdi-alert-octagon mr-1" aria-hidden="true"></i> Revenue
            </p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
          <div class="card-body">
            <div class="clearfix">
              <div class="float-left">
                <i class="mdi mdi-receipt text-warning icon-lg"></i>
              </div>
              <div class="float-right">
                <p class="mb-0 text-right">Orders</p>
                <div class="fluid-container">
                  <h3 class="font-weight-medium text-right mb-0">{{$total_orders}}</h3>
                </div>
              </div>
            </div>
            <p class="text-muted mt-3 mb-0">
              <i class="mdi mdi-bookmark-outline mr-1" aria-hidden="true"></i> Product-wise sales
            </p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
          <div class="card-body">
            <div class="clearfix">
              <div class="float-left">
                <i class="mdi mdi-poll-box text-success icon-lg"></i>
              </div>
              <div class="float-right">
                <p class="mb-0 text-right">Sales</p>
                <div class="fluid-container">
                  <h3 class="font-weight-medium text-right mb-0">{{$sales}}</h3>
                </div>
              </div>
            </div>
            <p class="text-muted mt-3 mb-0">
              <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> Weekly Sales
            </p>
          </div>
        </div>
      </div>
      <div class="col-xl-3 col-lg-3 col-md-3 col-sm-6 grid-margin stretch-card">
        <div class="card card-statistics">
          <div class="card-body">
            <div class="clearfix">
              <div class="float-left">
                <i class="mdi mdi-account-location text-info icon-lg"></i>
              </div>
              <div class="float-right">
                <p class="mb-0 text-right">Employees</p>
                <div class="fluid-container">
                  <h3 class="font-weight-medium text-right mb-0">0</h3>
                </div>
              </div>
            </div>
            <p class="text-muted mt-3 mb-0">
              <i class="mdi mdi-reload mr-1" aria-hidden="true"></i> Product-wise sales
            </p>
          </div>
        </div>
      </div>
    </div>

    @include('backend.pages.orders.notDelivered', $orders)


    <div class="row">
      <div class="col-lg-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <h4 class="card-title mr-2 mt-2">Orders delivered</h4>
              <form method="post" action="{{route('admin.orderFiltered')}}">
                @csrf
                From: <input type="date" name="dOrderFrom" value="{{$dOrderFrom}}">
                To: <input type="date" name="dOrderTo" value="{{$dOrderTo}}">
                <input class="btn btn-success" type="submit" value="Filter">
              </form>
              <a class="btn btn-primary btn-reset" href="{{route('admin.index')}}">Reset</a>
              <button onclick="javascript:xport.toCSV('ordersDelivered');" class="btn btn-warning btn-reset" id="ordersNotDeliveredPdf"> Download</button>
            </div>
            <div class="table-responsive">
              <table class="table table-bordered" id="ordersDelivered">
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
                  {{-- @php
                  $count = 0;
                  @endphp --}}
                  @if(count($delivered) > 0)
                  @foreach ($delivered as $delivered)
                  {{-- @php
                  $count++;
                  @endphp --}}
                  <tr>
                    <td class="font-weight-medium">
                      {{$delivered->id}}
                    </td>
                    <td>
                      {{$delivered->name}}
                    </td>
                    <td>
                      {{$delivered->location}}
                    </td>
                    <td>
                      {{$delivered->shiping_address}}
                    </td>
                    <td class="text-danger">
                      {{$delivered->book}}
                    </td>
                    <td>
                      {{$delivered->author}}
                    </td>
                    <td>
                      {{$delivered->publisher}}
                    </td>
                    <td>
                      {{$delivered->quantity}}
                    </td>
                    <td>
                      ৳{{$delivered->total_price}}
                    </td>
                    <td>
                      {{$delivered->payment_method}}
                    </td>
                    <td>
                      {{$delivered->transection_id}}
                    </td>
                    <td>
                      @if ($delivered->is_completed == 0)
                      <form action="{!! route('admin.order.delivered', $delivered->id) !!}" method="post">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-success">Set to delivered</button>
                      </form>
                      @else
                      <span class="text-success">Delivered</span>
                      @endif
                    </td>
                    <td>
                      @if ($delivered->order_type == 0)
                      Normal order
                      @else
                      Order as gift
                      @endif
                    </td>
                    <td>
                      @if ($delivered->is_seen_by_admin == 0)
                      <form action="{!! route('admin.order.seen', $delivered->id) !!}" method="post">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-success">Set to seen</button>
                      </form> @php
                      $count = 0;
                      @endphp
                      @else
                      <span class="text-success">seen</span> <br>
                      @endif
                      <button type="submit" href="#deletecatModal{{ $delivered->id }}" data-toggle="modal"
                        class="btn btn-danger mt-2">Delete</button>
                    </td>
                  </tr>

                  <!-- Modal -->
                  <div class="modal fade" id="deletecatModal{{ $delivered->id }}" tabindex="-1" role="dialog"
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
                          <form action="{!! route('admin.order.delete', $delivered->id) !!}" method="post">
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


    <div class="row">
      <div class="col-lg-12 grid-margin">
        <div class="card">
          <div class="card-body">
            <div class="row">
              <h4 class="card-title mr-2 mt-2">Sales</h4>
              <form method="post" action="{{route('admin.orderFiltered')}}">
                @csrf
                From: <input type="date" name="sellFrom" value="{{$sellFrom}}">
                To: <input type="date" name="sellTo" value="{{$sellTo}}">
                <input class="btn btn-success" type="submit" value="Filter">
              </form>
              <a class="btn btn-primary btn-reset" href="{{route('admin.index')}}">Reset</a>
              <button onclick="javascript:xport.toCSV('salesData');" class="btn btn-warning btn-reset" id="ordersNotDeliveredPdf"> Download</button>

            </div>
            <div class="table-responsive">
              <table class="table table-bordered" id="salesData">
                <thead>
                  <tr>
                    <th>
                      #
                    </th>
                    <th>
                      বইয়ের নাম
                    </th>
                    <th>
                      লেখক
                    </th>
                    <th>
                      প্রকাশনী
                    </th>
                    <th>
                      মূল্য
                    </th>
                    <th>
                      বিক্রয়ের তারিখ
                    </th>

                  </tr>
                </thead>
                <tbody>
                  @php
                  $count = 0;
                  @endphp
                  @if(count($bookSold) > 0)

                  @foreach ($bookSold as $bookSold)
                  @php
                  $count++;
                  @endphp
                  <tr>
                    <td class="font-weight-medium">
                      {{$count}}
                    </td>
                    <td>
                      {{$bookSold->title}}
                    </td>
                    <td>
                      {{$bookSold->author}}
                    </td>
                    <td>
                      {{$bookSold->publisher}}
                    </td>
                    <td class="text-danger">
                      {{$bookSold->price}}
                    </td>
                    <td>
                      {{$bookSold->sell_date}}
                    </td>

                  </tr>

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

  </div>
  @endsection

  @section('scripts')
  <script>
      var xport = {
  _fallbacktoCSV: true,  
  toXLS: function(tableId, filename) {   
    this._filename = (typeof filename == 'undefined') ? tableId : filename;
    
    //var ieVersion = this._getMsieVersion();
    //Fallback to CSV for IE & Edge
    if ((this._getMsieVersion() || this._isFirefox()) && this._fallbacktoCSV) {
      return this.toCSV(tableId);
    } else if (this._getMsieVersion() || this._isFirefox()) {
      alert("Not supported browser");
    }

    //Other Browser can download xls
    var htmltable = document.getElementById(tableId);
    var html = htmltable.outerHTML;

    this._downloadAnchor("data:application/vnd.ms-excel" + encodeURIComponent(html), 'xls'); 
  },
  toCSV: function(tableId, filename) {
    this._filename = (typeof filename === 'undefined') ? tableId : filename;
    // Generate our CSV string from out HTML Table
    var csv = this._tableToCSV(document.getElementById(tableId));
    // Create a CSV Blob
    var blob = new Blob([csv], { type: "text/csv" });

    // Determine which approach to take for the download
    if (navigator.msSaveOrOpenBlob) {
      // Works for Internet Explorer and Microsoft Edge
      navigator.msSaveOrOpenBlob(blob, this._filename + ".csv");
    } else {      
      this._downloadAnchor(URL.createObjectURL(blob), 'csv');      
    }
  },
  _getMsieVersion: function() {
    var ua = window.navigator.userAgent;

    var msie = ua.indexOf("MSIE ");
    if (msie > 0) {
      // IE 10 or older => return version number
      return parseInt(ua.substring(msie + 5, ua.indexOf(".", msie)), 10);
    }

    var trident = ua.indexOf("Trident/");
    if (trident > 0) {
      // IE 11 => return version number
      var rv = ua.indexOf("rv:");
      return parseInt(ua.substring(rv + 3, ua.indexOf(".", rv)), 10);
    }

    var edge = ua.indexOf("Edge/");
    if (edge > 0) {
      // Edge (IE 12+) => return version number
      return parseInt(ua.substring(edge + 5, ua.indexOf(".", edge)), 10);
    }

    // other browser
    return false;
  },
  _isFirefox: function(){
    if (navigator.userAgent.indexOf("Firefox") > 0) {
      return 1;
    }
    
    return 0;
  },
  _downloadAnchor: function(content, ext) {
      var anchor = document.createElement("a");
      anchor.style = "display:none !important";
      anchor.id = "downloadanchor";
      document.body.appendChild(anchor);

      // If the [download] attribute is supported, try to use it
      
      if ("download" in anchor) {
        anchor.download = this._filename + "." + ext;
      }
      anchor.href = content;
      anchor.click();
      anchor.remove();
  },
  _tableToCSV: function(table) {
    // We'll be co-opting `slice` to create arrays
    var slice = Array.prototype.slice;

    return slice
      .call(table.rows)
      .map(function(row) {
        return slice
          .call(row.cells)
          .map(function(cell) {
            return '"t"'.replace("t", cell.textContent);
          })
          .join(",");
      })
      .join("\r\n");
  }
};

  </script>
  </html>
  @endsection