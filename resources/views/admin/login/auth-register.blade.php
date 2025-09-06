
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
                                    <p class="text-muted mb-4 mt-3">Don't have an account? Create your account, it takes less than a minute</p>
                                </div>

                                <div class="form-div" >

                                    <div class="form-group">
                                        <label for="fastName">Full Fast Name</label>
                                        <input class="form-control" type="text" id="fastName" placeholder="Enter your Fast Name" required>
                                    </div>

                                    <div class="form-group">
                                        <label for="lastName">Full Name</label>
                                        <input class="form-control" type="text" id="lastName" placeholder="Enter your Last name" required>
                                    </div>


                                    <div class="form-group">
                                        <label for="email">Email address</label>
                                        <input class="form-control" type="email" id="email" required placeholder="Enter your email">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input type="password" id="password" class="form-control" placeholder="Enter your password">
                                            <div class="input-group-append" data-password="false">
                                                <div class="input-group-text">
                                                    <span class="password-eye"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="checkbox-signup">
                                            <label class="custom-control-label" for="checkbox-signup">I accept <a href="javascript: void(0);" class="text-dark">Terms and Conditions</a></label>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0 text-center">
                                        <button onclick="registetion()" class="btn btn-success btn-block" type="submit"> Sign Up </button>
                                    </div>

                                </div>

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                        <div class="row mt-3">
                            <div class="col-12 text-center">
                                <p class="text-white-50">Already have account?  <a href="/loginpage" class="text-white ml-1"><b>Sign In</b></a></p>
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

<script>
    async function registetion(){
        let first_name = document.getElementById('fastName').value;
        let last_name = document.getElementById('lastName').value;
        let email = document.getElementById('email').value;
        let password = document.getElementById('password').value;

        showLoader();
        let res = await axios.post('/registation',{
            first_name: first_name,
            last_name : last_name,
            email : email,
            password : password
        });
        hideLoader();

        if(res.status === 200 && res.data['status'] === "success"){
            setTimeout(function (){
                successToast(res.data['message']);
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

