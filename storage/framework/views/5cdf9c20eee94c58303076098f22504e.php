<!-- Author : Lim Jia Qing -->
<!DOCTYPE html>
<html>

<head>
    <!-- Basic -->
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <link rel="shortcut icon" href="<?php echo e(asset('images/favicon.png')); ?>" type="">

    <title> Feane </title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('css/bootstrap.css')); ?>" />

    <!--owl slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <!-- nice select  -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css"
        integrity="sha512-CruCP+TD3yXzlvvijET8wV5WxxEh5H8P4cmz0RFbKK6FlZ2sYl3AEsKlLPHbniXKSrDdFewhbmBK5skbdsASbQ=="
        crossorigin="anonymous" />
    <!-- font awesome style -->
    <link href="<?php echo e(asset('css/font-awesome.min.css')); ?>" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="<?php echo e(asset('css/style.css')); ?>" rel="stylesheet" />
    <!-- responsive style -->
    <link href="<?php echo e(asset('css/responsive.css')); ?>" rel="stylesheet" />

</head>

<body class="sub_page">
    <?php echo $__env->make('admin.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
    <!-- menu section -->
    <section class="food_section layout_padding">
        <div class="container mt-4">
            <div class="heading_container heading_center mb-4">
                <h2>Our Menu</h2>
        <div class="container mt-4">
            <div class="heading_container heading_center mb-4">
                <h2>Our Menu</h2>
            </div>
            <div class="row">
                <!-- Left Column (70%) -->
                <div class="col-md-8">
                    <div class="row">
                        <?php $__currentLoopData = $menus; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $menu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <form action="<?php echo e(route('order.store')); ?>" method="POST">
                            <?php echo csrf_field(); ?>
                            <div class="col-md-6 mb-4">
                                <div class="card menu-box h-100">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo e($menu->name); ?></h5>
                                        <p class="card-text"><?php echo e($menu->desc); ?></p>
                                        <div class="options d-flex justify-content-between align-items-center">
                                            <h6>RM <?php echo e(number_format($menu->price, 2)); ?></h6>
                                            <input type="hidden" name="menu_name" value="<?php echo e($menu->name); ?>">
                                            <input type="hidden" name="menu_price" value="<?php echo e($menu->price); ?>">
                                            <button type="submit" class="btn btn-primary btn-sm" id="addToCartBtn" onclick="showDetails('<?php echo e($menu->id); ?>', '<?php echo e($menu->name); ?>')">+</button>
                                        </div> 
                                    </div>
                                </div>
                            </div>
                            </form>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </div>

                <!-- Right Column (Remark and Add to Cart) -->
                <div class="col-md-4">
                    <div class="remark-panel" id="remarkPanel">
                        <span class="close-panel" onclick="hideDetails()">x</span>
                        <h5 id="remarkTitle">Remark & Add to Cart</h5>
                        <table>
                            <thead>
                                <tr>
                                    <th>Select</th>
                                    <th>Remark</th>
                                    <th>Additional Price (RM)</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $remarks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $remark): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><input type="checkbox" name="remark[]" value="<?php echo e($remark['name']); ?>"></td>
                                        <td><?php echo e($remark['name']); ?></td>
                                        <td><?php echo e(number_format($remark['price'], 2)); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                        <button class="btn btn-success btn-block" onclick="addToCart()">Add to Cart</button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- end menu section -->

    <!-- footer section -->
    <footer class="footer_section">
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer-col">
                    <div class="footer_contact">
                        <h4>
                            Contact Us
                        </h4>
                        <div class="contact_link_box">
                            <a href="">
                                <i class="fa fa-map-marker" aria-hidden="true"></i>
                                <span>
                                    Location
                                </span>
                            </a>
                            <a href="">
                                <i class="fa fa-phone" aria-hidden="true"></i>
                                <span>
                                    Call +01 1234567890
                                </span>
                            </a>
                            <a href="">
                                <i class="fa fa-envelope" aria-hidden="true"></i>
                                <span>
                                    demo@gmail.com
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 footer-col">
                    <div class="footer_detail">
                        <a href="" class="footer-logo">
                            Feane
                        </a>
                        <p>
                            Necessary, making this the first true generator on the Internet. It uses a dictionary of
                            over 200 Latin words, combined with
                        </p>
                        <div class="footer_social">
                            <a href="">
                                <i class="fa fa-facebook" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-twitter" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-linkedin" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-instagram" aria-hidden="true"></i>
                            </a>
                            <a href="">
                                <i class="fa fa-pinterest" aria-hidden="true"></i>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 footer-col">
                    <h4>
                        Opening Hours
                    </h4>
                    <p>
                        Everyday
                    </p>
                    <p>
                        10.00 Am -10.00 Pm
                    </p>
                </div>
            </div>
            <div class="footer-info">
                <p>
                    &copy; <span id="displayYear"></span> All Rights Reserved By
                    <a href="https://html.design/">Free Html Templates</a><br><br>
                    &copy; <span id="displayYear"></span> Distributed By
                    <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
                </p>
            </div>
        </div>
    </footer>
    <!-- footer section -->

    <!-- This page script -->
    <script>
        setTimeout(function() {
            var
                messageElement = document.getElementById('success-message');
            if (messageElement) {
                messageElement.style.display = 'none';
            }
        }, 3000); // 3000 milliseconds = 3 seconds
    </script>

    <!-- jQery -->
    <script src="<?php echo e(asset('js/jquery-3.4.1.min.js')); ?>"></script>
    <!-- popper js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <!-- bootstrap js -->
    <script src="<?php echo e(asset('js/bootstrap.js')); ?>"></script>
    <!-- owl slider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- isotope js -->
    <script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
    <!-- nice select -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
    <!-- custom js -->
    <script src="<?php echo e(asset('js/custom.js')); ?>"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
    </script>
    <!-- End Google Map -->

    <script>
        
    </script>

</body>

</html>
<?php /**PATH C:\xampp\htdocs\RestaurantOrderingSystem-main\resources\views/menus/index.blade.php ENDPATH**/ ?>