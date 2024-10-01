<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Samarasa</title>
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- Favicons -->
    <link href="{{ asset('frontend/assets/img/favicon.png')}}" rel="icon">
    <link href="{{ asset('frontend/assets/img/apple-touch-icon.png')}}" rel="apple-touch-icon">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect">
    <link href="https://fonts.gstatic.com" rel="preconnect" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@100;300;400;500;700;900&family=Poppins:wght@100;200;300;400;500;600;700;800;900&family=Raleway:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="{{ asset('frontend/assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/bootstrap-icons/bootstrap-icons.css')}}" rel="stylesheet">
    <link href="{{ asset('frontend/assets/vendor/aos/aos.css')}}" rel="stylesheet">

    <!-- Main CSS File -->
    <link href="{{ asset('frontend/assets/css/main.css')}}" rel="stylesheet">

    @livewireStyles  <!-- Memuat stylesheet Livewire -->
</head>

<body class="index-page">

    <header id="header" class="header d-flex align-items-center px-3 fixed-top">
        <div class="container-fluid position-relative d-flex align-items-center justify-content-between">
            <a href="{{url('/')}}" class="logo d-flex align-items-center">
                <h1 class="sitename">Samarasa</h1>
            </a>

            <nav id="navmenu" class="navmenu">
                <ul>
                    <li><a href="#hero" class="active">Home</a></li>
                    <li><a href="#about">Tentang</a></li>
                    <li><a href="#contact">Kontak</a></li>
                    <li><a href="{{url('/back')}}">Masuk</a></li>
                </ul>
                <i class="mobile-nav-toggle d-xl-none bi bi-list"></i>
            </nav>
        </div>
    </header>

    <main class="main">
        <!-- Hero Section -->
        <section id="hero" class="hero section transparent-background">
            <div class="container text-center" data-aos="fade-up" data-aos-delay="100">
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <h2>Samarasa<br></h2>
                        <p>Sistem Informasi Manajemen Sarana dan Prasarana Bidang PAUD</p>
                    </div>


                    <div class="col-lg-5 hero-newsletter">
                        <p>Cari Data Sekolah Penerima Bantuan</p>
                        <form action="{{ route('sekolah.cari') }}" method="POST">
                          <div class="newsletter-form">
                            @csrf
                            <input placeholder="NPSN" type="text" name="query" value="{{ old('query', $query) }}">
                            <input
                                type="text" name="token" value="{{ old('token', $token) }}" class="form-control @error('token') is-invalid @enderror" placeholder="Token"
                                >
                            <input type="submit" value="Cari "></div>
                            {{-- <img src="{{ captcha_src() }}" alt="captcha"> --}}
                            <div class="mt-2"></div>

                            @error('captcha')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                          {{-- <div class="loading">Loading</div>
                          <div class="error-message"></div>
                          <div class="sent-message">Your subscription request has been sent. Thank you!</div> --}}
                        </form>
                          @if(is_null($sekolah))
                              {{-- <h3>Hasil Pencarian</h3>--}}
                              <p>Tidak ada sekolah yang ditemukan.</p>
                          @else
                              <h3>Hasil Pencarian</h3>
                              <table class="custom-table">
                                <tr align="left">
                                    <td>NPSN</td>
                                    <td>: {{ $sekolah->npsn ?? 'N/A' }}</td>
                                </tr>
                                <tr align="left">
                                    <td>Nama Sekolah</td>
                                    <td>: {{ $sekolah->nama_sekolah ?? 'N/A' }}</td>
                                </tr>
                                <tr align="left">
                                    <td>Desa</td>
                                    <td>: {{ $sekolah->desa ?? 'N/A' }}</td>
                                </tr>
                                <tr align="left">
                                    <td>Kecamatan</td>
                                    <td>: {{ $sekolah->kecamatan ?? 'N/A' }}</td>
                                </tr>
                              </table>
                          @endif
                          {{-- <h3>Riwayat Bantuan</h3> --}}
                          @if(is_null($bantuan))
                              {{-- <p>Tidak ada bantuan yang ditemukan.</p> --}}
                          @else
                          <h3>Riwayat Bantuan</h3>
                          <center>
                          <table  class="custom-table">
                            <tr>
                                <td align="center">Tahun</td>
                                <td align="center">Jenis Bantuan</td>
                                <td align="center">Sumber Dana</td>
                            </tr>
                          @foreach($bantuan as $item)
                            <tr>
                                <td>
                                    {{ $item->tahun ?? 'N/A' }}
                                </td>
                                <td>
                                    {{ $item->databantuan->nama_bantuan ?? 'N/A' }}
                                </td>
                                <td>
                                    @php
                                      $sumberDanaString = is_array($item->sumberdana) ? implode(', ', $item->sumberdana) : $item->sumberdana;
                                    @endphp
                                    {{ $sumberDanaString }}
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        </center>
                          @endif
                      </div>
                        <div class="social-links">
                            <a href="#"><i class="bi bi-twitter-x"></i></a>
                            <a href="#"><i class="bi bi-facebook"></i></a>
                            <a href="#"><i class="bi bi-instagram"></i></a>
                            <a href="#"><i class="bi bi-youtube"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /Hero Section -->

        <!-- About Section -->
        <section id="about" class="about section transparent-background">
            <div class="container section-title" data-aos="fade-up">
                <h2>Tentang</h2>
                <p></p>
            </div><!-- End Section Title -->

            <div class="container">
                <div class="row gy-5">
                    <div class="content col-xl-5 d-flex flex-column" data-aos="fade-up" data-aos-delay="100">
                        <h3>Sistem Informasi Manajemen Sarana dan Prasarana Bidang PAUD</h3>
                        <p>Selamat datang di Samarasa, Sistem Informasi Manajemen Sarana dan Prasarana Bidang Pendidikan Anak Usia Dini (PAUD). Samarasa dirancang untuk mempermudah pengelolaan dan penyimpanan data terkait sarana dan prasarana pendidikan, khususnya di sektor PAUD. Dengan fitur yang lengkap, sistem ini memungkinkan pengguna untuk menyimpan berbagai data penting</p>
                    </div>

                    <div class="col-xl-7" data-aos="fade-up" data-aos-delay="200">
                        <div class="row gy-4">
                            <div class="col-md-6 icon-box position-relative">
                                <i class="bi bi-briefcase"></i>
                                <h4><a href="" class="stretched-link">Data Sekolah</a></h4>
                                <p>Informasi lengkap mengenai lembaga PAUD, termasuk identitas dan lokasi.</p>
                            </div><!-- Icon-Box -->
                            <div class="col-md-6 icon-box position-relative">
                                <i class="bi bi-gem"></i>
                                <h4><a href="" class="stretched-link">Data Bantuan</a></h4>
                                <p>Rekam jejak bantuan yang diterima oleh lembaga, baik dari pemerintah maupun pihak lainnya.</p>
                            </div><!-- Icon-Box -->
                            <div class="col-md-6 icon-box position-relative">
                                <i class="bi bi-broadcast"></i>
                                <h4><a href="" class="stretched-link">Data Usulan</a></h4>
                                <p>Pengajuan bantuan atau pengembangan sarana prasarana yang diajukan oleh sekolah.</p>
                            </div><!-- Icon-Box -->
                            <div class="col-md-6 icon-box position-relative">
                                <i class="bi bi-easel"></i>
                                <h4><a href="" class="stretched-link">Data Sarana Prasarana</a></h4>
                                <p>Inventarisasi dan pemantauan kondisi sarana dan prasarana yang tersedia di masing-masing lembaga.</p>
                            </div><!-- Icon-Box -->
                        </div>
                    </div>
                </div>
            </div>
        </section><!-- /About Section -->

        <!-- Contact Section -->
        <section id="contact" class="contact section transparent-background">
            <div class="container section-title" data-aos="fade-up">
                <h2>Kontak</h2>
                <p>Dinas Pendidikan</p>
            </div><!-- End Section Title -->

            <div class="container" data-aos="fade" data-aos-delay="100">
                <div class="row gy-4">
                    <div class="col-lg-4">
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="200">
                            <i class="bi bi-geo-alt flex-shrink-0"></i>
                            <div>
                                <h3>Alamat</h3>
                                <p>Jl. Raya Soreang</p>
                            </div>
                        </div><!-- End Info Item -->
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-telephone flex-shrink-0"></i>
                            <div>
                                <h3>Telepon</h3>
                                <p>-</p>
                            </div>
                        </div><!-- End Info Item -->
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="300">
                            <i class="bi bi-whatsapp flex-shrink-0"></i>
                            <div>
                                <h3>Whatsapp</h3>
                                <p>-</p>
                            </div>
                        </div><!-- End Info Item -->
                        <div class="info-item d-flex" data-aos="fade-up" data-aos-delay="400">
                            <i class="bi bi-envelope flex-shrink-0"></i>
                            <div>
                                <h3>Email</h3>
                                <p>-</p>
                            </div>
                        </div><!-- End Info Item -->
                    </div>

                    <div class="col-lg-8">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3351.4793045661654!2d107.52488337415643!3d-7.020839892980816!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68ec329f509361%3A0x220e274e55f0494f!2sDinas%20Pendidikan%20Kabupaten%20Bandung!5e1!3m2!1sid!2sid!4v1727327527090!5m2!1sid!2sid" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                    </div><!-- End Contact Form -->
                </div>
            </div>
        </section><!-- /Contact Section -->
    </main>

    <footer id="footer" class="footer transparent-background">
        <div class="container">
            <div class="row gy-3">
                <div class="col-lg-3 col-md-6 d-flex">
                    <i class="bi bi-geo-alt icon"></i>
                    <div class="address">
                        <h4>Alamat</h4>
                        <p>Jl. Raya Soreang</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-flex">
                    <i class="bi bi-telephone icon"></i>
                    <div>
                        <h4>Kontak</h4>
                        <p><strong>Telepon:</strong> <span>-</span><br><strong>Whatsapp:</strong> <span>-</span><br><strong>Email:</strong> <span>-</span><br></p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 d-flex">
                    <i class="bi bi-clock icon"></i>
                    <div>
                        <h4>Jam Layanan</h4>
                        <p><strong>Senin-Jumat:</strong> <span>08.00 - 16.00 WIB</span><br><strong>Sabtu-Minggu</strong>: <span>Libur</span></p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h4>Media Sosial</h4>
                    <div class="social-links d-flex">
                        <a href="#" class="twitter"><i class="bi bi-twitter-x"></i></a>
                        <a href="#" class="facebook"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="instagram"><i class="bi bi-instagram"></i></a>
                        <a href="#" class="youtube"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="container copyright text-center mt-4">
            <p>© <span>Copyright</span> <strong class="px-1 sitename">DISKOMINFO X DISDIK KABUPATEN BANDUNG</p>
            <div class="credits">
                Designed by <a href="https://bootstrapmade.com/">BootstrapMade</a>
            </div>
        </div>
    </footer>

    <!-- Scroll Top -->
    <a href="#" id="scroll-top" class="scroll-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

    <!-- Preloader -->
    <div id="preloader"></div>

    <!-- Vendor JS Files -->
    <script src="{{ asset('frontend/assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
    <script src="{{ asset('frontend/assets/vendor/php-email-form/validate.js')}}"></script>
    <script src="{{ asset('frontend/assets/vendor/aos/aos.js')}}"></script>

    <!-- Main JS File -->
    <script src="{{ asset('frontend/assets/js/main.js')}}"></script>
    @livewireScripts  <!-- Memuat skrip Livewire -->
</body>

</html>
