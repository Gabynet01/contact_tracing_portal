@extends('masterlayout')

@section('title', 'Booking List Users | UPSA Contact Tracing Portal')

@section('content')

<!-- Begin Page Content -->
<div class="page-content d-flex align-items-stretch">
    <div class="w3-card-2 w3-white panel default-sidebar">
        <!-- Begin Side Navbar -->
        <nav class="side-navbar box-scroll sidebar-scroll">
            <!-- Begin Main Navigation -->
            <ul class="list-unstyled">
                <li><a href="/"><i class="ti ti-support"></i><span>Isolated Persons</span></a></li>
                <li><a href="/autoTracingUsers"><i class="ti ti-mobile"></i><span>Auto Tracing Users</span></a></li>
                <li><a href="/bookingList" class="active"><i class="ti ti-calendar"></i><span>Booking List</span></a></li>
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
                                    <h4>All Booking List</h4>
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
                                            <th class="sorting">UPSA ID
                                            </th>

                                            <th class="sorting">Booking Code
                                            </th>

                                            <th class="sorting">Booked Date
                                            </th>

                                            <th class="sorting">Visited Status
                                            </th>

                                            <th class="sorting">Visited Date
                                            </th>

                                            <th class="sorting">Result Status
                                            </th>

                                            <th class="sorting">Result Date
                                            </th>

                                            <th class="sorting">Result Confirmed By
                                            </th>

                                            <th class="sorting">Actions
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

    <!-- /.modal to edit users-->
    <div id="bookingModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <span id="displayUpsaUser"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="editUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-6">
                                <label class="form-control-label">UPSA ID</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="upsaId" placeholder="UPSA ID" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Booking Code</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-calendar"></i>
                                        </span>
                                        <input type="text" class="form-control" id="bookingCode" placeholder="Booking Code" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-control-label">Select Visited Status</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-agenda"></i>
                                        </span>
                                        <select class="form-control" id="visitedStatus">
                                            <option value="">Please select status</option>
                                            <option value="NO">Not Visited</option>
                                            <option value="YES">Visited</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Visited Date</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-calendar"></i>
                                        </span>
                                        <input type="text" class="form-control" id="bookingDateRange" placeholder="Tap to select a date">
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>

                    <!--Loader and notification messages-->
                    <div class="modal_loader" style="display: none;">
                        <div align="center" style="margin-bottom:15px;" class="">
                            <div class="-spinner-ring -error-"></div>
                            <h5><span class="modalAlertPlaceHolder"></span></h5>
                        </div>
                    </div>

                    <div align="center">
                        <h5><span class="modalAlertPlaceHolder"></span></h5>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="updateBookingBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

    <div id="testResultModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <span id="displayUpsaUser2"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="editUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-6">
                                <label class="form-control-label">UPSA ID</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="upsaId2" placeholder="UPSA ID" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Booking Code</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-calendar"></i>
                                        </span>
                                        <input type="text" class="form-control" id="bookingCode2" placeholder="Booking Code" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-control-label">Visited Status</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-agenda"></i>
                                        </span>
                                        <select class="form-control" id="visitedStatus2" disabled>
                                            <option value="">Please select status</option>
                                            <option value="NO">Not Visited</option>
                                            <option value="YES">Visited</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Visited Date</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-calendar"></i>
                                        </span>
                                        <input type="text" class="form-control" id="visitedDate" placeholder="Tap to select a date" disabled>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <label class="form-control-label">Select Test Result Status</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-agenda"></i>
                                        </span>
                                        <select class="form-control" id="testResultStatus">
                                            <option value="">Please select status</option>
                                            <option value="POSITIVE">POSITIVE</option>
                                            <option value="NEGATIVE">NEGATIVE</option>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Select Test Result Date</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-calendar"></i>
                                        </span>
                                        <input type="text" class="form-control" id="testResultDateRange" placeholder="Tap to select a date">
                                    </div>
                                </div>
                            </div>

                        </div>

                    </form>

                    <!--Loader and notification messages-->
                    <div class="modal_loader" style="display: none;">
                        <div align="center" style="margin-bottom:15px;" class="">
                            <div class="-spinner-ring -error-"></div>
                            <h5><span class="modalAlertPlaceHolder"></span></h5>
                        </div>
                    </div>

                    <div align="center">
                        <h5><span class="modalAlertPlaceHolder"></span></h5>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="updateTestResultBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>


</div>
<!-- End Page Content -->

@endsection

@push('pageScripts')
<script src="{{asset('assets/js/components/booking_list.js')}}"></script>
@endpush