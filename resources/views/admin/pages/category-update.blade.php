<!-- Edit Category Modal -->
<div class="modal fade" id="editCategoryModal" tabindex="-1" role="dialog" aria-labelledby="editCategoryLabel" aria-hidden="true">
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
                    <input type="hidden" id="category_id" name="category_id">

                    <!-- Category Name -->
                    <div class="form-group">
                        <label for="category_name">Category Name</label>
                        <input type="text" class="form-control" id="category_name" name="category_name" placeholder="Enter category name" required>
                    </div>

                    <!-- Status -->
                    <div class="form-group">
                        <label for="category_status">Status</label>
                        <select class="form-control" id="category_status" name="category_status" required>
                            <option value="active">Active</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
            </div>

            <!-- Modal Footer -->
            <div class="modal-footer">
                <button type="button" id="update-close-btn" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" onclick="UpdateCategory()" class="btn btn-primary">Save Changes</button>
            </div>

        </div>
    </div>
</div>
<script>
    async function updateData(id){
        showLoader();
        let res = await axios.post('/categoryitem',{ id : id })
        hideLoader();

        if(res.status === 200 && res.data['status'] === "success"){
            document.getElementById('category_name').value = res.data.data['category_name'];
            document.getElementById('category_id').value = res.data.data['id'];
            document.getElementById('category_status').value = res.data.data['status'] === 'inactive' ? 'inactive' : 'active';
        } else{
            let data = res.data.message;
            if(typeof data === "object"){
                for(let key in data){ errorToast(data[key]); }
            } else {
                errorToast(data);
            }
        }
    }

    async function UpdateCategory(){
        // alert('this action ok');
        let id  = document.getElementById('category_id').value; // fixed id field
        let category_name = document.getElementById('category_name').value;
        let status = document.getElementById('category_status').value;

        showLoader();
        let res = await axios.post('/categoryupdate',{
            id: id,
            category_name: category_name,
            status: status
        })
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
