<div class="hidden">


    <footer class="page-footer font-small footer">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <!-- Copyright -->
                    <div class="footer-copyright text-center py-3">© 2022 Conseil départemental
                    </div>
                    <!-- Copyright -->
                </div>
            </div>
        </div>
    </footer>
    </div>
    <!-- On charge la classes javascript jquery  -->
    
    
    <script type="text/javascript" src="{{asset('js/jquery.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/popper.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/bootstrap.js')}}"></script>
    
    <!-- On charge les classes javascript dataTables-->
    <script type="text/javascript" src="{{ asset('js/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/dataTables.bootstrap.min.js') }}"></script>
    <!-- On charge la classe javascript swwetalert pour les popups-->
    <script type="text/javascript" src="{{ asset('js/sweetalert.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/fontawsome.js') }}"></script>
    <!-- On charge le fichier javascript principal -->
    <script type="text/javascript" src="{{ asset('js/jquery-ui.js') }}"></script>
    
    {{-- <script type="text/javascript" src="{{asset('js/mdb.js')}}"></script> --}}
    <script type="text/javascript" src="{{ asset('js/datatables.min.js') }}"></script>
    <script type="application/javascript" src="{{asset('js/main.js')}}"></script>
    
    <script>
        function change(link){
            link.href = url.replace('geseim','referents');
        }

        $("#mon_search").ready(function(){

            var mon_array = $("#mon_user").html().split(';');

            console.log(mon_array[4]);

            if(mon_array[4] === "benoit.rabesahala" || mon_array[4] ==="gilles.treuthard" || mon_array[4] ==="laurent.prunella"){
                
                $.extend( true, $.fn.dataTable.defaults, {
                    search:{
                    search :"toshiba color"
                    }
                } );

                $("#export").show();
            }else{
                $("#export").hide();
            }
        });  
    </script>
    
    </body>
    
    <!-- Footer -->
    
    <!-- Pied de page -->
    </html>
    