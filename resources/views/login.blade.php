<!doctype html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Login</title>

    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $("#login").validate({
            submitHandler: function(form) {

                var serializeData = $('form').serialize();

                $.ajax({
                    type: "POST",
                    url: "{{ env('BASE_URL') . '/api/login' }}",
                    data: serializeData,
                    success: function(data, textStatus, xhr) {
                        if(xhr.status==200){
                            window.location.href = "{{url('login-process')}}"+"?token="+data.token
                        }
                    },
                    error: function(xhr, textStatus, errorThrown) { // Add error handler
                        console.log(xhr.responseJSON);
                        var responseJSON = xhr.responseJSON
                        if (xhr.status == 401) {
                            
                                $('.alert-error').show()
                                $('.alert-error').text('Invalid Credentials!')
                            
                        }

                    },
                });
            }
        });
    });

  
    
</script>

<body> <!-- partial:index.partial.html -->

    <section>
        <div class="signin">

            <div class="content">

                <h2>Sign In</h2>

                <div class="alert alert-error " style="display: none;">
                    Indicates a successful or positive action.
                </div>
                <form action="#" method="post" id="login" class="form">
                    <div class="inputBox">
                        <label class="input-label" for="email">Email</label>
                        <input type="email" name="email" required>

                    </div>

                    <div class="inputBox">
                        <label class="input-label" for="password">Password</label>
                        <input type="password" name="password" required>

                    </div>
                    <div class="links">
                        <a href="{{ url('register-page') }}">Signup</a>
                    </div>



                    <div class="inputBox">

                        <input type="submit" value="Login">

                    </div>
                </form>


            </div>

        </div>

    </section> <!-- partial -->

</body>

</html>
