@extends('admin.layout.main')
@section('main-section')
    <div class="content">
                <div class="container-fluid">

                    <!-- Page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">All Category</h4>
                            </div>
                        </div>
                    </div>

                    <!-- datatable -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Manage Category</h4>
                                        <table id="tableData" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>NO</th>
                                                    <th>Category Name</th>
                                                    <th>Category Slug</th>
                                                    <th>Status</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody id="tableList">

                                            </tbody>
                                        </table>

                                    </div> <!-- end card body-->
                                </div> <!-- end card -->
                            </div><!-- end col-->
                        </div>

                </div>
            </div>
@endsection

<script >

    window.onload = function (){
        getList();
    };



    async function getList(){

        showLoader();
        let res = await axios.get('/categorylist');
        hideLoader();



        //for use the jqurey dataTable id selected by jqurey
        let tableData = $("#tableData");
        let tableList = $("#tableList");

        //DataTable(),empty() and destroy() fucntion from jqurey Data Table plagin. those function fast distroy the table and then empty the table
        tableList.empty();


        if(res.status === 200 && res.data['status'] === "success"){
            res.data.category.forEach(function (item, index){
                let row = `<tr>
                    <td>${index + 1}</td>
                    <td>${item['category_name']}</td>
                    <td>${item['category_slug']}</td>
                    <td>${item['status']}</td>
                    <td>

                    </td>
                </tr>`

                tableList.append(row);
            });


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

        // jqurey data table plagin
       let table = new DataTable('#tableData', {
            lengthMenu:[5,10,15,20,30]
        });




    }
</script>

