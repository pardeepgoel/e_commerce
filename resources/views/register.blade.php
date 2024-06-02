<!doctype html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <title>Register</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">


    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.min.js"></script>
<script>
    $(document).ready(function() {
        $(".form").validate({
            rules: {
                name: "required",
                password: {
                    required: true,
                    minlength: 8
                },
                password_confirmation: {
                    required: true,
                    minlength: 8,
                    equalTo: "#password"
                },
                email: {
                    required: true,
                    email: true
                }
            },
            submitHandler: function(form) {
                var serializeData = $(form).serialize(); // Change 'form' to $(form)
                $('.alert').hide();
                $.ajax({
                    type: "POST",
                    url: "{{ env('BASE_URL') . '/api/register' }}",
                    data: serializeData,
                    success: function(data, textStatus, xhr) {
                        if (xhr.status == 200) {

                            $('.alert-success').show()
                            $('.alert-success').text('Signup Success!')


                        }
                    },
                    error: function(xhr, textStatus, errorThrown) { // Add error handler
                        console.log(xhr.responseJSON);
                        var responseJSON = xhr.responseJSON
                        if (xhr.status == 400) {
                            if (responseJSON.email) {
                                $('.alert-error').show()
                                $('.alert-error').text(responseJSON.email)
                            }
                        }

                    },
                    complete: function(xhr, textStatus) {
                        console.log(xhr.status);
                    }
                });
            }
        });

    });
</script>

<body> <!-- partial:index.partial.html -->

    <section>
        <div class="signin">

            <div class="content">

                <h2>Sign Up</h2>
                <div class="alert alert-success" style="display: none;">
                    Indicates a successful or positive action.
                </div>
                <div class="alert alert-error " style="display: none;">
                    Indicates a successful or positive action.
                </div>
                <form action="" class="form" id="register">

                    <div class="inputBox">
                        <label class="input-label" for="name">Name</label>
                        <input type="text" name="name" required>

                    </div>
                    <div class="inputBox">
                        <label class="input-label" for="email">Email</label>

                        <input type="email" name="email" required>

                    </div>
                    <div class="inputBox">
                        <label class="input-label" for="password">Password</label>

                        <input type="password" name="password" id="password" required>

                    </div>

                    <div class="inputBox">
                        <label class="input-label" for="password_confirmation">Confirm Password</label>

                        <input type="password" name="password_confirmation" required>

                    </div>
                    <div class="links">
                        <a href="{{ url('login-page') }}">Login</a>
                    </div>
                    <div class="inputBox">

                        <input type="submit" value="Signup">

                    </div>

                </form>

            </div>

        </div>

    </section> <!-- partial -->

</body>

</html>
