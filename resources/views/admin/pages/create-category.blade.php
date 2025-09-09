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
                                                                <input type="text" class="form-control" id="category_name" placeholder="Enter category name">
                                                            </div>
                                                        </div>

                                                    <div class="col-lg-6">
                                                        <div class="col-lg-6 d-flex align-items-end">
                                                            <div class="form-group mb-0 w-100">
                                                                <label>Status</label>
                                                                <div class="dropdown">
                                                                    <select id="category_status" type="button" class="btn btn-light dropdown-toggle w-100" >
                                                                        <option class="dropdown-item" value="active">Active</option>
                                                                        <option class="dropdown-item" value="inactive">Inactive</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mt-3">
                                            <div class="col-12 text-center">
                                                <button onclick="CreateCategory()" type="button" class="btn btn-success waves-effect waves-light m-1"><i class="fe-check-circle mr-1"></i> Create</button>
                                            </div>
                                        </div>

                                    </div> <!-- end card-body -->
                                </div> <!-- end card-->
                            </div> <!-- end col-->
                        </div>


                    </div> <!-- container -->

                </div> <!-- content -->
@endsection
<script >
    async function CreateCategory(){
        let category_name = document.getElementById('category_name').value;
        let status = document.getElementById('category_status').value;

        showLoader();
        let res = await axios.post('/createcategory',{
            'category_name' : category_name,
            'status' : status
        });
        hideLoader();
        if(res.status === 200 && res.data['status'] === "success"){
            successToast(res.data['message']);
            setTimeout(function (){
                window.location.href = "/categorylistpage"
            },1000);
        } else{
            let data = res.data.message;
            if(typeof data === "object"){
                for(let key in data){
                    errorToast(data[key]);
                }
            }else{
                errorToast(data);
            }
        }

    }

</script>

