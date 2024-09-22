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
    <link rel="shortcut icon" href="{{ asset('images/favicon.png') }}" type="">

    <title> Feane </title>

    <!-- bootstrap core css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/bootstrap.css') }}" />

    <!--owl slider stylesheet -->
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />
    <!-- font awesome style -->
    <link href="{{ asset('css/font-awesome.min.css') }}" rel="stylesheet" />

    <!-- Custom styles for this template -->
    <link href="{{ asset('css/style.css') }}" rel="stylesheet" />
    <!-- responsive style -->
    <link href="{{ asset('css/responsive.css') }}" rel="stylesheet" />

</head>

<body class="sub_page">

    <div class="hero_area">
        <div class="bg-box">
            <img src="{{ asset('images/hero-bg.jpg') }}" alt="">
        </div>
        <!-- header section strats -->
        <header class="header_section">
            <div class="container">
                <nav class="navbar navbar-expand-lg custom_nav-container ">
                    <a class="navbar-brand" href="{{ route('welcome') }}">
                        <span>
                            Admin
                        </span>
                    </a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class=""> </span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav  mx-auto ">
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.adminDashboard') }}">Dashboard </a>
                            </li>
                            <li class="nav-item active">
                                <a class="nav-link" href="{{ route('menus.adminMenu') }}">Menu <span
                                class="sr-only">(current)</span></a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('about') }}">About</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('book') }}">Book Table</a>
                            </li>
                        </ul>
                        <!-- User Dropdown -->
                        <div class="user_option">
                            @if (Auth::check())
                                <!-- Dropdown for logged-in user -->
                                <div class="dropdown">
                                    <!-- Dropdown trigger (username) -->
                                    <a href="#" class="user_link dropdown-toggle" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        {{ Auth::user()->name }}
                                    </a>

                                    <!-- Dropdown menu -->
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">

                                        <!-- Profile link -->
                                        <a class="dropdown-item" href="{{ route('profile.edit') }}">
                                            {{ __('Profile') }}
                                        </a>

                                        <!-- Logout link with form submission -->
                                        <form method="POST" action="{{ route('logout') }}" class="mb-0">
                                            @csrf
                                            <a class="dropdown-item" href="{{ route('logout') }}"
                                                onclick="event.preventDefault(); this.closest('form').submit();">
                                                {{ __('Log Out') }}
                                            </a>
                                        </form>
                                    </div>
                                </div>
                            @else
                                <!-- User is not logged in, display the login link -->
                                <a href="{{ route('login') }}" class="user_link">
                                    <i class="fa fa-user" aria-hidden="true"></i> {{ __('Login') }}
                                </a>
                            @endif
                            @if(session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif
                            <a class="cart_link" href="#">
                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg"
                                    xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                    viewBox="0 0 456.029 456.029" style="enable-background:new 0 0 456.029 456.029;"
                                    xml:space="preserve">
                                    <g>
                                        <g>
                                            <path d="M345.6,338.862c-29.184,0-53.248,23.552-53.248,53.248c0,29.184,23.552,53.248,53.248,53.248
                   c29.184,0,53.248-23.552,53.248-53.248C398.336,362.926,374.784,338.862,345.6,338.862z" />
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path d="M439.296,84.91c-1.024,0-2.56-0.512-4.096-0.512H112.64l-5.12-34.304C104.448,27.566,84.992,10.67,61.952,10.67H20.48
                   C9.216,10.67,0,19.886,0,31.15c0,11.264,9.216,20.48,20.48,20.48h41.472c2.56,0,4.608,2.048,5.12,4.608l31.744,216.064
                   c4.096,27.136,27.648,47.616,55.296,47.616h212.992c26.624,0,49.664-18.944,55.296-45.056l33.28-166.4
                   C457.728,97.71,450.56,86.958,439.296,84.91z" />
                                        </g>
                                    </g>
                                    <g>
                                        <g>
                                            <path d="M215.04,389.55c-1.024-28.16-24.576-50.688-52.736-50.688c-29.696,1.536-52.224,26.112-51.2,55.296
                   c1.024,28.16,24.064,50.688,52.224,50.688h1.024C193.536,443.31,216.576,418.734,215.04,389.55z" />
                                        </g>
                                    </g>

                                </svg>
                            </a>
                            <form class="form-inline">
                                <button class="btn  my-2 my-sm-0 nav_search-btn" type="submit">
                                    <i class="fa fa-search" aria-hidden="true"></i>
                                </button>
                            </form>
                            <a href="" class="order_online">
                                Order Online
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </header>
        <!-- end header section -->
    </div>

    <!-- Table of all menus in menu database -->
    <section class="layout_padding">
        <div class="heading_container heading_center">
            <h2>Admin Menu Management</h2>
            <hr />
        </div>
        <div class="container">
            <div class="row">
                <!-- Left Column: Add/Edit Menu Form -->
                <div class="col-md-4">
                    <div class="form_container">
                        <!-- Add New Menu Form -->
                        <div id="addMenuForm">
                            <h3>Add New Menu</h3>
                            <form method="post" action="{{ route('menus.store') }}">
                                @csrf
                                <div>
                                    <label>Menu Name:</label>
                                    <input type="text" name="name" placeholder="New menu name" required />
                                </div>
                                <div>
                                    <label>Description:</label>
                                    <input type="text" name="desc" placeholder="Description" required />
                                </div>
                                <div>
                                    <label>Price:</label>
                                    <input type="text" name="price" placeholder="Price" required />
                                </div>
                                <div>
                                    <label>Choose Remarkable:</label>
                                    <table border="1" cellpadding="10">
                                        <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>Remark Name</th>
                                                <th>Additional Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($remarks as $remark)
                                                <tr>
                                                    <td>
                                                        <input type="checkbox" name="remarks[]"
                                                            value="{{ $remark['name'] }}">
                                                    </td>
                                                    <td>{{ $remark['name'] }}</td>
                                                    <td>{{ number_format($remark['price'], 2) }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    <input type="submit" value="Add Menu" />
                                </div>
                            </form>
                        </div>

                        <!-- Edit Menu Form (Hidden by default) -->
                        <div id="editMenuForm" style="display:none;">
                            <h3>Edit Menu</h3>
                            <form method="post" id="editMenuAction">
                                @csrf
                                @method('PUT')
                                <div>
                                    <label>Menu Name:</label>
                                    <input type="text" id="editName" name="name" required />
                                </div>
                                <div>
                                    <label>Description:</label>
                                    <input type="text" id="editDesc" name="desc" required />
                                </div>
                                <div>
                                    <label>Price:</label>
                                    <input type="text" id="editPrice" name="price" required />
                                </div>
                                <div>
                                    <label>Status:</label>
                                    <select name="status" id="editStatus" required>
                                        <option value="active">Active</option>
                                        <option value="soldOut">Sold Out</option>
                                        <option value="archived">Archived</option>
                                    </select>
                                </div>
                                <div>
                                    <label>Edit Remarks:</label>
                                    <table border="1" cellpadding="10">
                                        <thead>
                                            <tr>
                                                <th>Select</th>
                                                <th>Remark Name</th>
                                                <th>Additional Price</th>
                                            </tr>
                                        </thead>
                                        <tbody id="editRemarks">
                                            <!-- Remarks will be populated dynamically with JavaScript -->
                                        </tbody>
                                    </table>
                                </div>
                                <div>
                                    <input type="submit" value="Update Menu" />
                                    <button type="button" onclick="cancelEdit()">Cancel</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Menu Table -->
                <div class="col-md-8">
                    <h3>Menu List</h3>
                    @if (session('success'))
                        <div class="alert alert-success" id="successMessage">
                            {{ session('success') }}
                        </div>
                    @endif
                    <table border="1" cellpadding="10">
                        <thead>
                            <tr>
                                <th>Menu Code</th>
                                <th>Name</th>
                                <th>Description</th>
                                <th>Price</th>
                                <th>Status</th>
                                <th>Remarkable</th>
                                <th>Edit</th>
                                <th>Delete</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menus as $menu)
                                <tr>
                                    <td>{{ $menu->menu_code }}</td>
                                    <td>{{ $menu->name }}</td>
                                    <td>{{ $menu->desc }}</td>
                                    <td>{{ $menu->price }}</td>
                                    <td>{{ $menu->status }}</td>
                                    <td>{{ is_array($menu->remarkable) ? implode(', ', $menu->remarkable) : '' }}</td>
                                    <td>
                                        <button type="button"
                                            onclick="editMenu('{{ $menu->menu_code }}', '{{ $menu->name }}', '{{ $menu->desc }}', '{{ $menu->price }}', '{{ json_encode($menu->remarkable) }}')">
                                            Edit
                                        </button>
                                    </td>
                                    <td>
                                        <form method="post" action="{{ route('menus.destroy', $menu->menu_code) }}"
                                            style="display: inline-block;">
                                            @csrf
                                            @method('DELETE')
                                            <input type="submit" value="Delete"
                                                onclick="return confirm('Are you sure?')">
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

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

    <!-- Script Section -->
    <script>
        // Hide the success message after 3 seconds
        setTimeout(function() {
            let successMessage = document.getElementById('successMessage');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
        }, 3000);

        // Switch from Add Menu to Edit Menu form
        function editMenu(menuCode, name, desc, price, remarks) {
            document.getElementById('addMenuForm').style.display = 'none';
            document.getElementById('editMenuForm').style.display = 'block';

            document.getElementById('editName').value = name;
            document.getElementById('editDesc').value = desc;
            document.getElementById('editPrice').value = price;

            const statusField = document.getElementById('editStatus');
            statusField.value = status;

            // Populate the remarks for editing
            let selectedRemarks = JSON.parse(remarks);
            let remarkList = @json($remarks);
            let remarkTable = '';

            remarkList.forEach(function(remark) {
                let isChecked = selectedRemarks.includes(remark.name) ? 'checked' : '';
                let formattedPrice = parseFloat(remark.price).toFixed(2);
                remarkTable += `<tr>
                                    <td><input type="checkbox" name="remarks[]" value="${remark.name}" ${isChecked}></td>
                                    <td>${remark.name}</td>
                                    <td>${formattedPrice}</td>
                                </tr>`;
            });

            document.getElementById('editRemarks').innerHTML = remarkTable;
            document.getElementById('editMenuAction').action = '/menus/' + menuCode;
        }

        // Cancel Edit and switch back to Add Menu form
        function cancelEdit() {
            document.getElementById('addMenuForm').style.display = 'block';
            document.getElementById('editMenuForm').style.display = 'none';
        }
    </script>

    <!-- jQery -->
    <script src="{{ asset('js/jquery-3.4.1.min.js') }}"></script>
    <!-- popper js -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <!-- bootstrap js -->
    <script src="{{ asset('js/bootstrap.js') }}"></script>
    <!-- owl slider -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>
    <!-- isotope js -->
    <script src="https://unpkg.com/isotope-layout@3.0.4/dist/isotope.pkgd.min.js"></script>
    <!-- custom js -->
    <script src="{{ asset('js/custom.js') }}"></script>
    <!-- Google Map -->
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCh39n5U-4IoWpsVGUHWdqB6puEkhRLdmI&callback=myMap">
    </script>
    <!-- End Google Map -->

</body>

</html>
