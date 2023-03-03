@include('header')
<div class="container hidden">
    <div class="row">
        <div class="col-sm-0 col-md-2 col-lg-3"></div>
        <div class="col-sm-12 col-md-8 col-lg-6">
            <h1 style="text-align: center">Outils de gestion des équipements d'impressions multifonctions (EIM)</h1>
        </div>
    </div>
    </div>
<div class="row hidden" style="margin-bottom: 25px;">
    <div class="container ContainerTab">
        <table id="tabEim" class="table table-striped table-bordered" style="width:100%">
            
            
            <!--Entête du tableau-->
            <thead>
                <tr>
                    <th>Numéro inventaire</th>
                    <th>Marque imprimante</th>
                    <th>Modèle imprimante</th>
                    <th>Entité</th>
                    <th>Localisation</th>
                    <th>Etat encre</th>
                    <!--<th>Impressions restantes</th>-->
                    <th>Etat connecté</th>
                    <th>Quotas</th>
                </tr>

            </thead>
            <!--Fin entête tableau-->

            <!--Contenu tableau-->
            <tbody id="MaTable">
                {{App\Http\Controllers\fonctionsController::fill_eim_table()}}
            </tbody>
            <!--Fin entête tableau-->

            <!--Bas du tableau-->
            <tfoot>
                <tr>
                    <th>Numéro inventaire</th>
                    <th>Marque imprimante</th>
                    <th>Modèle imprimante</th>
                    <th>Entité</th>
                    <th>Localisation</th>
                    <th>Etat encre</th>
                    <!--<th>Impressions restantes</th>-->
                    <th>Etat connecté</th>
                    <th>Quotas </th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
<div id="quote">
    <p>Quotas disponibles sur les EIM Toshiba couleur</p>
    <a id="export" href="{{route('csv')}}">Exporter bdd</a>
</div>
@include('footer')
