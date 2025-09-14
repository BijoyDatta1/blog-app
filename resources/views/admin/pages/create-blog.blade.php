@extends('admin.layout.main')
@section('main-section')
    <style>
        #BlogImgPreview {
            margin-top: 10px;
        }

        #BlogImgPreview img {
            max-width: 100%;
            max-height: 100px;
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 5px;
            background: #f9f9f9;
        }
    </style>

    <div class="content">
                <div class="container-fluid">

                    <!-- Page title -->
                    <div class="row">
                        <div class="col-12">
                            <div class="page-title-box">
                                <h4 class="page-title">Create Blog</h4>
                            </div>
                        </div>
                    </div>

                    <!-- Form Card -->
                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="row">
                                        <!-- Blog Name -->
                                        <div class="col-lg-4">
                                            <div class="form-group mb-0">
                                                <label>Blog Title</label>
                                                <input type="text" id="title" class="form-control" placeholder="Blog Title">
                                            </div>
                                        </div>

                                        <!-- Status -->
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

                                        <!-- Category Select -->
                                        <div class="col-lg-4">
                                            <div class="form-group mb-0">
                                                <label for="project-priority">Category</label>
                                                <select id="category" class="form-control" data-toggle="select2" multiple>

                                                </select>
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div class="col-lg-6 mt-3">
                                            <div class="form-group mb-0">
                                                <label>Description</label>
                                                <textarea id="description" class="form-control" rows="3" placeholder="Enter description here..."></textarea>
                                            </div>
                                        </div>

                                        <!-- Display (Radio Buttons) -->
                                        <div class="col-lg-6 mt-3">
                                            <div class="form-group mb-0">
                                                <label>Display</label>
                                                <div class="d-flex mt-2">
                                                    <div class="form-check mr-3">
                                                        <input class="form-check-input" type="radio" name="display" id="displayYes" value="1">
                                                        <label class="form-check-label" for="displayYes" >Yes</label>
                                                    </div>
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="radio" name="display" id="displayNo" value="0">
                                                        <label class="form-check-label" for="displayNo" >No</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6 mt-3">
                                        <input type="file" id="blogImageInput" accept="image/*">
                                        <div id="BlogImgPreview">
                                            <img src="{{url('backend/images/default.jpg')}}">
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div class="col-12 text-center">
                                            <button onclick="createBlog()" type="button" class="btn btn-success waves-effect waves-light">
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

<script >
    window.onload = function (){
        getCategoryList();
        imageChange();
    }
    async function createBlog(){

        let title = document.getElementById('title').value;
        let status = document.getElementById('category_status').value;
        let categorySelect = document.getElementById('category');
        let category = Array.from(categorySelect.selectedOptions).map(option => option.value);
        let description = document.getElementById('description').value;
        let displayEl  = document.querySelector('input[name="display"]:checked');
        let display = displayEl ? displayEl.value : null;
        let image = document.getElementById('blogImageInput').files[0];

        let formData = {
            title : title,
            status : status,
            description : description,
            image : image,
            display : display,
            category_id : category
        }


        showLoader();
        let res = await axios.post('/createblog',formData,{
            headers : {
                "Content-Type": "multipart/form-data"
            }
        });
        hideLoader();

        if (res.status === 200 && res.data['status'] === "success") {
            successToast(res.data.message);
            setTimeout(function (){
                window.location.href = "/bloglistpage";
            },1000);
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

    function imageChange(){
        document.getElementById("blogImageInput").addEventListener("change", function(event) {
            let preview = document.getElementById("BlogImgPreview");
            preview.innerHTML = ""; // clear previous preview

            let file = event.target.files[0]; // get the selected file
            if (file) {
                let reader = new FileReader(); // create FileReader
                reader.onload = function(e) {
                    let img = document.createElement("img"); // create <img>
                    img.src = e.target.result; // set image src
                    img.id = "imgpath";
                    preview.appendChild(img); // add image inside preview div
                }
                reader.readAsDataURL(file); // read file as base64 data
            }
        });
    }

    async function getCategoryList(){
        showLoader();
        let res = await axios.get('/categorylist');
        hideLoader();

        let category = document.getElementById('category');

        if (res.status === 200 && res.data['status'] === "success") {
            let allCategory = res.data.category;
            allCategory.forEach(function (item, index){
                if(item['status'] === "inactive"){
                    return;
                }
                category.innerHTML += `<option value ="${item['id']}">${item['category_name']}</option>`
            })
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
</script>
