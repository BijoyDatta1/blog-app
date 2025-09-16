@extends('admin.layout.main')
@section('main-section')
    <div class="content">
                <div class="container-fluid">

                    <!-- Page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">All Blogs</h4>
                            </div>
                        </div>
                    </div>

                    <!-- datatable -->

                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">Manage Blog</h4>
                                        <p class="text-muted font-13 mb-4">
                                            DataTables has most features enabled by default, so all you need to do to use it with your own tables is to call the construction
                                            function:
                                        </p>

                                        <table id="tableData" class="table dt-responsive nowrap w-100">
                                            <thead>
                                                <tr>
                                                    <th>NO</th>
                                                    <th>Image</th>
                                                    <th>Title</th>
                                                    <th>Status</th>
                                                    <th>Display</th>
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
    @include("admin.pages.blog-update")
    @include("admin.pages.blog-delete")
@endsection
<style>
    .BlogImag{
        height: 50px;
    }
</style>

<script>
    window.onload = ()=>{
        getList();
    }

    async function statusUpdate(id, status){
        showLoader();
        let res = await  axios.post('/blogstatus',{
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


    async function getList(){
        showLoader();
        let res = await axios.get('/getbloglist');
        hideLoader();


        //for use the jqurey dataTable id selected by jqurey
        let tableData = $("#tableData");
        let tableList = $("#tableList");

        //DataTable(),empty() and destroy() fucntion from jqurey Data Table plagin. those function fast distroy the table and then empty the table

        tableList.empty();

        if(res.status === 200 && res.data['status'] === "success"){
            res.data.data.forEach(function (item, index){
                let display = item['display'] == "1" ? "Yes" : "No";
                let badge = item['status'] == "active" ? "badge badge-success" : "badge badge-danger";
                let button = item['status'] == "active"
                    ? `<button type="button" data-id="${item['id']}" data-status ="inactive" class="btn StatusButton btn-warning">Inactive</button>`
                    : `<button type="button" data-id="${item['id']}" data-status ="active" class="btn StatusButton btn-success">Active</button>`;
                let row = `<tr>
                    <td>${index + 1}</td>
                    <td><img class="BlogImag" src="${window.location.origin}${item['image']}"></td>
                    <td>${item['title']}</td>
                    <td><span class="${badge}">${item['status']}</span></td>
                    <td>${display}</td>
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
                let modal = new bootstrap.Modal(document.getElementById('BlogUpdate'));
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

        // jqurey data table plagin
        let table = new DataTable('#tableData', {
            lengthMenu:[5,10,15,20,30]
        });
        table.destroy();
    }
</script>


