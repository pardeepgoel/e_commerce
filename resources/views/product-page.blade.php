<!DOCTYPE html>
<html lang="en">

<head>
    <title>Products</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <style>
        .loader {
            border: 8px solid #f3f3f3;
            border-radius: 50%;
            border-top: 8px solid #3498db;
            width: 50px;
            height: 50px;
            animation: spin 1s linear infinite;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: none;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Optional: Styling the table */
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 600px;
            margin: 20px auto;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>

</head>

<body>

    <div class="container">
        <button id="logout" class="btn btn-danger">Logout</button>
        <h2>Products</h2>
        <input type="hidden" name="token" id="token" value="{{ $token }}">
        <div>
            <label for="">Search</label><input type="text" class="form-control" name="keyword"
                id="keyword">
        </div><br>
        <div class="loader-container">
            <div class="loader"></div>
        </div>
        <select name="" id="limit">
            <option value="10">10</option>
            <option value="50">50</option>
            <option value="100">100</option>

        </select>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Price</th>
                    <th>Tax</th>
                    <th>Action</th>


                </tr>
            </thead>
            <tbody id="tbody">

            </tbody>
        </table>
        <ul class="pagination">


        </ul>
    </div>
    <!-- Trigger the modal with a button -->


    <!-- Modal -->
    <div id="myModal" class="modal fade" role="dialog">
        <div class="modal-dialog">

            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Product Details</h4>
                </div>
                <div class="modal-body">
                    <table>
                        <tr>
                            <td>
                                Name
                            </td>
                            <td id="pname"></td>
                        </tr>
                        <tr>
                            <td>
                                slug
                            </td>
                            <td id="pslug"></td>
                        </tr>
                        <tr>
                            <td>
                                Price
                            </td>
                            <td id="pprice"></td>
                        </tr>
                        <tr>
                            <td>
                                Desccription
                            </td>
                            <td id="pdesc"></td>
                        </tr>
                    </table>
                    <p></p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
</body>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


<script>
    var currentRequest = null;
    var limit = 10;
    $('#logout').click(function() {
        $.ajax({
            type: "get",
            url: "{{ env('BASE_URL') . '/api/logout' }}",
            headers: {
                'Authorization': 'Bearer {{ $token }}',

            },
            success: function(data, textStatus, xhr) {
                if (xhr.status == 200) {
                    alert(data.message)
                    window.location.href = "{{ url('login-page') }}"


                }
            },

        });
    })

    function fetchProduct(url, keyword, limit = 10) {

        $('.loader').show()
        limit = $('#limit').val();
        currentRequest = $.ajax({
            type: "get",
            url: url + '&keyword=' + keyword + '&limit=' + limit,
            headers: {
                'Authorization': 'Bearer {{ $token }}',

            },
            data: {},
            beforeSend: function() {
                if (currentRequest != null) {
                    currentRequest.abort();
                }
            },
            success: function(data, textStatus, xhr) {
                console.log(data);
                $('.loader').hide()

                if (xhr.status == 200) {
                    var html = '';
                    var paginationLink = '';

                    var products = data.products.data;
                    var links = data.products.links;

                    if (products.length == 0) {
                        html += '<tr><td colspan="4">No record found!</td></tr>'
                    } else {
                        for (var i = 0; i < products.length; i++) {
                            console.log(products[i]);
                            html += '<tr><td>' + products[i].name + '</td><td>' + products[i].slug +
                                '</td><td>' + products[i].price + '</td><td>' + products[i].tax +
                                '</td><td><button class="btn btn-primary" data-toggle="modal" data-target="#myModal" onclick="getDetails(' +
                                products[
                                    i].id + ')">Details</button' + products[i].tax +
                                '</td></tr>'


                        }
                    }

                    //set pagination links
                    for (var j = 0; j < links.length; j++) {
                        paginationLink += '<li data-page="' + data.products.current_page +
                            '" class="page-item  ' + (links[j].active ? 'active' : '') +
                            '"><a class="page-link" onclick="fetchP(this)" data-link="' + links[j].url +
                            '" href="#">' + links[j].label + '</a></li>';


                    }


                    $('#tbody').html(html)
                    $('.pagination').html(paginationLink)

                }
            },

        });
    }
    var url = "{{ env('BASE_URL') . '/api/product/list' }}?page=1";
    var keyword = '';
    $('#limit').change(function() {
        keyword = $('#keyword').val();
        limit = $(this).val();

        fetchProduct(url, keyword, limit)
    })
    //search value fetch
    $('#keyword').on('input', function() {
        keyword = $(this).val();
        fetchProduct(url, keyword)
    });
    //access page on pagination link
    function fetchP(element) {
        var url = $(element).data('link')


        fetchProduct(url, keyword)
    }

    function getDetails(id) {
        $('#pname').text('')
        $('#pslug').text('')
        $('#pprice').text('')
        $('#pdesc').text('')
        $.ajax({
            type: "get",
            url: "{{ env('BASE_URL') . '/api/product' }}/" + id,
            headers: {
                'Authorization': 'Bearer {{ $token }}',

            },
            success: function(data, textStatus, xhr) {
                console.log(data);
                if (xhr.status == 200) {

                    $('#pname').text(data.product.name)
                    $('#pslug').text(data.product.slug)
                    $('#pprice').text(data.product.price)
                    $('#pdesc').text(data.product.description)



                }
            },

        });
    }
    fetchProduct(url, '')
</script>


</html>
