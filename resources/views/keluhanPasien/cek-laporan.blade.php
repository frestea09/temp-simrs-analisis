<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>SIPEKA</title>
        <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
        <!-- Bootstrap icons-->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
        <!-- Google fonts-->
        <link rel="preconnect" href="https://fonts.gstatic.com" />
        <link href="https://fonts.googleapis.com/css2?family=Newsreader:ital,wght@0,600;1,600&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Mulish:ital,wght@0,300;0,500;0,600;0,700;1,300;1,500;1,600;1,700&amp;display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Kanit:ital,wght@0,400;1,400&amp;display=swap" rel="stylesheet" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="/css/styles.css" rel="stylesheet" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>


    <style>
        @import url("https://fonts.googleapis.com/css2?family=Poppins:weight@100;200;300;400;500;600;700;800&display=swap");


body{
 background-color:#eee;
 font-family: "Poppins", sans-serif;
 font-weight: 300;
}

.height{
 height: 30vh;
}


.search{
position: relative;
box-shadow: 0 0 40px rgba(51, 51, 51, .1);
  
}

.search input{

 height: 60px;
 text-indent: 25px;
 border: 2px solid #d6d4d4;


}


.search input:focus{

 box-shadow: none;
 border: 2px solid blue;


}

.search .fa-search{

 position: absolute;
 top: 20px;
 left: 16px;

}

