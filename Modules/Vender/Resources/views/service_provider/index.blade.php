@extends('vender::layouts.master')

@section('css_custom')
<style>
/* --- Global Customizations --- */
.headerbg-custom {
  padding: 15px 15px 0 15px;
}

/* --- Sidebar & Headings --- */
.sidebar-title {
  border-radius: 7px;
  border: 2px solid black;
  padding: 10px;
  font-weight: 600;
  font-size: 17px;
  display: flex;
  align-items: center;
  gap: 8px;
  /* Spaces the icon and text cleanly */
  margin-bottom: 15px;
  margin-top: 0;
}

.sidebar-title img {
  width: 22px;
}

/* --- Top Horizontal Navigation --- */
.top-nav-group {
  display: flex;
  flex-wrap: wrap;
  gap: 15px;
  margin-bottom: 20px;
}

.nav-btn {
  border-radius: 7px;
  border: 2px solid black;
  padding: 10px 15px;
  font-weight: 600;
  font-size: 17px;
  color: black;
  text-decoration: none;
  text-align: center;
  flex: 1 1 auto;
  /* Allows buttons to share space equally */
  min-width: 160px;
  /* Prevents text from getting squeezed on medium screens */
  transition: background-color 0.2s ease-in-out;
}

.nav-btn:hover {
  background-color: #f8f9fa;
  color: black;
}

/* --- Mobile Specific Enhancements --- */
@media (max-width: 767px) {
  .headerbg-custom {
    padding-left: 15px;
  }

  .top-nav-group {
    flex-direction: column;
    gap: 10px;
  }

  .nav-btn {
    width: 100%;
  }
}
</style>
@endsection

@section('header')
<div class="content-header bg-white">
  <div class="row" style="border-bottom: 3px solid #949494; margin: 0;">
    <div class="col-12 bg-white headerbg-custom">
      <h3 class="h3">Service Provider</h3>
      <div class="breadcrumb-wrapper">
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a>Products</a></li>
          <li class="breadcrumb-item">Service Provider</li>
        </ol>
      </div>
    </div>
  </div>
</div>
@endsection

@section('content')

<div class="row mt-3">

  <div class="col-md-3">
    <h4 class="sidebar-title">
      <img src="/service_provider.png" alt="Icon"> Service Provider
    </h4>
  </div>

  <div class="col-md-9" id="contens">

    <div class="top-nav-group">
      <a href="{{route('vender.service.provider.trading.unit')}}" class="nav-btn">
        Trade units
      </a>
      <a href="{{route('vender.service.provider.app.setting')}}" class="nav-btn">
        App settings
      </a>
      <a href="{{route('vender.service.provider.app.data')}}" class="nav-btn">
        App data
      </a>
    </div>

  </div>
</div>

@endsection