@extends('vender::layouts.master')

@section('css_custom')
<style>
/* 1. Prevent table data from squishing uncomfortably before the scroll kicks in */
#users-list-datatable th,
#users-list-datatable td {
  white-space: nowrap;
}

/* 2. Ensure custom icons in the top cards scale properly and don't overflow */
.media img {
  max-width: 50px;
  /* Adjust this value if your original icons are smaller/larger */
  height: auto;
  object-fit: contain;
}

/* 3. Mobile/Tablet specific enhancements */
@media (max-width: 767px) {

  /* Make the "Add New Member" button full width and centered for easier tapping */
  .justify-content-end {
    justify-content: center !important;
  }

  .justify-content-end .py-2 {
    width: 100%;
  }

  .justify-content-end .btn {
    width: 100%;
    display: block;
    text-align: center;
  }

  /* Adjust search form action buttons to stack neatly on small screens */
  .users-list-filter .align-items-center {
    flex-direction: column;
    margin-top: 10px;
    /* Add breathing room from the dropdown above */
  }

  .users-list-filter .align-items-center .btn {
    width: 100%;
    margin-left: 0 !important;
    /* Overrides the ml-2 on mobile */
    margin-bottom: 10px;
  }
}
</style>
@endsection

@section('content')
<div class="content-body">
  <section class="users-list-wrapper">
    <div class="row">
      <div class="col-xl-4 col-lg-6 col-12">
        <div class="card pull-up">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="warning">{{ $total_teams }}</h3>
                  <h6>Total Team</h6>
                </div>
                <div>
                  <img src="{{ URL::to('assets/icons/Clients.png') }}" alt="">
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>


      <div class="col-xl-4 col-lg-6 col-12">
        <div class="card pull-up">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="warning">{{ $active_teams }}</h3>
                  <h6>Active Team</h6>
                </div>
                <div>
                  <img src="{{ URL::to('assets/icons/Clients.png') }}" alt="">
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>


      <div class="col-xl-4 col-lg-6 col-12">
        <div class="card pull-up">
          <div class="card-content">
            <div class="card-body">
              <div class="media d-flex">
                <div class="media-body text-left">
                  <h3 class="warning">{{ $inactive_teams }}</h3>
                  <h6>InActive Team</h6>
                </div>
                <div>
                  <img src="{{ URL::to('assets/icons/Clients.png') }}" alt="">
                </div>
              </div>

            </div>
          </div>
        </div>
      </div>
    </div>

    <div class="d-flex justify-content-end">
      <div class="py-2">
        <a href="{{route('vender.team.add')}}" class="btn  btn-primary glow"><i class="ft-plus-circle"></i>Add New
          Member </a>
      </div>
    </div>


    <div class="users-list-filter px-1">
      <form method="POST" action="{{ route('vender.team.search') }}">
        @csrf
        <div class="row border border-light rounded py-2 mb-2">
          <div class="col-12 col-sm-6 col-lg-3">
            <label for="users-list-verified">Name</label>
            <fieldset class="form-group">
              <input type="text" class="form-control" name="name" placeholder="Name">
            </fieldset>
          </div>
          <div class="col-12 col-sm-6 col-lg-3">
            <label for="users-list-role">Role</label>
            <fieldset class="form-group">
              <select class="form-control" name="role">
                <option value={{ null }}>Select Role</option>
                @foreach ($roles as $role)


                <option value="{{ $role['id'] }}">{{ $role['name'] }}</option>
                @endforeach

              </select>
            </fieldset>
          </div>
          <div class="col-12 col-sm-6 col-lg-3">
            <label for="users-list-status">Status</label>
            <fieldset class="form-group">
              <select class="form-control" name="status">
                <option value={{ null }}>Select Status</option>
                <option value="Active">Active</option>
                <option value="InActive">InActive</option>

              </select>
            </fieldset>
          </div>
          <div class="col-12 col-sm-6 col-lg-3 d-flex align-items-center">
            <button type="submit" class="btn  btn-primary glow">Search</button>
            <a onclick="window.location.href=`{{ route('vender.team') }}`" class="btn  btn-primary glow ml-2">Reset</a>
          </div>
        </div>
      </form>
    </div>
    <div class="users-list-table">
      <div class="card">
        <div class="card-content">
          <div class="card-body">
            <div class="table-responsive">
              <table id="users-list-datatable" class="table">
                <thead>
                  <tr>
                    <th>Sr No</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach ($teams as $team)
                  <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $team['name'] }}</td>
                    <td>{{ $team['last_name'] }}</td>
                    <td>{{ $team['email'] }}</td>
                    <td>{{ \Carbon\Carbon::parse($team->created_at)->format('F jS, Y') }}</td>
                    <td>
                      @if(count($team->getRoleNames())>0)
                      @foreach ($team->getRoleNames() as $role)
                      <p>{{ $role }}</p>@endforeach
                      @else

                      <p>No Role</p>
                      @endif
                    </td>
                    <td>
                      @if($team['status']=="Active")
                      <span class="badge badge-success">{{ $team['status'] }}</span>
                      @else
                      <span class="badge badge-danger">{{ $team['status'] }}</span>
                      @endif
                    </td>
                    <td><a href="{{route('vender.team.edit',$team['id'])}}"><i class="ft-edit-1"></i></a>
                    </td>
                  </tr>
                  @endforeach





                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
@endsection
@section('css_lib')
<link rel="stylesheet" type="text/css" href="{{asset('/modules/vender')}}/app-assets/vendors/css/vendors.min.css">
<link rel="stylesheet" type="text/css"
  href="{{asset('/modules/vender')}}/app-assets/vendors/css/tables/datatable/datatables.min.css">
<link rel="stylesheet" type="text/css" href="{{asset('/modules/vender')}}/app-assets/css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="{{asset('/modules/vender')}}/app-assets/css/bootstrap-extended.css">
<link rel="stylesheet" type="text/css" href="{{asset('/modules/vender')}}/app-assets/css/colors.css">
<link rel="stylesheet" type="text/css" href="{{asset('/modules/vender')}}/app-assets/css/components.css">
<link rel="stylesheet" type="text/css"
  href="{{asset('/modules/vender')}}/app-assets/css/core/menu/menu-types/horizontal-menu.css">
<link rel="stylesheet" type="text/css"
  href="{{asset('/modules/vender')}}/app-assets/css/core/colors/palette-gradient.css">
<link rel="stylesheet" type="text/css" href="{{asset('/modules/vender')}}/app-assets/css/pages/page-users.css">
<link rel="stylesheet" type="text/css" href="../../../assets/css/style.css">
@endsection
@section('scripts_lib')
<script src="{{asset('/modules/vender')}}/app-assets/vendors/js/vendors.min.js"></script>
<script src="{{asset('/modules/vender')}}/app-assets/vendors/js/ui/jquery.sticky.js"></script>
<script src="{{asset('/modules/vender')}}/app-assets/vendors/js/charts/jquery.sparkline.min.js"></script>
<script src="{{asset('/modules/vender')}}/app-assets/vendors/js/tables/datatable/datatables.min.js"></script>
<script src="{{asset('/modules/vender')}}/app-assets/js/core/app-menu.js"></script>
<script src="{{asset('/modules/vender')}}/app-assets/js/core/app.js"></script>
<script src="{{asset('/modules/vender')}}/app-assets/js/scripts/ui/breadcrumbs-with-stats.js"></script>
<script src="{{asset('/modules/vender')}}/app-assets/js/scripts/pages/page-users.js"></script>
@endsection