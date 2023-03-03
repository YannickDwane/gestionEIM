
<!DOCTYPE html>

<head>
  <title>Gestion EIM</title>
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta http-equiv="content-type" content="text/html; charset=utf-8" />
  <!-- On charge les classes CSS de bootstrap -->
  <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
  <!--On charge la classe CSS principale -->
  <link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css"/>
  <link rel="stylesheet" href="{{asset('css/IE-sheet.css')}}">
  <link rel="icon" type="image/png" href="{{ asset('Images/logo.png')}}" />
  <!-- On charge la classe css du formulaire de connexion */-->
  <link rel="stylesheet" href="{{ asset('css/connexion.css')}}">
{{-- 
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.11.2/css/all.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap"> --}}
  <link rel="stylesheet" href="{{ asset('css/mdb.css')}}">
  <!-- Plugin file -->

  <link rel="stylesheet" href="{{asset('css/datatables.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/style.css')}}">
  <link rel="stylesheet" href="{{asset('css/jquery-ui.css')}}">
  {{-- <link rel="stylesheet" href="{{asset('css/faq.css')}}"> --}}
  <script>
    var url = document.URL;
  </script>
</head>


<body>
  <!-- Entête -->
  <div class="hidden">


  <header>
    <form name="formEntete" method="POST" id="formEntete" action="./index.php?uc=connexion&action=deconnexion">
      <nav class="navbar navbar-expand-sm justify-content-end enteteEim">
        <div class="fl-l left home_gsteim">
          <ol class="navbar-nav text-left  ">
            <li>
              <p class="nav-link"><a onClick='change(this)'><img src="{{asset('Images/home.png')}}"  alt='Ok' height ="110px" width="110px"></a></p>
            </li>
            <p class="navbar-brand gst_eim_name" >&nbsp;&nbsp;Gestion EIM</p>
          </ol>
        </div>

        <div class="collapse navbar-collapse flex-grow-0 ml-auto mr-1 fl-r right" id="navbarSupportedContent">
          <ul class="navbar-nav text-right  ">
            <li class="nav-item active ml-auto mr-1">
              <p id="mon_user" class="nav-link"><i style="font-size: 50px;" class="fas fa-user"></i>&nbsp;&nbsp;{{session('username')}}</p>
            </li>
          </ul>
        </div>
      </nav>
    </form>
  </header>

</div>


