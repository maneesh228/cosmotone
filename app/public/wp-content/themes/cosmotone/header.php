<?php
/**
 * Shared site header.
 *
 * @package Cosmotone
 */
defined( 'ABSPATH' ) || exit;
?>
<!doctype html>
<html class="no-js" <?php language_attributes(); ?>>

<head>
   <meta charset="<?php bloginfo( 'charset' ); ?>">
   <meta http-equiv="x-ua-compatible" content="ie=edge">
   <title><?php echo esc_html( wp_get_document_title() ); ?></title>
   <meta name="description" content="">
   <meta name="viewport" content="width=device-width, initial-scale=1">

   <base href="<?php echo esc_url( trailingslashit( get_template_directory_uri() ) ); ?>">
   <!-- Place favicon.ico in the root directory -->
   <link rel="shortcut icon" type="image/x-icon" href="assets/img/logo/favicon.png">

   <!-- CSS here -->
   <link rel="stylesheet" href="assets/css/bootstrap.css">
   <link rel="stylesheet" href="assets/css/animate.css">
   <link rel="stylesheet" href="assets/css/swiper-bundle.css">
   <link rel="stylesheet" href="assets/css/slick.css">
   <link rel="stylesheet" href="assets/css/magnific-popup.css">
   <link rel="stylesheet" href="assets/css/flaticon_biddut.css">
   <link rel="stylesheet" href="assets/css/font-awesome-pro.css">
   <link rel="stylesheet" href="assets/css/spacing.css">
   <link rel="stylesheet" href="assets/css/custom-animation.css">
   <link rel="stylesheet" href="assets/css/main.css">
   <link rel="stylesheet" href="assets/css/cosmotone.css?v=header-whatsapp">
   <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
   <?php wp_body_open(); ?>
   <!--[if lte IE 9]>
      <p class="browserupgrade">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience and security.</p>
      <![endif]-->


   <!-- pre loader area start -->
   <div id="loading">
      <div id="loading-center">
         <div id="loading-center-absolute">
            <div class="object" id="object_four"></div>
            <div class="object" id="object_three"></div>
            <div class="object" id="object_two"></div>
            <div class="object" id="object_one"></div>
         </div>
      </div>
   </div>
   <!-- pre loader area end -->

   <!-- back to top start -->
   <div class="back-to-top-wrapper">
      <button id="back_to_top" type="button" class="back-to-top-btn">
         <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M11 6L6 1L1 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
               stroke-linejoin="round" />
         </svg>
      </button>
   </div>
   <!-- back to top end -->

   <!-- search popup start -->
   <div class="search__popup">
      <div class="container">
         <div class="row">
            <div class="col-xxl-12">
               <div class="search__wrapper">
                  <div class="search__top d-flex justify-content-between align-items-center">
                     <div class="search__logo">
                        <a href="#">
                           <img src="assets/img/logo/white-logo.png" alt="">
                        </a>
                     </div>
                     <div class="search__close">
                        <button type="button" class="search__close-btn search-close-btn">
                           <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                              xmlns="http://www.w3.org/2000/svg">
                              <path d="M17 1L1 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" />
                              <path d="M1 1L17 17" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                 stroke-linejoin="round" />
                           </svg>
                        </button>
                     </div>
                  </div>
                  <div class="search__form">
                     <form action="#">
                        <div class="search__input">
                           <input class="search-input-field" type="text" placeholder="Type here to search...">
                           <span class="search-focus-border"></span>
                           <button type="submit">
                              <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                 xmlns="http://www.w3.org/2000/svg">
                                 <path
                                    d="M9.55 18.1C14.272 18.1 18.1 14.272 18.1 9.55C18.1 4.82797 14.272 1 9.55 1C4.82797 1 1 4.82797 1 9.55C1 14.272 4.82797 18.1 9.55 18.1Z"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                    stroke-linejoin="round" />
                                 <path d="M19.0002 19.0002L17.2002 17.2002" stroke="currentColor" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                              </svg>
                           </button>
                        </div>
                     </form>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
   <!-- search popup end -->

   <!-- tp-offcanvus-area-start -->
   <div class="tpoffcanvas-area">
      <div class="tpoffcanvas">
         <div class="tpoffcanvas__close-btn">
            <button class="close-btn"><i class="fal fa-times"></i></button>
         </div>
         <div class="tpoffcanvas__logo">
            <a href="#">
                     <img src="assets/img/logo/white-logo.png" alt="">
            </a>
         </div>
         <div class="tpoffcanvas__title">
            <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Minima incidunt eaque ab cumque, porro maxime
               autem sed.</p>
         </div>
         <div class="tp-main-menu-mobile d-xl-none"></div>
         <div class="tpoffcanvas__contact-info">
            <div class="tpoffcanvas__contact-title">
               <h5>Contact us</h5>
            </div>
            <ul>
               <li>
                  <i class="fa-light fa-location-dot"></i>
                  <a href="#" target="_blank">Melbone st,
                     Australia, Ny 12099</a>
               </li>
               <li>
                  <i class="fas fa-envelope"></i>
                  <a href="#">themepure@gmail.com</a>
               </li>
               <li>
                  <i class="fal fa-phone-alt"></i>
                  <a href="#">+48 555 223 224</a>
               </li>
            </ul>
         </div>
         <div class="tpoffcanvas__input">
            <div class="tpoffcanvas__input-title">
               <h4>Get UPdate</h4>
            </div>
            <form action="#">
               <div class="p-relative">
                  <input type="text" placeholder="Enter mail">
                  <button>
                     <i class="fas fa-paper-plane"></i>
                  </button>
               </div>
            </form>
         </div>
         <div class="tpoffcanvas__social">
            <div class="social-icon">
               <a href="#"><i class="fab fa-twitter"></i></a>
               <a href="#"><i class="fab fa-instagram"></i></a>
               <a href="#"><i class="fab fa-facebook-f"></i></a>
               <a href="#"><i class="fab fa-pinterest-p"></i></a>
            </div>
         </div>
      </div>
   </div>
   <div class="body-overlay"></div>
   <!-- tp-offcanvus-area-end -->

   <header class="tp-header-height">
      <!-- header top area start -->
      <div class="tp-header-top-area tp-header-top-space black-bg">
         <div class="container custom-container-1">
            <div class="row align-items-center">
               <div class="col-xl-6 col-lg-8 col-md-8 col-sm-6">
                  <div class="tp-header-top-left-box text-center text-md-start">
                     <ul>
                        <li>
                           <i class="flaticon-mail-1"></i>
                           <a href="#">info@cosmotone.com</a>
                        </li>
                        <li class="d-none d-md-inline-block">
                           <i class="flaticon-phone-call"></i>
                           <a href="#">+91 9554 48 1761</a>
                        </li>
                        <li class="d-none d-lg-inline-block">
                           <i class="fa-regular fa-clock"></i>
                           <span>Mon–Sat, 9:00 AM–6:00 PM</span>
                        </li>
                     </ul>
                  </div>
               </div>
               <div class="col-xl-6 col-lg-4 col-md-4 col-sm-6 d-none d-sm-block">
                  <div class="tp-header-top-right-box text-end">
                     <ul>
                        <li>
                           <div class="tp-header-top-right-text d-none d-xl-block">
                              <a href="<?php echo esc_url( home_url( '/contact/' ) ); ?>">Support</a>
                              <a href="<?php echo esc_url( home_url( '/downloads/' ) ); ?>">Download</a>
                              <a href="#">English</a>
                           </div>
                        </li>
                        <li>
                           <div class="tp-header-top-right-social">
                              <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                              <a href="#"><i class="fa-brands fa-instagram"></i></a>
                              <a href="#"><i class="fa-brands fa-linkedin-in"></i></a>
                              <a href="#"><i class="fa-brands fa-twitter"></i></a>
                           </div>
                        </li>
                     </ul>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- header top area end -->

      <!-- header area start -->
      <div id="header-sticky" class="tp-header-area">
         <div class="container custom-container-1">
            <div class="row align-items-center">
               <div class="col-xxl-2 col-xl-2 col-lg-4 col-md-4 col-6">
                  <div class="tp-header-logo">
                     <a href="/">
                        <img src="assets/img/logo/black-logo.png" alt="">
                     </a>
                  </div>
               </div>
               <div class="col-xxl-5 col-xl-6 d-none d-xl-block">
                  <div class="tp-header-main-menu tp-header-menu-border text-end text-xxl-start">
                     <nav class="tp-main-menu-content">
                        <ul>
                           <li class="">
                              <a class="<?php echo is_front_page() ? 'active' : ''; ?>" href="<?php echo esc_url( home_url( '/' ) ); ?>" <?php echo is_front_page() ? 'aria-current="page"' : ''; ?>>Home</a>
                           </li>
                           <li class=""> 
                              <a class="<?php echo is_page( 'about-us' ) ? 'active' : ''; ?>" href="<?php echo esc_url( home_url( '/about-us/' ) ); ?>" <?php echo is_page( 'about-us' ) ? 'aria-current="page"' : ''; ?>>About Us</a>
                           </li>
                           <li class="">
                              <a class="<?php echo ( is_page( array( 'services', 'service-details' ) ) || is_singular( 'cosmotone_service' ) ) ? 'active' : ''; ?>" href="<?php echo esc_url( home_url( '/services/' ) ); ?>" <?php echo ( is_page( array( 'services', 'service-details' ) ) || is_singular( 'cosmotone_service' ) ) ? 'aria-current="page"' : ''; ?>>Services</a>
                           </li>
                           <li class="">
                              <a class="<?php echo ( is_page( array( 'products', 'product-details' ) ) || is_singular( 'cosmotone_product' ) ) ? 'active' : ''; ?>" href="<?php echo esc_url( home_url( '/products/' ) ); ?>" <?php echo ( is_page( array( 'products', 'product-details' ) ) || is_singular( 'cosmotone_product' ) ) ? 'aria-current="page"' : ''; ?>>Products</a>
                           </li>
                           <li class="">
                              <a class="<?php echo is_page( 'career' ) ? 'active' : ''; ?>" href="<?php echo esc_url( home_url( '/career/' ) ); ?>" <?php echo is_page( 'career' ) ? 'aria-current="page"' : ''; ?>>Career</a>
                           </li>
                           <li class="">
                              <a class="<?php echo is_page( array( 'news', 'news-details' ) ) ? 'active' : ''; ?>" href="<?php echo esc_url( home_url( '/news/' ) ); ?>" <?php echo is_page( array( 'news', 'news-details' ) ) ? 'aria-current="page"' : ''; ?>>News & Articles</a>
                           </li>
                           <li>
                              <a class="<?php echo is_page( 'contact' ) ? 'active' : ''; ?>" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>" <?php echo is_page( 'contact' ) ? 'aria-current="page"' : ''; ?>>Contact</a>
                           </li>
                        </ul>
                     </nav>
                  </div>
               </div>
               <div class="col-xxl-5 col-xl-4 col-lg-8 col-md-8 col-6">
                  <div class="tp-header-right-box">
                     <div class="tp-header-right-action d-flex align-items-center justify-content-end">
                        <!-- <div class="tp-header-right-icon-action d-none d-lg-block">
                           <div class="tp-header-right-icon d-flex align-items-center">
                              <button class="search-open-btn"><i class="flaticon-loupe"></i></button>
                              <div class="tp-header-right-shop p-relative">
                                 <a href="#">
                                    <i class="fa-light fa-bag-shopping"></i>
                                    <span>2</span>
                                 </a>
                              </div>
                           </div>
                        </div> -->
                        <div class="tp-header-right-btn d-none d-md-flex align-items-center">
                           <a class="tp-btn" href="<?php echo esc_url( home_url( '/contact/' ) ); ?>"><span>MAKE APPOINTMENT</span></a>
                           <a class="cosmotone-header-whatsapp" href="https://wa.me/919554481761" target="_blank" rel="noopener noreferrer" aria-label="Chat with Cosmotone on WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
                        </div>
                        <div class="tp-header-right-tel-box d-none d-xxl-block">
                           <div class="tp-header-right-tel-icon d-flex align-items-center">
                              <i class="flaticon-phone-call"></i>
                              <div class="tp-header-right-tel-content">
                                 <span>Talk to an expert </span>
                                 <a href="#"><span>Free</span> +99 (786) 8765</a>
                              </div>
                           </div>
                        </div>
                        <div class="tp-header-bar d-xl-none">
                           <button class="tp-menu-bar"><i class="fa-sharp fa-regular fa-bars-staggered"></i></button>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <!-- header area end -->
   </header>


