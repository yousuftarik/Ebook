<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
    <a class="navbar-brand brand-logo" href="{{route('admin.index')}}">
      <img src="{{ asset('images/logoText.png')}}" alt="logo" style="height: 50px" />
    </a>
    <a class="navbar-brand brand-logo-mini" href="{{route('admin.index')}}">
      <img src="images/logo-mini.svg" alt="logo" />
    </a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center">
    <ul class="navbar-nav navbar-nav-left header-links d-none d-md-flex">
      {{-- <li class="nav-item">
        <a href="#" class="nav-link">Schedule
          <span class="badge badge-primary ml-1">New</span>
        </a>
      </li>
      <li class="nav-item active">
        <a href="#" class="nav-link">
          <i class="mdi mdi-elevation-rise"></i>Reports</a>
      </li> --}}
      <li class="nav-item">
        <a href="{{route('admin.subscription.index')}}" class="nav-link">
          <i class="mdi mdi-bookmark-plus-outline"></i>Subscriptions</a>
      </li>
    </ul>
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="messageDropdown" href="#" data-toggle="dropdown"
          aria-expanded="false">
          <i class="mdi mdi-file-document-box"></i>
          <span class="count">7</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="messageDropdown">
          <div class="dropdown-item">
            <p class="mb-0 font-weight-normal float-left">You have 7 unread mails
            </p>
            <span class="badge badge-info badge-pill float-right">View all</span>
          </div>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img src="images/faces/face4.jpg" alt="image" class="profile-pic">
            </div>
            <div class="preview-item-content flex-grow">
              <h6 class="preview-subject ellipsis font-weight-medium text-dark">David Grey
                <span class="float-right font-weight-light small-text">1 Minutes ago</span>
              </h6>
              <p class="font-weight-light small-text">
                The meeting is cancelled
              </p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img src="images/faces/face2.jpg" alt="image" class="profile-pic">
            </div>
            <div class="preview-item-content flex-grow">
              <h6 class="preview-subject ellipsis font-weight-medium text-dark">Tim Cook
                <span class="float-right font-weight-light small-text">15 Minutes ago</span>
              </h6>
              <p class="font-weight-light small-text">
                New product launch
              </p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <img src="images/faces/face3.jpg" alt="image" class="profile-pic">
            </div>
            <div class="preview-item-content flex-grow">
              <h6 class="preview-subject ellipsis font-weight-medium text-dark"> Johnson
                <span class="float-right font-weight-light small-text">18 Minutes ago</span>
              </h6>
              <p class="font-weight-light small-text">
                Upcoming board meeting
              </p>
            </div>
          </a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
          <i class="mdi mdi-bell"></i>
          <span class="count">4</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list"
          aria-labelledby="notificationDropdown">
          <a class="dropdown-item">
            <p class="mb-0 font-weight-normal float-left">You have 4 new notifications
            </p>
            <span class="badge badge-pill badge-warning float-right">View all</span>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-success">
                <i class="mdi mdi-alert-circle-outline mx-0"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-medium text-dark">Application Error</h6>
              <p class="font-weight-light small-text">
                Just now
              </p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-warning">
                <i class="mdi mdi-comment-text-outline mx-0"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-medium text-dark">Settings</h6>
              <p class="font-weight-light small-text">
                Private message
              </p>
            </div>
          </a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item preview-item">
            <div class="preview-thumbnail">
              <div class="preview-icon bg-info">
                <i class="mdi mdi-email-outline mx-0"></i>
              </div>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-medium text-dark">New user registration</h6>
              <p class="font-weight-light small-text">
                2 days ago
              </p>
            </div>
          </a>
        </div>
      </li>
      <li class="nav-item dropdown d-none d-xl-inline-block">
        <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
        <span class="profile-text">Hello, {{Auth::user()->name}}</span>
          <img class="img-xs rounded-circle" src="{{asset('images/admin/'.Auth::user()->avatar)}}" alt="Profile image">
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
          <a class="dropdown-item p-0">
            <div class="d-flex border-bottom">
              <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                <i class="mdi mdi-bookmark-plus-outline mr-0 text-gray"></i>
              </div>
              <div class="py-3 px-4 d-flex align-items-center justify-content-center border-left border-right">
                <i class="mdi mdi-account-outline mr-0 text-gray"></i>
              </div>
              <div class="py-3 px-4 d-flex align-items-center justify-content-center">
                <i class="mdi mdi-alarm-check mr-0 text-gray"></i>
              </div>
            </div>
          </a>
          <a class="dropdown-item mt-2">
            Manage Accounts
          </a>
          <a class="dropdown-item">
            Change Password
          </a>
          <a class="dropdown-item">
            Check Inbox
          </a>
          {{-- <a class="dropdown-item">
                  Sign Out
                </a> --}}
          <form method="post" action="{{ route('admin.logout') }}">
            @csrf
            <div class="d-flex justify-content-center">
              <button type="submit" class="btn btn-danger btn-fw mt-2">Logout</button>
            </div>
          </form>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button"
      data-toggle="offcanvas">
      <span class="mdi mdi-menu"></span>
    </button>
  </div>