.search button{

 position: absolute;
 top: 5px;
 right: 5px;
 height: 50px;
 width: 110px;
 background: blue;

}
</style>



    <body id="page-top">
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top shadow-sm" id="mainNav">
            <div class="container px-5">
                <a class="navbar-brand fw-bold" href="#page-top">SIPEKA</a>
                <img src="/images/{{ configrs()->logo }}" style="max-height:40px; width:auto;">
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="bi-list"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto me-4 my-3 my-lg-0">
                        <li class="nav-item"><a class="nav-link me-lg-3" href="/sipeka">Home</a></li>
                        <li class="nav-item"><a class="nav-link me-lg-3" href="/sipeka/cari-laporan">Cek Laporan</a></li>
                    </ul>
                    {{-- <button class="btn btn-primary rounded-pill px-3 mb-2 mb-lg-0" data-bs-toggle="modal" data-bs-target="#feedbackModal">
                        <span class="d-flex align-items-center">
                            <i class="bi-chat-text-fill me-2"></i>
                            <span class="small">Send Feedback</span>
                        </span>
                    </button> --}}
                </div>
            </div>
        </nav>
        {{-- <!-- Mashead header-->
        <header class="masthead">
            <div class="container px-5">
                <div class="row gx-5 align-items-center">
                    <div class="col-lg-6">
                        <!-- Mashead text and app badges-->
                        <div class="mb-5 mb-lg-0 text-center text-lg-start">
                            <h1 class="display-1 lh-1 mb-3">SIPEKA</h1>
                            <p class="lead fw-normal text-muted mb-5">Laporkan Keluhan Anda Di SIPEKA!</p>
                        </div>
                    </div>
                    <div class="col-lg-6">
                      <div class="masthead-device-mockup">
                        
                      
                      </div>
                      </div>
                    </div>
                </div>
            </div>
        </header> --}}
        <section id="features">
          <div class="container px-5">
            <form action="/sipeka/cari">
                <div class="row height d-flex justify-content-center align-items-center">

                    <div class="col-md-8">

                      <div class="search">
                        <i class="fa fa-search"></i>
                        <input type="text" name="cari" class="form-control" placeholder="Cari Laporan Di Sini !">
                        <button class="btn btn-primary">Cari</button>
                      </div>
                      
                    </div>
                  </div>
             </form>


             @isset($sipeka)
                     @foreach ($sipeka as $sip)
                     <div class="card text-center mt-5">
                         <div class="card-header">
                             {{ $sip->bagian_permasalahan }}
                         </div>
                         <div class="card-body">
                           <h5 class="card-title">komplain :</h5>
                           <p class="card-text">{{ $sip->komplain }}</p>
     
     
                           @if ($sip->disposisi == null)
                           <i><button class="btn btn-primary btn-sm">Kasubag</button></i>
                           
                           {{-- disposisi 1 --}}
                           @elseif($sip->disposisi == 1 && $sip->user_bidang_id == 390)
                           <i><button class="btn btn-info btn-sm">Kabag Keuangan</button></i>
                           @elseif($sip->disposisi == 1 && $sip->user_bidang_id == 850)
                           <i><button class="btn btn-info btn-sm">Kabid Pelayanan Medis</button></i>
                           @elseif($sip->disposisi == 1 && $sip->user_bidang_id == 1310)
                           <i><button class="btn btn-info btn-sm">Kabid Keperawatan</button></i>
                           @elseif($sip->disposisi == 1 && $sip->user_bidang_id == 1306)
                           <i><button class="btn btn-info btn-sm">Kabid Penunjang Medis</button></i>
                           @elseif($sip->disposisi == 1 && $sip->user_bidang_id == 842)
                           <i><button class="btn btn-info btn-sm">Kabid Penunjang Non Medis</button></i>

                           {{-- disposisi 2 --}}
                           @elseif($sip->disposisi == 2)
                           <i><button class="btn btn-primary btn-sm" >Kasubag</button></i>
                           @elseif($sip->disposisi == 4)
                           <i><button class="btn btn-success btn-sm">Direktur</button></i>
                           @elseif($sip->disposisi == 5)
                           <i><button class="btn btn-danger btn-sm">Tidak Dilanjutkan</button></i>
                           @endif
     
                         </div>
                         <div class="card-footer text-muted">
                             {{ date('d-m-Y', strtotime($sip->created_at)) }}
                         </div>
                        {{-- <div class="card-footer text-muted">
                          @if ($sip->balasan_admin != null)
                              <p>Balsan Dari Admin : {{ $sip->balasan_admin }}</p>
                          @else
                              <i>Belum Ada Balasan Dari Admin</i>
                          @endif
                        </div> --}}
                        {{-- <div class="card-footer text-muted">
                            @if ($sip->balasan_bidang != null)
                                <p>Balsan Dari Bidang : {{ $sip->balasan_bidang }}</p>
                            @else
                                <i>Belum Ada Balasan Dari Bidang Terkait</i>
                            @endif
                        </div>
                       </div> --}}
                     @endforeach
             @endisset





          </div>
        </section>
       
        <!-- Quote/testimonial aside-->
        <aside class="text-center">
            <div class="container px-5">
              <div class="row gx-5 justify-content-center">
                <div class="col-xl-8">
                 
                </div>
            </div>
            </div>
        </aside>
        <!-- App features section-->
        <section id="features">
            <div class="container px-5">
                <div class="row align-items-center">
                    <div class="col-lg-8 order-lg-1 mb-5 mb-lg-0">
                        <div class="container-fluid px-5">
                            <div class="row gx-5">
                                <div class="col-md-6 mb-5">
                                    <!-- Feature item-->
                                    <div class="text-center">
                                        <i class="bi-phone icon-feature text-gradient d-block mb-3"></i>
                                        <h3 class="font-alt">Pelayanan Baik</h3>
                                        <p class="text-muted mb-0">Kami berusaha melayani dengan sepenuh hati</p>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-5">
                                    <!-- Feature item-->
                                    <div class="text-center">
                                        <i class="bi-camera icon-feature text-gradient d-block mb-3"></i>
                                        <h3 class="font-alt">Respon Cepat</h3>
                                        <p class="text-muted mb-0">Kami berusaha merespon cepat keluhan user</p>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                              <div class="col-md-6 mb-5">
                                <!-- Feature item-->
                                <div class="text-center">
                                    <i class="bi-phone icon-feature text-gradient d-block mb-3"></i>
                                    <h3 class="font-alt">Pelayanan Baik</h3>
                                    <p class="text-muted mb-0">Kami berusaha melayani dengan sepenuh hati</p>
                                </div>
                            </div>
                            <div class="col-md-6 mb-5">
                                <!-- Feature item-->
                                <div class="text-center">
                                    <i class="bi-camera icon-feature text-gradient d-block mb-3"></i>
                                    <h3 class="font-alt">Respon Cepat</h3>
                                    <p class="text-muted mb-0">Kami berusaha merespon cepat keluhan user</p>
                                </div>
                            </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Basic features section-->
        {{-- <section class="bg-light">
            <div class="container px-5">
                <div class="row gx-5 align-items-center justify-content-center justify-content-lg-between">
                    <div class="col-12 col-lg-5">
                        <h2 class="display-4 lh-1 mb-4">Enter a new age of web design</h2>
                        <p class="lead fw-normal text-muted mb-5 mb-lg-0">This section is perfect for featuring some information about your application, why it was built, the problem it solves, or anything else! There's plenty of space for text here, so don't worry about writing too much.</p>
                    </div>
                    <div class="col-sm-8 col-md-6">
                        <div class="px-5 px-sm-0"><img class="img-fluid rounded-circle" src="https://source.unsplash.com/u8Jn2rzYIps/900x900" alt="..." /></div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Call to action section-->
        <section class="cta">
            <div class="cta-content">
                <div class="container px-5">
                    <h2 class="text-white display-1 lh-1 mb-4">
                        Stop waiting.
                        <br />
                        Start building.
                    </h2>
                    <a class="btn btn-outline-light py-3 px-4 rounded-pill" href="https://startbootstrap.com/theme/new-age" target="_blank">Download for free</a>
                </div>
            </div>
        </section> --}}
        <!-- App badge section-->
        {{-- <section class="bg-gradient-primary-to-secondary" id="download">
            <div class="container px-5">
                <h2 class="text-center text-white font-alt mb-4">Get the app now!</h2>
                <div class="d-flex flex-column flex-lg-row align-items-center justify-content-center">
                    <a class="me-lg-3 mb-4 mb-lg-0" href="#!"><img class="app-badge" src="assets/img/google-play-badge.svg" alt="..." /></a>
                    <a href="#!"><img class="app-badge" src="/images/{{ configrs()->logo }}" alt="..." /></a>
                </div>
            </div>
        </section> --}}
        <!-- Footer-->
        <footer class="bg-black text-center py-5">
            <div class="container px-5">
                <div class="text-white-50 small">
                    <div class="mb-2">&copy; SIPEKA 2023. All Rights Reserved.</div>
                    <a href="#!">Privacy</a>
                    <span class="mx-1">&middot;</span>
                    <a href="#!">Terms</a>
                    <span class="mx-1">&middot;</span>
                    <a href="#!">FAQ</a>
                </div>
            </div>
        </footer>
        <!-- Feedback Modal-->
        <div class="modal fade" id="feedbackModal" tabindex="-1" aria-labelledby="feedbackModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-gradient-primary-to-secondary p-4">
                        <h5 class="modal-title font-alt text-white" id="feedbackModalLabel">Send feedback</h5>
                        <button class="btn-close btn-close-white" type="button" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body border-0 p-4">
                        <!-- * * * * * * * * * * * * * * *-->
                        <!-- * * SB Forms Contact Form * *-->
                        <!-- * * * * * * * * * * * * * * *-->
                        <!-- This form is pre-integrated with SB Forms.-->
                        <!-- To make this form functional, sign up at-->
                        <!-- https://startbootstrap.com/solution/contact-forms-->
                        <!-- to get an API token!-->
                        <form id="contactForm" data-sb-form-api-token="API_TOKEN">
                            <!-- Name input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="name" type="text" placeholder="Enter your name..." data-sb-validations="required" />
                                <label for="name">Full name</label>
                                <div class="invalid-feedback" data-sb-feedback="name:required">A name is required.</div>
                            </div>
                            <!-- Email address input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="email" type="email" placeholder="name@example.com" data-sb-validations="required,email" />
                                <label for="email">Email address</label>
                                <div class="invalid-feedback" data-sb-feedback="email:required">An email is required.</div>
                                <div class="invalid-feedback" data-sb-feedback="email:email">Email is not valid.</div>
                            </div>
                            <!-- Phone number input-->
                            <div class="form-floating mb-3">
                                <input class="form-control" id="phone" type="tel" placeholder="(123) 456-7890" data-sb-validations="required" />
                                <label for="phone">Phone number</label>
                                <div class="invalid-feedback" data-sb-feedback="phone:required">A phone number is required.</div>
                            </div>
                            <!-- Message input-->
                            <div class="form-floating mb-3">
                                <textarea class="form-control" id="message" type="text" placeholder="Enter your message here..." style="height: 10rem" data-sb-validations="required"></textarea>
                                <label for="message">Message</label>
                                <div class="invalid-feedback" data-sb-feedback="message:required">A message is required.</div>
                            </div>
                            <!-- Submit success message-->
                            <!---->
                            <!-- This is what your users will see when the form-->
                            <!-- has successfully submitted-->
                            <div class="d-none" id="submitSuccessMessage">
                                <div class="text-center mb-3">
                                    <div class="fw-bolder">Form submission successful!</div>
                                    To activate this form, sign up at
                                    <br />
                                    <a href="https://startbootstrap.com/solution/contact-forms">https://startbootstrap.com/solution/contact-forms</a>
                                </div>
                            </div>
                            <!-- Submit error message-->
                            <!---->
                            <!-- This is what your users will see when there is-->
                            <!-- an error submitting the form-->
                            <div class="d-none" id="submitErrorMessage"><div class="text-center text-danger mb-3">Error sending message!</div></div>
                            <!-- Submit Button-->
                            <div class="d-grid"><button class="btn btn-primary rounded-pill btn-lg disabled" id="submitButton" type="submit">Submit</button></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src="{{ asset('js/jquery-ui.js') }}"></script>
            
        @include('flashy::message')

        <!-- Bootstrap core JS-->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
        <!-- Core theme JS-->
        <script src="/js/scripts.js"></script>
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <!-- * *                               SB Forms JS                               * *-->
        <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
        <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
        <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
    </body>
</html>
