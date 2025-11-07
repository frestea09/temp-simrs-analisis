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
        <!-- Mashead header-->
        {{-- <header class="masthead">
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
                        <img style="max-width: 100%; height: 100%" src="/images/{{ configrs()->logo }}">
                      
                      </div>
                      </div>
                    </div>
                </div>
            </div>
        </header> --}}
        <section id="features">
          <div class="container px-5">
            <form action="/sipeka/store-user">
              
              <div class="form-group">
                <label for="nama">Nama Pelapor</label><br>
                <label style="font-size: 12px;">(Opsional) *Kosongkan bila Anda ingin melapor secara anonim.</label>
                <input type="text" id="nama" name="nama" class="form-control"  placeholder="Masukan Nama">
              </div>
              <br>
              <div class="form-group">
                <label for="nomor_kontak">Nomor kontak yang dapat dihubungi</label><br>
                <label style="font-size: 12px;">(Opsional) *Anda mungkin akan kami hubungi jika diperlukan konfirmasi lebih lanjut.</label>
                <input type="text" id="nomor_kontak" name="nomor_kontak" class="form-control"  placeholder="Masukan Nomor Kontak">
              </div>
              <br>
              <div class="form-group">
                <label for="tanggal_kejadian">Tanggal kejadian</label>
                <input required type="date" id="tanggal_kejadian" name="tanggal_kejadian" class="form-control">
              </div>
              <hr>
              <div class="form-group">
                <label for="lokasi_kejadian">Lokasi Kejadian</label>
                <select id="lokasi_kejadian" name="lokasi_kejadian" class="form-control">
                    <option value="">-- Pilih Lokasi --</option>
                    @foreach(lokasi_kejadian() as $lokasi)
                        <option value="{{ $lokasi }}">{{ $lokasi }}</option>
                    @endforeach
                </select>
              </div>
              <br>
              <div class="form-group">
                <label for="bagian_permasalahan">Bagian Permasalahan</label><br>
                <label style="font-size: 12px;">*Bila jenis pemasalahan lebih dari satu, Anda bisa mengisi formulir baru dengan menyertakan identitas pelapor yang sama.</label><br>
                <input type="radio" name="bagian_permasalahan" value="Petugas/Karyawan" checked> Petugas/Karyawan <br>
                <input type="radio" name="bagian_permasalahan" value="Fasilitas"> Fasilitas <br>
                <input type="radio" name="bagian_permasalahan" value="Administrasi dan Informasi"> Administrasi dan Informasi <br>
              </div>
              <br>

              {{-- Bagian Petugas/Karyawan --}}
              <div id="bagian-petugas">
                <div class="form-group">
                    <label>Jenis Permasalahan</label><br>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="jenis_permasalahan_petugas[]" id="permasalahan_petugas_1" value="Tidak melayani dengan Sikap 5S (Senyum, Sapa, Salam, Sopan, Santun)">
                        <label class="form-check-label" for="permasalahan_petugas_1">
                            Tidak melayani dengan Sikap 5S (Senyum, Sapa, Salam, Sopan, Santun)
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="jenis_permasalahan_petugas[]" id="permasalahan_petugas_2" value="Kurangnya pelayanan yang diberikan petugas">
                        <label class="form-check-label" for="permasalahan_petugas_2">
                            Kurangnya pelayanan yang diberikan petugas
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="jenis_permasalahan_petugas[]" id="permasalahan_petugas_3" value="Kurangnya komunikasi dari petugas">
                        <label class="form-check-label" for="permasalahan_petugas_3">
                            Kurangnya komunikasi dari petugas
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="jenis_permasalahan_petugas[]" id="permasalahan_petugas_4" value="Terjadi kelalaian yang dilakukan oleh petugas">
                        <label class="form-check-label" for="permasalahan_petugas_4">
                            Terjadi kelalaian yang dilakukan oleh petugas
                        </label>
                    </div>
                    <div class="form-check d-flex align-items-center">
                        <input class="form-check-input checkbox-lainnya" type="checkbox" name="jenis_permasalahan_petugas[]" value="">
                        <label class="form-check-label mr-2" style="margin-left: 10px;">Lainnya</label>
                        <input type="text" class="form-control input-lainnya" style="max-width: 500px; margin-left: 10px;" disabled placeholder="Tulis permasalahan lainnya...">
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <label for="bidang_petugas_karyawan">Bidang Petugas/Karyawan</label><br>
                    <input type="radio" name="bidang_petugas_karyawan" value="Dokter"> Dokter <br>
                    <input type="radio" name="bidang_petugas_karyawan" value="Perawat"> Perawat <br>
                    <input type="radio" name="bidang_petugas_karyawan" value="Bidan"> Bidan <br>
                    <input type="radio" name="bidang_petugas_karyawan" value="Petugas Analist (Laboratorium/Radiologi)"> Petugas Analist (Laboratorium/Radiologi) <br>
                    <input type="radio" name="bidang_petugas_karyawan" value="Petugas Administrasi"> Petugas Administrasi <br>
                    <input type="radio" name="bidang_petugas_karyawan" value="Satpam"> Satpam <br>
                    <input type="radio" name="bidang_petugas_karyawan" value="Cleaning Service"> Cleaning Service <br>
                    <input type="radio" name="bidang_petugas_karyawan" value="Gizi"> Gizi <br>
                    <div class="d-flex align-items-center">
                        <input type="radio" name="bidang_petugas_karyawan" value="" class="radio-lainnya">
                        <label class="mr-2" style="margin-left: 5px;">Lainnya</label>
                        <input type="text" class="form-control input-lainnya" style="max-width: 500px; margin-left: 10px;" disabled placeholder="Tulis bidang lainnya...">
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <label for="nama_petugas_karyawan">Nama Petugas/Karyawan yang bersangkutan</label>
                    <input type="text" id="nama_petugas_karyawan" name="nama_petugas_karyawan" class="form-control"  placeholder="Masukan Nama">
                </div>
                <hr>
                <br>
              </div>
              {{-- END Bagian Petugas/Karyawan --}}

              {{-- Bagian Fasilitas --}}
              <div id="bagian-fasilitas">
                <div class="form-group">
                    <label>Fasilitas yang Bermasalah</label><br>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="masalah_fasilitas[]" id="toilet" value="Toilet">
                        <label class="form-check-label" for="toilet">
                            Toilet
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="masalah_fasilitas[]" id="ruang_tunggu" value="Ruang Tunggu">
                        <label class="form-check-label" for="ruang_tunggu">
                            Ruang Tunggu
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="masalah_fasilitas[]" id="kamar_mayat" value="Kamar Rawat">
                        <label class="form-check-label" for="kamar_mayat">
                            Kamar Rawat
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="masalah_fasilitas[]" id="mushola" value="Mushola">
                        <label class="form-check-label" for="mushola">
                            Mushola
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="masalah_fasilitas[]" id="pintu_masuk" value="Pintu Masuk">
                        <label class="form-check-label" for="pintu_masuk">
                            Pintu Masuk
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="masalah_fasilitas[]" id="brankar" value="Brankar dan/atau Kursi Roda">
                        <label class="form-check-label" for="brankar">
                            Brankar dan/atau Kursi Roda
                        </label>
                    </div>
                    <div class="form-check d-flex align-items-center">
                        <input class="form-check-input checkbox-lainnya" type="checkbox" name="masalah_fasilitas[]" value="">
                        <label class="form-check-label mr-2" style="margin-left: 10px;">Lainnya</label>
                        <input type="text" class="form-control input-lainnya" style="max-width: 500px; margin-left: 10px;" disabled placeholder="Tulis permasalahan lainnya...">
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <label>Jenis Permasalahan</label><br>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="jenis_masalah_fasilitas[]" id="kotor" value="Tidak Bersih/Kotor">
                        <label class="form-check-label" for="kotor">
                            Tidak Bersih/Kotor
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="jenis_masalah_fasilitas[]" id="tidak_lengkap" value="Tidak Lengkap/Kurang Memadai">
                        <label class="form-check-label" for="tidak_lengkap">
                            Tidak Lengkap/Kurang Memadai
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="jenis_masalah_fasilitas[]" id="rusak" value="Rusak">
                        <label class="form-check-label" for="rusak">
                            Rusak
                        </label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="jenis_masalah_fasilitas[]" id="kurang_nyaman" value="Kurang Nyaman">
                        <label class="form-check-label" for="kurang_nyaman">
                            Kurang Nyaman
                        </label>
                    </div>
                    <div class="form-check d-flex align-items-center">
                        <input class="form-check-input checkbox-lainnya" type="checkbox" name="jenis_masalah_fasilitas[]" value="">
                        <label class="form-check-label mr-2" style="margin-left: 10px;">Lainnya</label>
                        <input type="text" class="form-control input-lainnya" style="max-width: 500px; margin-left: 10px;" disabled placeholder="Tulis permasalahan lainnya...">
                    </div>
                </div>
                <br>
                <hr>
              </div>
              {{-- END Bagian Fasilitas --}}
              
              {{-- Bagian Administrasi dan Infomasi --}}
              <div id="bagian-administrasi">
                <div class="form-group">
                    <label>Jenis Permasalahan</label><br>
                    <div>
                        <input type="radio" name="jenis_permasalahan_administrasi" value="Lamanya waktu tunggu" id="permasalahan_administrasi_1">
                        <label for="permasalahan_administrasi_1">Lamanya waktu tunggu</label>
                    </div>
                    <div>
                        <input type="radio" name="jenis_permasalahan_administrasi" value="Proses pelayanan yang bertele-tele" id="permasalahan_administrasi_2">
                        <label for="permasalahan_administrasi_2">Proses pelayanan yang bertele-tele</label>
                    </div>
                    <div>
                        <input type="radio" name="jenis_permasalahan_administrasi" value="Kurangnya akses informasi yang tersebar (seperti tentang jadwal dokter atau waktu pelayanan)" id="permasalahan_administrasi_3">
                        <label for="permasalahan_administrasi_3">Kurangnya akses informasi yang tersebar (seperti tentang jadwal dokter atau waktu pelayanan)</label>
                    </div>
                    <div>
                        <input type="radio" name="jenis_permasalahan_administrasi" value="Sulit dalam meminta informasi publik" id="permasalahan_administrasi_4">
                        <label for="permasalahan_administrasi_4">Sulit dalam meminta informasi publik</label>
                    </div>
                    <div class="d-flex align-items-center">
                        <input type="radio" name="jenis_permasalahan_administrasi" value="" class="radio-lainnya">
                        <label class="mr-2" style="margin-left: 5px;">Lainnya</label>
                        <input type="text" class="form-control input-lainnya" style="max-width: 500px; margin-left: 10px;" disabled placeholder="Tulis permasalahan lainnya...">
                    </div>
                </div>
                <br>
                <hr>
              </div>
              {{-- END Bagian Administrasi dan Infomasi --}}
            <div class="form-group">
                <label for="">Deskripsi Permasalahan</label><br>
                <label style="font-size: 12px;">Berikan penjelasan selengkap mungkin agar kami dapat menangani permasalahan yang Anda laporkan dengan tepat.</label>
            </div>
            <br>
            <div class="form-group">
                <label for="komplain">Jelaskan permasalahan/komplain Anda</label><br>
                <textarea name="komplain" id="komplain" cols="30" rows="6" class="form-control"></textarea>
            </div>
            <br>
            <hr>

              <br>
              <button type="submit"  onclick="confirm('Apakah Data Yang Anda Input Sudah Benar Dan Bisa Di Pertanggungjawab Kan?')" class="btn btn-primary">Submit</button>
            </form>
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
                <div class="row gx-5 align-items-center">
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
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            document.querySelectorAll('.radio-lainnya, .checkbox-lainnya').forEach(function (inputLainnyaControl) {
                const container = inputLainnyaControl.closest('.d-flex');
                const inputLainnya = container.querySelector('.input-lainnya');

                inputLainnyaControl.addEventListener("change", function () {
                    if (this.type === "checkbox") {
                        inputLainnya.disabled = !this.checked;
                        if (!this.checked) inputLainnya.value = "";
                    } else {
                        inputLainnya.disabled = !this.checked;
                        if (!this.checked) inputLainnya.value = "";
                        else inputLainnya.focus();
                    }
                });

                inputLainnya.addEventListener("input", function () {
                    inputLainnyaControl.checked = true;
                    inputLainnyaControl.value = this.value;
                    inputLainnya.disabled = false;
                });
            });

            document.querySelectorAll('.radio-lainnya').forEach(function (radioLainnya) {
                const container = radioLainnya.closest('.d-flex');
                const inputLainnya = container.querySelector('.input-lainnya');
                const groupName = radioLainnya.name;
                const allRadios = document.querySelectorAll(`input[name="${groupName}"]`);

                allRadios.forEach(function (radio) {
                    radio.addEventListener("change", function () {
                        if (radio !== radioLainnya && radio.checked) {
                            inputLainnya.disabled = true;
                            inputLainnya.value = "";
                        }
                    });
                });
            });
        });
        </script>
        <script>
        document.addEventListener("DOMContentLoaded", function () {
            const radios = document.querySelectorAll('input[name="bagian_permasalahan"]');
            const bagianPetugas = document.getElementById("bagian-petugas");
            const bagianFasilitas = document.getElementById("bagian-fasilitas");
            const bagianAdministrasi = document.getElementById("bagian-administrasi");

            function toggleBagian(selected) {
                bagianPetugas.style.display = selected === "Petugas/Karyawan" ? "block" : "none";
                bagianFasilitas.style.display = selected === "Fasilitas" ? "block" : "none";
                bagianAdministrasi.style.display = selected === "Administrasi dan Informasi" ? "block" : "none";
            }

            const selectedRadio = document.querySelector('input[name="bagian_permasalahan"]:checked');
            toggleBagian(selectedRadio ? selectedRadio.value : "Petugas/Karyawan");

            radios.forEach(radio => {
                radio.addEventListener("change", function () {
                    toggleBagian(this.value);
                });
            });
        });
        </script>
    </body>
</html>
