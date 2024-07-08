<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css" integrity="sha384-dpuaG1suU0eT09tx5plTaGMLBsfDLzUCCUXOY2j/LSvXYuG6Bqs43ALlhIqAJVRb" crossorigin="anonymous">

    <title>{{$title}}</title>
  </head>
  <body>
    
    
    <div class="container">
        <h3>{{$title}}</h3>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>USER_ID</th>
                    <th>ID_EMPLOYEE</th>
                    <th>USERNAME</th>
                    <th>EMAIL</th>
                    <th>LEVEL</th>
                    <th>SINGKRON</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td> {{$user->id}} </td>
                    <td> {{$user->nik}} </td>
                    <td> {{$user->name}} </td>
                    <td> {{$user->email}} </td>
                    <td> {{$user->privilege}} </td>
                    <td>
                        <form method="POST" action="{{route('produk.singkronProses')}}">
                            @csrf
                            <input type="hidden" name="id" value="{{$user->id}}"/>
                            <button type="submit">Proses Singkornisasi</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    
  </body>
</html>