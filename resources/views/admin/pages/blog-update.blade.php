<!-- Edit Category Modal -->
<div class="modal fade" id="BlogUpdate" tabindex="-1" role="dialog" aria-labelledby="editCategoryLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title" id="editCategoryLabel">Edit Category</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="modal-body">
                <div id="editCategoryForm">
                    <!-- Hidden ID -->
                    <input type="hidden" id="blog_id" name="category_id">

                    <!-- title Name -->
                    <div class="form-group">
                        <label for="title">Title</label>
                        <input type="text" class="form-control" id="title" name="title"  required>
                    </div>

                    <!-- Category Name -->
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea name="description" class="form-control" id="description" cols="20" rows="5"></textarea>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="category_status">Status</label>
                        <select class="form-control" id="category_status" name="category_status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>

                    {{--select category--}}
                    <div class="form-group mb-0">
                        <label for="project-priority">Category</label>
                        <select id="category" class="form-control" data-toggle="select2" multiple>

                        </select>
                    </div>

                    {{--Radio Button--}}
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

                    {{--image section--}}
                    <div>
                        <br/>
                        <img class="w-15" style="width: 50px" id="oldImg" src="{{asset('backend/images/default.jpg')}}"/>
                        <br/>
                        <label class="form-label mt-2">Image</label>
                        <input oninput="oldImg.src=window.URL.createObjectURL(this.files[0])"  type="file" class="form-control" id="image">
                    </div>

                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" id="update-close-btn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="UpdateBlog()" class="btn btn-primary">Save Changes</button>
            </div>

        </div>
    </div>
</div>
<script>

    async function getCategoryList(){
        let category = document.getElementById('category');
        category.innerHTML = "";
        showLoader();
        let res = await axios.get('/categorylist');
        hideLoader();
        if(res.status === 200 && res.data['status'] === "success"){
            res.data.category.forEach(function (item, index){
                let active = item['status'] === "active" ? `<option value="${item['id']}"> ${item['category_name']} </option>` : null;
                category.innerHTML += active;
            });

        }else{

        }
    }

    async function updateData(id){
        await getCategoryList();
        showLoader();
        let res = await axios.post('/getblogitem',{ id : id })
        hideLoader();

        if(res.status === 200 && res.data['status'] === "success"){

            document.getElementById('title').value = res.data.data['title'];
            document.getElementById('blog_id').value = id;

            let categorySelect = document.getElementById('category');
            let ids = res.data.blogCategoris.map(function (cid){ return String(cid.category_id) });
            Array.from(categorySelect.options).forEach(function(option){
                option.selected = ids.includes(option.value);
            });

            // document.getElementById('display').value = res.data.data['display'] === "1" ? "1" :"0";
            let displayValue = String(res.data.data['display']); // "1" or "0"
            document.getElementsByName('display').forEach(function(radio) {
                radio.checked = (radio.value === displayValue);
            });


            document.getElementById('category_status').value = res.data.data['status'] === 'inactive' ? 'inactive' : 'active';
            document.getElementById('description').value = res.data.data['description'];
            document.getElementById('oldImg').src = res.data.data['image'];
        } else{
            let data = res.data.message;
            if(typeof data === "object"){
                for(let key in data){ errorToast(data[key]); }
            } else {
                errorToast(data);
            }
        }
    }

    async function UpdateBlog(){

        let id  = document.getElementById('blog_id').value;
        let title  = document.getElementById('title').value;
        let description  = document.getElementById('description').value;
        let status  = document.getElementById('category_status').value;

        let displayEl  = document.querySelector('input[name="display"]:checked');
        let display = displayEl ? displayEl.value : null;

        let categorySelect = document.getElementById('category');
        let category_id = Array.from(categorySelect.selectedOptions).map(option => option.value);
        let image  = document.getElementById('image').files[0];

        let formData = {
            id : id,
            title : title,
            status : status,
            description : description,
            image : image,
            display : display,
            category_id : category_id
        }

        showLoader();
        let res = await axios.post('/updateblog',formData,{
            headers : {
                "Content-Type": "multipart/form-data"
            }
        });
        hideLoader();

        if(res.status === 200 && res.data['status'] === "success"){
            successToast(res.data['message']);
            setTimeout(function (){
                getList();
                document.getElementById('update-close-btn').click();
            },1000);
        } else{
            let data = res.data.message;
            if(typeof data === "object"){
                for(let key in data){ errorToast(data[key]); }
            } else {
                errorToast(data);
            }
        }
    }
</script>
