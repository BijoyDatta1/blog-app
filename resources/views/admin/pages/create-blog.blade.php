@extends('admin.layout.main')
@section('main-section')
    <div class="content">
                <div class="container-fluid">

                    <!-- Page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Create Category</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Form Card -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Category Name -->
                                        <div class="col-lg-4">
                                            <div class="form-group mb-0">
                                                <label>Category Name</label>
                                                <input type="text" class="form-control" placeholder="Enter category name">
                                            </div>
                                        </div>

                                        <!-- Status -->
                                        <div class="col-lg-4">
                                            <div class="form-group mb-0">
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

                                        <!-- Category Select -->
                                        <div class="col-lg-4">
                                            <div class="form-group mb-0">
                                                <label for="project-priority">Category</label>
                                                <select class="form-control" data-toggle="select2">
                                                    <option value="MD">Food</option>
                                                    <option value="HI">Environment</option>
                                                    <option value="LW">Politics</option>
                                                </select>
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div class="col-lg-6 mt-3">
                                            <div class="form-group mb-0">
                                                <label>Description</label>
                                                <textarea class="form-control" rows="3" placeholder="Enter description here..."></textarea>
                                            </div>
                                        </div>

                                        <!-- Display (Radio Buttons) -->
                                        <div class="col-lg-6 mt-3">
                                            <div class="form-group mb-0">
                                                <label>Display</label>
                                                <div class="d-flex mt-2">
                                                    <div class="form-check mr-3">
                                                        <input class="form-check-input" type="radio" name="display" id="displayYes" value="yes">
                                                        <label class="form-check-label" for="displayYes">Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="display" id="displayNo" value="no">
                                                        <label class="form-check-label" for="displayNo">No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-12 text-center">
                                            <button type="button" class="btn btn-success waves-effect waves-light">
                                                <i class="fe-check-circle mr-1"></i> Create
                                            </button>
                                        </div>
                                    </div>
                                </div> 
                            </div>
                        </div>
                    </div>

                </div>
            </div>
@endsection
            