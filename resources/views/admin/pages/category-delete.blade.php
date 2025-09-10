<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmModal" tabindex="-1" role="dialog" aria-labelledby="deleteConfirmLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title" id="deleteConfirmLabel">Confirm Delete</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this item?
                <input type="hidden" id="deleteCategoryId">
            </div>
            <div class="modal-footer">
                <button type="button" id="delete-close-btn" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                <button type="button" onclick="deleteCategoy()" id="confirmDeleteBtn" class="btn btn-danger">Confirm</button>
            </div>
        </div>
    </div>
</div>
<script >
    async function deleteCategoy() {
        let id = document.getElementById('deleteCategoryId').value
        showLoader()
        let res = await axios.post('/categorydelete', {
            id: id
        });
        hideLoader()

        if (res.status === 200 && res.data['status'] === "success") {
            successToast(res.data['message']);
            setTimeout(function () {
                getList();
                document.getElementById('delete-close-btn').click();
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
</script>
