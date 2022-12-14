@extends('masterlayout')

@section('title', 'Manage App Users | UPSA Contact Tracing Portal')

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
                <li><a href="/bookingList"><i class="ti ti-calendar"></i><span>Booking List</span></a></li>
                <li><a href="/symptomsList"><i class="ti ti-face-sad"></i><span>Symptoms List</span></a></li>
                @if(Session::has('app_user_role'))
                @if( strtoupper(Session::get('app_user_role')) == "SUPER ADMIN")
                <li><a href="#dropdown-tables" aria-expanded="true" data-toggle="collapse" class="active"><i class="ti-settings"></i><span>Settings</span></a>
                    <ul id="dropdown-tables" class="list-unstyled pt-0">
                        <li><a href="/mobileAppUsers">Mobile App Users</a></li>
                        <li><a href="/applicationUsers" class="sub_active">Portal Users</a></li>

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
                                    <h4>All Portal Users</h4>
                                </div>

                                <div class="col-2">
                                    <h4><a href="#" data-toggle="modal" data-target="#addUserModal" class="btn btn-danger btn-gradient-01 pull-right m-l-20 waves-effect waves-light">Add User</a></h4>
                                </div>
                            </div>

                        </div>

                        <div class="widget-body sliding-tabs">

                            <div class="table-responsive">
                                <table id="appUsersDataTable" style="width:100%" class="table mb-0 table-striped table-hover manage-u-table table-css" role="grid" aria-describedby="sorting-table_info">
                                    <thead>
                                        <tr role="row">
                                            <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Form Order Id: activate to sort column ascending" style="width:10px">#
                                            </th>
                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:300px" aria-label="Full Name: activate to sort column ascending">Full Name
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:50px" aria-label="Username: activate to sort column ascending">Username
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:100px" aria-label="Email: activate to sort column ascending">Email
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:100px" aria-label="Job Position: activate to sort column ascending">Job Position
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:100px" aria-label="App Role: activate to sort column ascending">App Role
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" style="width:50px" aria-label="Created By: activate to sort column ascending">Created By
                                            </th>

                                            <th class="sorting" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="Date: activate to sort column ascending" style="width:300px">Created Date
                                            </th>
                                            <th class="sorting1" tabIndex="0" aria-controls="sorting-table" rowSpan="1" colSpan="1" aria-label="actions: activate to sort column ascending" style="width:200px">Actions
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

    <!--View request wifi modal-->
    <div id="addUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Add User</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="addUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">
                            <div class="col-12">
                                <label class="form-control-label">Full Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addFullname" placeholder="Full Name">
                                    </div>
                                </div>
                            </div>


                            <div class="col-6">
                                <label class="form-control-label">Username</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addUserName" placeholder="User Name">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Password</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-lock"></i>
                                        </span>
                                        <input type="password" class="form-control" id="addPassword" placeholder="Enter a secure password">
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <label class="form-control-label">E-mail Address</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-email"></i>
                                        </span>
                                        <input type="email" class="form-control" id="addEmailAddress" placeholder="E-mail Address">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">Job Position</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-id-badge"></i>
                                        </span>
                                        <input type="text" class="form-control" id="addJobPosition" placeholder="Enter job position">
                                    </div>
                                </div>
                            </div>

                            <div class="col-6">
                                <label class="form-control-label">App User Role</label>
                                <div class="form-group">
                                    <select class="custom-select-roletype form-control" id="addAppUserRole" name="addAppUserRole">
                                        <option value="">Select </option>
                                        <option value="Super Admin">Super Admin</option>
                                        <option value="Admin">Admin</option>
                                        <option value="Regular User">Regular User</option>

                                    </select>
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="addUserBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>


    <!-- Show more details of user -->
    <div id="moreDetailsAdminUserData" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Profile</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-4">
                            <p>Full Name:</p>
                        </div>
                        <div class="col-8">
                            <label>
                                <p id="showAdminFullname"></p>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <p>Username:</p>
                        </div>
                        <div class="col-8">
                            <label>
                                <p id="showAdminUsername"></p>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <p>Email:</p>
                        </div>
                        <div class="col-8">
                            <label>
                                <p id="showAdminEmail"></p>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <p>Created By:</p>
                        </div>
                        <div class="col-8">
                            <label>
                                <p id="showAdminCreatedBy"></p>
                            </label>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-4">
                            <p>Created Date:</p>
                        </div>
                        <div class="col-8">
                            <label>
                                <p id="showAdminCreatedDate"></p>
                            </label>
                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- /.modal to edit users-->
    <div id="editUserModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Edit <span id="displayEditUserName"></span></h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>

                <div class="modal-body">
                    <form id="editUserForm">
                        <div class="form-group row d-flex align-items-center mb-5">

                            <div class="col-12">
                                <label class="form-control-label">Full Name</label>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                            <i class="ti-user"></i>
                                        </span>
                                        <input type="text" class="form-control" id="editFullName" placeholder="Full Name">
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
                    <button type="button" class="btn btn-danger btn-gradient-01 waves-effect waves-light" id="editUserBtn">Submit</button>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- End Page Content -->

@endsection

@push('pageScripts')
<script src="{{asset('assets/js/components/manage_app_users.js')}}"></script>
@endpush