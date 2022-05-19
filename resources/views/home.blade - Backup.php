@extends('layouts.app')

@section('content')
<div class="content-wrapper" style="min-height: 480px !important">
    <section class="content" style="margin-top: 5px">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12 col-sm-4 col-md-4">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cog"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><strong>Production Count</strong></span>
                <span class="info-box-number">
                  @foreach ($card_num_prod as $card_num)
                      {{ $card_num->Prod }}
                  @endforeach
                  <small><strong>Total</strong></small>
                </span>
              </div>
            </div>
          </div>
          
          <div class="col-12 col-sm-4 col-md-4">
            <div class="info-box mb-3">
              <span class="info-box-icon bg-danger elevation-1"><i class="fas fa-thumbs-up"></i></span>

              <div class="info-box-content">
                <span class="info-box-text"><strong>Non Production</strong></span>
                <span class="info-box-number">
                  @foreach ($card_num_prod as $card_num)
                      {{ $card_num->NonProd }}
                  @endforeach
                  <small><strong>Total</strong></small>
                </span>
              </div>
            </div>
          </div>

          <div class="col-12 col-sm-4 col-md-4">
            <div class="info-box mb-3">
              
              <span class="info-box-icon bg-warning elevation-1">
                <a href="javascript:void(0)" data-toggle="modal" data-target="#modal-lg-team-ticket">
                  <i class="fas fa-users"></i>
                </a>
              </span>

              <div class="info-box-content">
                <span class="info-box-text"><strong>Total Active Agents</strong></span>
                <span class="info-box-number">
                  {{ $activeMem }} out of {{ $myTeam }}
                  <small><strong>Logged In</strong></small>
                </span>
              </div>
            </div>
          </div>
          <div class="clearfix hidden-md-up"></div>
        </div>

        @if (Auth::user()->access_level == 2)
          @include('dashboard.agentdashboard')
        @elseif(Auth::user()->access_level == 3 || Auth::user()->access_level == 4)
          @include('dashboard.leaddashboard')
          @include('dashboard.emaildashboard')
        @else
          @include('dashboard.managerdashboard')
        @endif
        
      </div>
    </section>
  </div>
  @include('modals.teamtickets')
@endsection
<!-- modalsssss.teamtickets -->
