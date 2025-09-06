

@extends('admin.login.main')
@section('main-section')
            <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern">

                            <div class="card-body p-4">

                                <div class="text-center w-75 m-auto">
                                    <div class="auth-logo">
                                        <a href="index.html" class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                                <img src="../assets/images/logo-dark.png" alt="" height="22">
                                            </span>
                                        </a>

                                        <a href="index.html" class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="../assets/images/logo-light.png" alt="" height="22">
                                            </span>
                                        </a>
                                    </div>
                                    <p class="text-muted mb-4 mt-3">Change Password.</p>
                                </div>

                                <div class="div-form">

                                    <div class="form-group mb-3">
                                        <label for="password">Password</label>
                                        <input class="form-control" type="password" id="password" required="" placeholder="Enter your Password">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="Cpassword">Confirm Password</label>
                                        <input class="form-control" type="password" id="Cpassword" required="" placeholder="Enter your Confrim Password">
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button onclick="resetPassword()" class="btn btn-primary btn-block" type="submit">Submit</button>
                                    </div>

                                </div>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-white-50">Back to <a href="/loginpage" class="text-white ml-1"><b>Log in</b></a></p>
                            </div> <!-- end col -->
                        </div>
                        <!-- end row -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

@endsection
<script >
    async function resetPassword(){
        let password = document.getElementById('password').value;
        let Cpassword = document.getElementById('Cpassword').value;
        if(password !== Cpassword){
            errorToast('Password and Confirm Password Not Mach');
        }else{
            showLoader();
            let res = await axios.post("/resetpassword",{
                password : password
            })
            hideLoader();

            if(res.status === 200 && res.data['status'] === "success"){
                successToast(res.data['message']);
                setTimeout(function (){
                    window.location.href = "/loginpage"
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


    }
</script>
