@extends('masterlayout')

@section('title', 'Isolated Persons | UPSA Contact Tracing Portal')

@section('content')

<!-- Begin Page Content -->
<div class="page-content d-flex align-items-stretch">
    <div class="w3-card-2 w3-white panel default-sidebar">
        <!-- Begin Side Navbar -->
        <nav class="side-navbar box-scroll sidebar-scroll">
            <!-- Begin Main Navigation -->
            <ul class="list-unstyled">
                <li><a href="/" class="active"><i class="ti ti-support"></i><span>Isolated Persons</span></a></li>
                <li><a href="/autoTracingUsers"><i class="ti ti-mobile"></i><span>Auto Tracing Users</span></a></li>
                <li><a href="/bookingList"><i class="ti ti-calendar"></i><span>Booking List</span></a></li>
                <li><a href="/symptomsList"><i class="ti ti-face-sad"></i><span>Symptoms List</span></a></li>
                @if(Session::has('app_user_role'))
                @if( strtoupper(Session::get('app_user_role')) == "SUPER ADMIN" )
                <li><a href="#dropdown-tables" aria-expanded="false" data-toggle="collapse"><i class="ti-settings"></i><span>Settings</span></a>
                    <ul id="dropdown-tables" class="collapse list-unstyled pt-0">
                        <li><a href="/mobileAppUsers">Mobile App Users</a></li>
                        <li><a href="/applicationUsers">Portal Users</a></li>

                    </ul>
                </li>
                @endif
                @endif

                <li><a href="#" id="logoutDashBtn"><i class="ion-log-out"></i><span>Log Out</span></a></li>

            </ul>

            <!--<span class="heading">Title</span>-->

            <!--<ul class="list-unstyled">-->
            <!--<li><a href="db-all.html"><i class="la la-angle-left"></i><span>Back To Elisyam</span></a></li>-->
            <!--</ul>-->
            <!-- End Main Navigation -->
        </nav>
        <!-- End Side Navbar -->
    </div>
    <!-- End Left Sidebar -->
    <div class="content-inner">
        <div class="container-fluid">

            <!-- Export -->

            <div class="row">
                <!-- Begin Row -->

                <div class="col-12">
                    <div class="w3-card-2 w3-white panel widget has-shadow">
                        <div class="widget-header bordered no-actions">
                            <div class="row">
                                <div class="col-10">
                                    <h4>All Isolated Persons</h4>
                                </div>
                            </div>

                        </div>

                        <div class="widget-body sliding-tabs">

                            <div class="table-responsive">
                                <table id="appUsersDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting1">#
                                            </th>
                                            <th class="sorting">Isolated User
                                            </th>

                                            <th class="sorting">Selected Symptoms
                                            </th>

                                            <th class="sorting">Severity Condition
                                            </th>

                                            <th class="sorting">Contact Traced Persons
                                            </th>

                                            <th class="sorting">Contact Traced Mobile
                                            </th>

                                            <th class="sorting">Isolation Days
                                            </th>

                                            <th class="sorting">Reported Date
                                            </th>
                                        </tr>
                                    </thead>

                                </table>
                            </div>

                        </div>
                    </div>

                </div>

            </div>
            <!-- End Row -->


        </div>
        <!-- End Container -->
        <!-- Begin Page Footer-->
        <footer class="main-footer fixed-footer">
            <div class="row">
                <div class="col-xl-6 col-lg-6 col-6 col-sm-12 d-flex align-items-center justify-content-xl-start justify-content-lg-start justify-content-md-start justify-content-center">
                    <p class="text-gradient-02"><b>&copy; 2022, UPSA Contact Tracing Portal</b> | All Rights Reserved</p>
                </div>
                <div class="col-xl-6 col-lg-6 col-6 col-sm-12 d-flex align-items-center justify-content-xl-end justify-content-lg-end justify-content-md-end justify-content-center">

                </div>
            </div>
        </footer>
        <!-- End Page Footer -->
        <a href="#" class="go-top"><i class="la la-arrow-up"></i></a>
        <!-- Offcanvas Sidebar -->

        <!-- End Offcanvas Sidebar -->
    </div>
    <!-- End Content -->


</div>
<!-- End Page Content -->

@endsection

@push('pageScripts')
<script src="{{asset('assets/js/components/isolated_persons.js')}}"></script>
@endpush