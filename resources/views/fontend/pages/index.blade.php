@extends('fontend.layout.main')
@section('main-section')
    <div class="container-fluid">
        <main class="tm-main">
            <!-- Search area -->
            <div class="row tm-row">
                <div class="col-12">
                    <div class="form-inline tm-mb-80 tm-search-form">
                        <input class="form-control tm-search-input" name="query" id="query" type="text" placeholder="Search..." aria-label="Search">
                        <button class="tm-search-button" type="submit" onclick="search()">
                            <i class="fas fa-search tm-search-icon" aria-hidden="true"></i>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row tm-row" id="postBody">


            </div>

            {{--pagination area--}}
            <div class="row tm-row tm-mt-100 tm-mb-75">
                <div class="tm-prev-next-wrapper">
                    <button class="mb-2 tm-btn tm-btn-primary tm-prev-next tm-mr-20" onclick="prevPage()">Prev</button>
                    <button class="mb-2 tm-btn tm-btn-primary tm-prev-next" onclick="nextPage()">Next</button>
                </div>
                <div class="tm-paging-wrapper">
                    <span class="d-inline-block mr-3">Page</span>
                    <nav class="tm-paging-nav d-inline-block">
                        <ul id="paginationContiner">


                        </ul>
                    </nav>
                </div>
            </div>
            <footer class="row tm-row">
                <hr class="col-12">
                <div class="col-md-6 col-12 tm-color-gray">
                    Design: <a rel="nofollow" target="_parent" href="https://templatemo.com" class="tm-external-link">TemplateMo</a>
                </div>
                <div class="col-md-6 col-12 tm-color-gray tm-copyright">
                    Copyright 2020 Xtra Blog Company Co. Ltd.
                </div>
            </footer>
        </main>
    </div>
@endsection
<script >
    let currentPage = 1;
    // console.log(currentPage);
    let query = ""

    window.onload = ()=>{
        getPost();
    }

    async function getPost(page = 1, query =""){
        // console.log(currentPage);
        let postConteiner = document.getElementById('postBody');
        postConteiner.innerHTML = "";
        showLoader();
        let res = await axios.get(`/getpost?page=${page}&query=${query}`);
        hideLoader();
        // console.log(res.data);
        // return;
        if(res.status === 200 && res.data['status'] === "success"){
            res.data.blog.data.forEach(function (item, index){
                let post = `
                        <article class="col-12 col-md-6 tm-post">
                            <hr class="tm-hr-primary">
                            <a href="/postpage/${item['id']}" class="effect-lily tm-post-link tm-pt-60">
                                <div class="tm-post-link-inner">
                                    <img src="${item['image']}" alt="Image" class="img-fluid">
                                </div>
                                <span class="position-absolute tm-new-badge">New</span>
                                <h2 class="tm-pt-30 tm-color-primary tm-post-title">${item['title']}</h2>
                            </a>
                            <p class="tm-pt-30">
                                ${item['description']}
                            </p>
                            <div class="d-flex justify-content-between tm-pt-45">
                                <span class="tm-color-primary categoryName" >Travel . Events</span>
                                <span class="tm-color-primary">${item['created_at']}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <span>36 comments</span>
                                <span>by ${item['user']['first_name']}</span>
                            </div>
                        </article>`;

                postConteiner.innerHTML += post;


                //print category accroding to blog id
                let allCategory = item['categories'];
                // Get all category spans again (after appending post)
                let categorySpans = document.querySelectorAll('.categoryName');

                // Select the last added span (for this blog only)
                let currentCategorySpan = categorySpans[categorySpans.length - 1];

                // Clear default text
                currentCategorySpan.innerHTML = "";

                // Loop through categories and append names
                for (let i = 0; i < allCategory.length; i++) {
                    currentCategorySpan.innerHTML += allCategory[i]['category_name'];

                    // Add a separator (dot) except after the last item
                    if (i < allCategory.length - 1) {
                        currentCategorySpan.innerHTML += " · ";
                    }
                }

            })

            // send the pagination data
            renderPagination(res.data.blog);

        }
    }

    function renderPagination(paginationData){
        let paginationContiner = document.getElementById('paginationContiner');
        paginationContiner.innerHTML = " ";

        for(let i = 1; i <= paginationData.last_page; i++){
            paginationContiner.innerHTML += `<li class="tm-paging-item ${paginationData.current_page == i ? 'active' : ''}">
                                <a data-page="${i}" onclick="changePage(${i})" class="mb-2 tm-btn tm-paging-link numBar">${i}</a>
                            </li>`
        }
    }

    function changePage(page){
        currentPage = page
        getPost(currentPage);
    }

    function nextPage(){
        let totalPage =  document.querySelectorAll('.numBar');
        if(currentPage < totalPage.length+1){
             currentPage++;
            getPost(currentPage);
        }
    }
    function prevPage(){
        if(currentPage >= 1){
            currentPage--;
            getPost(currentPage);
        }
    }

    function search(){
        query = document.getElementById('query').value.trim();
        currentPage = 1;
         getPost(currentPage,query);
    }


</script>