</nav>

<div class="container-fluid page-body-wrapper">
  <nav class="sidebar sidebar-offcanvas" id="sidebar">
    <ul class="nav">
      <li class="nav-item nav-profile">
        <div class="nav-link">
          <div class="user-wrapper">
            <div class="profile-image">
              <img src="{{asset('images/admin/'.Auth::user()->avatar)}}" alt="profile image">
            </div>
            <div class="text-wrapper">
              <p class="profile-name">{{Auth::user()->name}}</p>
              <div>
                @if (Auth::user()->type == 0)
                <small class="designation text-muted">Super admin</small>
                @endif
                @if (Auth::user()->type == 1)
                <small class="designation text-muted">Admin</small>
                @endif
                @if (Auth::user()->type == 2)
                <small class="designation text-muted">Light admin</small>
                @endif
                <span class="status-indicator online"></span>
              </div>
            </div>
          </div>
        </div>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.index')}}">
          <i class="menu-icon mdi mdi-television"></i>
          <span class="menu-title">Dashboard</span>
        </a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="{{route('admin.cat_order.index')}}">
            <i class="menu-icon mdi mdi-television"></i>
            <span class="menu-title">Manage Category order</span>
          </a>
        </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#user_collapse" aria-expanded="false"
          aria-controls="user_collapse">
          <i class="menu-icon fa fa-user-md"></i>
          <span class="menu-title">Manage users</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="user_collapse">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item row d-flex align-items-center">
              <i class="menu-icon fa fa-user"></i>
              <a class="nav-link" href="{{route('admin.user.create')}}">Create user</a>
            </li>
            <li class="nav-item row d-flex align-items-center">
              <i class="menu-icon fa fa-users"></i>
              <a class="nav-link" href="{{route('admin.user.index')}}">All users</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.category.create')}}">
          <i class="menu-icon fa fa-mobile"></i>
          <span class="menu-title">Manage categories</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.discount.index')}}">
          <i class="menu-icon fa fa-mobile"></i>
          <span class="menu-title">Manage discounts</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" data-toggle="collapse" href="#book_collapse" aria-expanded="false"
          aria-controls="book_collapse">
          <i class="menu-icon fa fa-book"></i>
          <span class="menu-title">Manage books</span>
          <i class="menu-arrow"></i>
        </a>
        <div class="collapse" id="book_collapse">
          <ul class="nav flex-column sub-menu">
            <li class="nav-item row d-flex align-items-center">
              <i class="menu-icon fa fa-book"></i>
              <a class="nav-link" href="{{route('admin.book.create')}}">Add book</a>
            </li>
            <li class="nav-item row d-flex align-items-center">
              <i class="menu-icon fa fa-book"></i>
              <a class="nav-link" href="{{route('admin.book.index')}}">All books</a>
            </li>
          </ul>
        </div>
      </li>

      <li class="nav-item">
        <a class="nav-link" href="{{route('admin.author.create')}}">
          <i class="menu-icon fa fa-male"></i>
          <span class="menu-title">Manage authors</span>
        </a>
      </li>
      <li class="nav-item">
          <a class="nav-link" href="{{route('admin.publisher.create')}}">
              <i class="menu-icon fa fa-id-badge"></i>
            <span class="menu-title">Manage publishers</span>
          </a>
        </li>

      {{-- <li class="nav-item mt-3">
        <form class="form-inline" action="{{ route('admin.logout') }}" method="post">
      @csrf
      <input type="submit" value="Logout" class="btn btn-danger ml-auto mr-auto">
      </form>

      </li> --}}

    </ul>
  </nav>