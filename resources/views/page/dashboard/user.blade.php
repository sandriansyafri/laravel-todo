@extends('layouts.admin.main')

@section('title')
Dashboard
@endsection

@section('content')
<div class="row">
    <div class="col-12 col-sm-6 col-md-3">
      <a href="{{ route('todo.index') }}" class="text-dark">
        <div class="info-box">
            <span class="info-box-icon bg-info elevation-1"><i class="fas fa-ellipsis-h"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">All Todo</span>
                <span class="info-box-number">
                    {{ $count_all_todo }}
                    <small>task</small>
                </span>
            </div>
            <!-- /.info-box-content -->
        </div>
      </a>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
      <a href="{{ route('todo.index') }}" class="text-dark">
        <div class="info-box mb-3">
            <span class="info-box-icon bg-success elevation-1"><i class="fas fa-check"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Completed</span>
                <span class="info-box-number">{{ $count_completed_todo }}</span>
            </div>
            <!-- /.info-box-content -->
        </div>
      </a>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->
    <div class="col-12 col-sm-6 col-md-3">
        <a href="{{ route('todo.index') }}" class="text-dark">
            <div class="info-box mb-3">
                <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-spinner"></i></span>
    
                <div class="info-box-content">
                    <span class="info-box-text">Not yet</span>
                    <span class="info-box-number">{{ $count_not_yet_todo }}</span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </a>
        <!-- /.info-box -->
    </div>
    <!-- /.col -->



</div>
@endsection