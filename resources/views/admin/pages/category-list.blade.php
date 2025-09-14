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


<script >

    window.onload = function (){
        getList();
    };

    async function statusUpdate(id, status){
        showLoader();
        let res = await  axios.post('/categorystatus',{
            id : id,
            status : status
        });
        hideLoader();

        if (res.status === 200 && res.data['status'] === "success") {
            successToast(res.data['message']);
            setTimeout(function () {
                getList();
            }, 1000);
        } else {
            let data = res.data.message;
            if (typeof data === "object") {
                for (let key in data) {
                    errorToast(data[key]);
                }
            } else {
                errorToast(data);
            }
        }

    }

    let tableInstance = null;


    async function getList(){

        showLoader();
        let res = await axios.get('/categorylist');
        hideLoader();




        //DataTable(),empty() and destroy() fucntion from jqurey Data Table plagin. those function fast distroy the table and then empty the table
        let tableList = $("#tableList");
        tableList.empty();

        if(res.status === 200 && res.data['status'] === "success"){
            res.data.category.forEach(function (item, index){
                let badge = item['status'] == "active" ? "badge badge-success" : "badge badge-danger";
                let button = item['status'] == "active"
                    ? `<button type="button" data-id="${item['id']}" data-status ="inactive" class="btn StatusButton btn-warning">Inactive</button>`
                    : `<button type="button" data-id="${item['id']}" data-status ="active" class="btn StatusButton btn-success">Active</button>`;
                let row = `<tr>
                    <td>${index + 1}</td>
                    <td>${item['category_name']}</td>
                    <td>${item['category_slug']}</td>
                    <td><span class="${badge}">${item['status']}</span></td>
                    <td>
                        <button type="button" data-id="${item['id']}" class="btn EditButton btn-success">Edit</button>
                        <button type="button" data-id="${item['id']}" class="btn DeleteButton btn-danger">Delete</button>
                        ${button}
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
        let buttons = document.querySelectorAll('.EditButton');
        buttons.forEach(function(button){
            button.addEventListener("click", function (){
                let id = this.getAttribute('data-id');
                let modal = new bootstrap.Modal(document.getElementById('editCategoryModal'));
                modal.show();
                updateData(id);
            })
        })

        let DeleteButtons = document.querySelectorAll('.DeleteButton');
        DeleteButtons.forEach(function(button){
            button.addEventListener('click',function(){
                let id = this.getAttribute('data-id');
                let modal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
                modal.show();
                document.getElementById('deleteCategoryId').value = id
            })
        })

        let StatusButton = document.querySelectorAll('.StatusButton');
        StatusButton.forEach(function(button){
            button.addEventListener('click',function (){
                let id = this.getAttribute('data-id');
                let status = this.getAttribute('data-status');
                statusUpdate(id, status);
            })
        })

        // Destroy existing DataTable instance if already initialized
        if (tableInstance) {
            tableInstance.destroy();
        }

        // jqurey data table plagin
       let tableInstance  = new DataTable('#tableData', {
            lengthMenu:[5,10,15,20,30]
        });


    }
</script>
    @include('admin.pages.category-update')
    @include('admin.pages.category-delete')
@endsection

