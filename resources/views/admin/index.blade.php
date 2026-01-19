@extends('layouts.admin.master')

@section('title', 'Dashboard')

@section('content')
<div class="dashboard-body">
    <!-- Dashboard content goes here -->
    <div class="row gy-4">
        <!-- Revenue Statistics Chart -->
        <div class="col-xxl-8 col-xl-12">
            <div class="card h-100">
                <div class="card-body">
                    <div id="revenueStatistic"></div>
                </div>
            </div>
        </div>
        
        <!-- Income vs Expense Chart -->
        <div class="col-xxl-4 col-xl-6">
            <div class="card h-100">
                <div class="card-body">
                    <div id="incomeExpense"></div>
                </div>
            </div>
        </div>
        
        <!-- New Admissions Chart -->
        <div class="col-xxl-4 col-xl-6">
            <div class="card h-100">
                <div class="card-body">
                    <div id="newAdmissions"></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    @include('layouts.admin.charts')
    @include('layouts.admin.widgets')
@endpush