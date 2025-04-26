<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Data User</title>
    <style>
        table {
            border-collapse: collapse;
        }

        th,
        td {
            border: 1px solid black;
            padding: 6px;
        }

        input {
            padding: 6px;
        }

        button {
            padding: 6px;
        }
    </style>
</head>

<body>
    <div style="margin-left: 20px;">
        <h1>Form User</h1>
        <form id="userForm" style="margin-top: 20px; margin-bottom: 20px;width:100%;">
            <input type="hidden" id="id" />
            <div style="margin-bottom: 12px;">
                <input type="text" name="name" id="name" placeholder="Name">
                <span id="nameError" style="color: red;"></span>
            </div>
            <div style="margin-bottom: 12px;">
                <input type="email" name="email" id="email" placeholder="Email">
                <span id="emailError" style="color: red;"></span>
            </div>
            <div style="margin-bottom: 12px;">
                <input type="number" name="age" id="age" placeholder="Age">
                <span id="ageError" style="color: red;"></span>
            </div>
            <div style="margin-bottom: 12px;">
                <button type="submit">Submit</button>
            </div>
        </form>
        <hr>
        <h1>Data User</h1>
        <table id="userTable" style="margin-top: 20px; margin-bottom: 20px;">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Age</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                {{-- data user --}}
            </tbody>
        </table>
    </div>

    {{-- JS --}}
    <script src="{{ asset('jquery-3.7.1.min.js') }}"></script>

    <script>
        $(function() {
            getUser();

            // form submit store/update
            $('#userForm').on('submit', function(e) {
                e.preventDefault();

                const id = $('#id').val();
                const name = $('#name').val();
                const email = $('#email').val();
                const age = $('#age').val();

                const method = id ? 'PUT' :
                    'POST';

                const url = id ? `http://127.0.0.1:8000/api/users/${id}` :
                    "http://127.0.0.1:8000/api/users";

                $.ajax({
                    url: url,
                    type: method,
                    data: {
                        id: id,
                        name: name,
                        email: email,
                        age: age
                    },
                    success: function(response) {
                        alert(response.message);
                        getUser();
                        $('#userForm')[0].reset();

                        $('#id').val('');
                        $('#nameError').text('');
                        $('#emailError').text('');
                        $('#ageError').text('');
                    },
                    error: function(xhr, status, error) {
                        const res = xhr.responseJSON;

                        console.log(res);

                        $('#nameError').text('');
                        $('#emailError').text('');
                        $('#ageError').text('');

                        if (res && res.data) {
                            if (res.data.name) {
                                $('#nameError').text(res.data.name[0]);
                            }
                            if (res.data.email) {
                                $('#emailError').text(res.data.email[0]);
                            }
                            if (res.data.age) {
                                $('#ageError').text(res.data.age[0]);
                            }
                        } else {
                            alert("Terjadi kesalahan: " + res.message);
                        }
                    }
                });
            });
        });

        // getuser
        function getUser() {
            $.ajax({
                url: "http://127.0.0.1:8000/api/users",
                type: "GET",
                success: function(response) {
                    let result = response.data;

                    $('#userTable tbody').empty();

                    result.forEach((item, index) => {
                        let row = `<tr>
                            <td>${item.id}</td>
                            <td>${item.name}</td>
                            <td>${item.email}</td>
                            <td>${item.age}</td>
                            <td>
                                <button onclick="editUser(${item.id})">Edit</button>
                                <button onclick="deleteUser(${item.id})">Delete</button>
                            </td>
                        </tr>`;
                        $('#userTable tbody').append(row);
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Terjadi kesalahan: " + status + " - " + error);
                    $('#userTable tbody').html(
                        `<tr><td colspan="5" style="text-align: center;">Gagal memuat data user.</td></tr>`
                    );
                }
            });
        }

        // edit
        function editUser(id) {
            $.ajax({
                url: `http://127.0.0.1:8000/api/users/${id}`,
                type: 'GET',
                success: function(response) {
                    let user = response.data;
                    $('#id').val(user.id);
                    $('#name').val(user.name);
                    $('#email').val(user.email);
                    $('#age').val(user.age);
                },
                error: function(xhr, status, error) {
                    console.error("Terjadi kesalahan: " + status + " - " + error);
                }
            });
        }

        // delete
        function deleteUser(id) {
            if (confirm("Hapus data user?")) {
                $.ajax({
                    url: `http://127.0.0.1:8000/api/users/${id}`,
                    type: 'DELETE',
                    success: function(response) {
                        alert(response.message);
                        getUser();
                    },
                    error: function(xhr, status, error) {
                        console.error("Terjadi kesalahan: " + status + " - " + error);
                    }
                });
            }
        }
    </script>
</body>

</html>
