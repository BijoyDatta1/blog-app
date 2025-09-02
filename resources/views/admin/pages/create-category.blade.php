@extends('admin.layout.main')
@section('main-section')
                    <div class="content">

                    <!-- Start Content-->
                    <div class="container-fluid">
                        
                        <!-- start page title -->
                        <div class="row">
                            <div class="col-12">
                                <div class="page-title-box">
                                    <h4 class="page-title">Create Category</h4>
                                </div>
                            </div>
                        </div>     
                        <!-- end page title --> 

                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">

                                        <div class="row">
                                            <div class="col-xl-6">
                                                <div class="row">
                                                       <div class="col-lg-6">
                                                            <div class="form-group mb-0">
                                                                <label>Category Name</label>
                                                                <input type="text" class="form-control" placeholder="Enter category name">
                                                            </div>
                                                        </div>

                                                    <div class="col-lg-6">
                                                        <div class="col-lg-6 d-flex align-items-end">
                                                            <div class="form-group mb-0 w-100">
                                                                <label>Status</label>
                                                                <div class="dropdown">
                                                                    <button type="button" class="btn btn-light dropdown-toggle w-100" data-toggle="dropdown" aria-expanded="false">
                                                                        Select Status <i class="mdi mdi-chevron-down"></i>
                                                                    </button>
                                                                    <div class="dropdown-menu">
                                                                        <a class="dropdown-item" href="#">Active</a>
                                                                        <a class="dropdown-item" href="#">Inactive</a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>    

                                        <div class="row mt-3">
                                            <div class="col-12 text-center">
                                                <button type="button" class="btn btn-success waves-effect waves-light m-1"><i class="fe-check-circle mr-1"></i> Create</button>
                                            </div>
                                        </div>

                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>

                        
                    </div> <!-- container -->

                </div> <!-- content -->
@endsection

