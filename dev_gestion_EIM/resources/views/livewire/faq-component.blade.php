
@include('header')
<div>
    {{-- Stop trying to control. --}}
    <div>    
        <p>
            <input type="button" value="+" id="bt" onclick="toggle1(this)">
            Quelle est la qualité de l'image dans une visioconférence ? Cela risque-t-il de déranger ma réunion ?
        </p>
        <div style="border:solid 1px #ddd; padding:10px; display:none;" id="q1">
            <p>La qualité peut varier selon les services. Les applications gratuites et grand public peuvent entraîner une mauvaise qualité d'image, 
                une pixellisation et des problèmes de bande passante, ce qui peut être gênant pendant les réunions. Mais dès que vous passerez à la 
                visioconférence HD de qualité professionnelle, vous bénéficierez d'une qualité d'image et d'un son réalistes qui vous donneront vraiment
                l'impression que votre conversation se déroule dans la même pièce, même si les personnes à qui vous parlez sont à des milliers de 
                kilomètres de distance. Pour de meilleurs résultats, nous vous recommandons de maintenir 720p30 à une bande passante de 700 Kbps 
                (vitesses montantes et descendantes). Pour une qualité encore meilleure, augmentez votre bande passante à 1,2 Mbps pour une qualité 1080p30.
            </p>    
        </div>
    </div>
    <div>    
        <p>
            <input type="button" value="+" id="bt" onclick="toggle2(this)">
            Pourrai-je montrer à l'autre personne ce qu'il y a sur mon écran, partager des 
            documents avec eux ou modifier des documents en temps réel ?
        </p>
        <div style="border:solid 1px #ddd; padding:10px; display:none;" id="q2">
            <p> 
                C'est un grand oui à tout ce qui précède. Toute personne participant à une 
                réunion peut partager son écran pour afficher une présentation ou afficher 
                un document à modifier et à mettre à jour en temps réel. En conséquence, la
                 visioconférence peut vraiment tout rationaliser, des séminaires de formation
                  aux réunions de statut informelles. Pour en savoir plus sur le partage 
                  d'écran, consultez notre dernier blog sur Real-Time Collaboration and the 
                  Importance of 1080P Data.

            </p>    
        </div>
    </div>
    <div>    
        <p>
            <input type="button" value="+" id="bt" onclick="toggle3(this)">
            Puis-je ajouter plus d'une personne dans un appel en même temps ?

        </p>
        <div style="border:solid 1px #ddd; padding:10px; display:none;" id="q3">
            <p> 
                Oui. Nous proposons actuellement des appels de groupe pouvant 
                accueillir jusqu'à 50 participants différents, qui peuvent être 
                50 personnes se connectant depuis leur ordinateur portable ou 
                leur téléphone, 50 systèmes de visioconférence différents remplis
                 de personnes ou d’un mélange d'individus et de systèmes de 
                 visioconférence. Et selon vos préférences, il existe différentes
                  options de mise en page pour la façon dont vous souhaitez 
                  afficher ces appels de groupe plus importants. Consultez notre 
                  blog sur Taking Control of Your Meeting Layouts pour plus 
                  d'informations.

            </p>    
        </div>
    </div>
    <div>    
        <p>
            <input type="button" value="+" id="bt" onclick="toggle4(this)">
           Puis-je utiliser deux moniteurs ?
        </p>
        <div style="border:solid 1px #ddd; padding:10px; display:none;" id="q4">
            <p>
            Le Lifesize® Icon 600™ et le Lifesize® Icon 800™ prennent tous deux 
            en charge plusieurs écrans afin que vous puissiez voir une présentation 
            en plein écran sur un moniteur et les participants vidéo sur un autre. 
            Les modèles Lifesize® Icon 400™ et Lifesize® Icon 450™ ne prennent en 
            charge qu'un seul moniteur, car ils sont conçus pour les petits espaces 
            de salle de réunion. L'application de bureau Lifesize pour Mac® et PC est 
            compatible avec plusieurs écrans, tout comme l'application Web Lifesize.

            </p>    
        </div>
    </div>
    <div>    
        <p>
            <input type="button" value="+" id="bt" onclick="toggle5(this)">
            Puis-je passer des appels vidéo avec des personnes extérieures à mon organisation ?

        </p>
        <div style="border:solid 1px #ddd; padding:10px; display:none;" id="q5">
            <p>
                Oui. Chaque utilisateur Lifesize a la possibilité d'envoyer des 
                invitations illimitées. Cela peut se faire à partir de Microsoft® 
                Outlook® add-in or a Google Calendar™ extension ou à partir du 
                menu Calendrier de l'application Lifesize. Et si les utilisateurs 
                ont leurs propres comptes Lifesize, ils peuvent simplement ajouter 
                des invités à leur répertoire et les appeler directement.

            </p>    
        </div>
    </div>
    <div>    
        <p>
            <input type="button" value="+" id="bt" onclick="toggle6(this)">
            Quel type de caméra dois-je utiliser ?

        </p>
        <div style="border:solid 1px #ddd; padding:10px; display:none;" id="q6">
            <p>
            La plupart des ordinateurs portables et des moniteurs sont équipés 
            de caméras intégrées, qui fonctionnent parfaitement avec l'application 
            Lifesize. Pour les salles de réunion, nous avons des systèmes de 
            visioconférence et des caméras spécialement conçus pour les petites salles 
            de réunion, les salles de conférence et de réunion et les grands 
            auditoriums. Vous pouvez consulter le Lifesize Icon Series Guide pour plus 
            d'informations sur les différents systèmes de salle de réunion.

            </p>    
        </div>
    </div>
    <div>    
        <p>
            <input type="button" value="+" id="bt" onclick="toggle7(this)">
            Puis-je basculer entre l'affichage d'une présentation et l'affichage de personnes participant à une visioconférence ?

        </p>
        <div style="border:solid 1px #ddd; padding:10px; display:none;" id="q7">
            <p>
               En tant que présentateur, il vous suffit de cliquer sur l'icône de 
               présentation pour basculer entre les modes de partage d'écran. En 
               tant que participant, vous contrôlez ce que vous voyez avec le 
               curseur du mode de présentation.
 
            </p>    
        </div>
    </div>
    <div>    
        <p>
            <input type="button" value="+" id="bt" onclick="toggle8(this)">
            Quelle est la différence entre la conférence Web et la visioconférence ?

        </p>
        <div style="border:solid 1px #ddd; padding:10px; display:none;" id="q8">
            <p>
                La conférence Web et la visioconférence adoptent le concept de 
                communication multidirectionnelle et tentent de créer une 
                expérience plus engageante et productive. La conférence Web 
                fonctionne très bien pour diffuser le discours d'un seul orateur à 
                un large public, mais si la qualité, la fiabilité et le dialogue sont 
                importants pour vous, rien ne vaut la visioconférence. Consultez notre 
                récent blog, Everything You Need to Know about Web Conferencing vs. 
                Video Conferencing, pour plus d'informations.

            </p>    
        </div>
    </div>
    <div>    
        <p>
            <input type="button" value="+" id="bt" onclick="toggle9(this)">
            Comment les appels internationaux sont-ils gérés ?

        </p>
        <div style="border:solid 1px #ddd; padding:10px; display:none;" id="q9">
            <p>
            Avec la vidéo, la seule chose à prendre en compte est le fuseau 
            horaire de la personne que vous appelez. L'appel est connecté via 
            Internet. Nos services offrent également des appels vocaux uniquement 
            afin que vous puissiez toujours vous connecter même lorsque vous ne 
            pouvez pas être en vidéo. Nous avons des numéros gratuits dans plus 
            de 60 pays pour les audioconférences internationales.

            </p>    
        </div>
    </div>
    <div>    
        <p>
            <input type="button" value="+" id="bt" onclick="toggle10(this)">
           Quelle est l'interopérabilité entre Lifesize et Microsoft® Skype Entreprise ?

        </p>
        <div style="border:solid 1px #ddd; padding:10px; display:none;" id="q10">
            <p>
            Pour les 100 millions d'utilisateurs d'entreprise sur Skype Entreprise 
            (anciennement Lync), nous leur avons permis d'appeler directement depuis 
            leur application pour se connecter aux réunions Lifesize sans avoir à 
            télécharger une autre application. Découvrez comment cela fonctionne sur 
            notre blog,  Lifesize and Skype for Business.

            </p>    
        </div>
    </div>
    <div>    
        <p>
            <input type="button" value="+" id="bt" onclick="toggle11(this)">
            La visioconférence est-elle sécurisée ?

        </p>
        <div style="border:solid 1px #ddd; padding:10px; display:none;" id="q11">
            <p>
            Les fonctions de sécurité varient selon le fournisseur. Nous offrons 
            une fiabilité de réseau, une sécurité et un pare-feu à la pointe de 
            l'industrie pour garantir que votre réunion est accessible uniquement 
            aux personnes que vous avez invitées, et non à des tiers indésirables. 
            Consultez notre page Network Reliability and Security pour plus 
            d'informations sur notre solution de visioconférence sécurisée.

            </p>    
        </div>
    </div>



    <script>
        function toggle1(ele) {
            var q1 = document.getElementById('q1');
            if (q1.style.display == 'block' ) {q1.style.display = 'none';document.getElementById(ele.id).value = '+';}
            else{q1.style.display = 'block';document.getElementById(ele.id).value = '-';}
        }
        function toggle2(ele) {
            var q2 = document.getElementById('q2');
            if (q2.style.display == 'block' ) {q2.style.display = 'none';document.getElementById(ele.id).value = '+';}
            else{q2.style.display = 'block';document.getElementById(ele.id).value = '-';}
        }
        function toggle3(ele) {
            var q3 = document.getElementById('q3');
            if (q3.style.display == 'block' ) {q3.style.display = 'none';document.getElementById(ele.id).value = '+';}
            else{q3.style.display = 'block';document.getElementById(ele.id).value = '-';}
        }
        function toggle4(ele) {
            var q4 = document.getElementById('q4');
            if (q4.style.display == 'block' ) {q4.style.display = 'none';document.getElementById(ele.id).value = '+';}
            else{q4.style.display = 'block';document.getElementById(ele.id).value = '-';}
        }
        function toggle5(ele) {
            var q5 = document.getElementById('q5');
            if (q5.style.display == 'block' ) {q5.style.display = 'none';document.getElementById(ele.id).value = '+';}
            else{q5.style.display = 'block';document.getElementById(ele.id).value = '-';}
        }
        function toggle6(ele) {
            var q6 = document.getElementById('q6');
            if (q6.style.display == 'block' ) {q6.style.display = 'none';document.getElementById(ele.id).value = '+';}
            else{q6.style.display = 'block';document.getElementById(ele.id).value = '-';}
        }
        function toggle7(ele) {
            var q7 = document.getElementById('q7');
            if (q7.style.display == 'block' ) {q7.style.display = 'none';document.getElementById(ele.id).value = '+';}
            else{q7.style.display = 'block';document.getElementById(ele.id).value = '-';}
        }
        function toggle8(ele) {
            var q8 = document.getElementById('q8');
            if (q8.style.display == 'block' ) {q8.style.display = 'none';document.getElementById(ele.id).value = '+';}
            else{q8.style.display = 'block';document.getElementById(ele.id).value = '-';}
        }
        function toggle9(ele) {
            var q9 = document.getElementById('q9');
            if (q9.style.display == 'block' ) {q9.style.display = 'none';document.getElementById(ele.id).value = '+';}
            else{q9.style.display = 'block';document.getElementById(ele.id).value = '-';}
        }
        function toggle10(ele) {
            var q10 = document.getElementById('q10');
            if (q10.style.display == 'block' ) {q10.style.display = 'none';document.getElementById(ele.id).value = '+';}
            else{q10.style.display = 'block';document.getElementById(ele.id).value = '-';}
        }
        function toggle11(ele) {
            var q11 = document.getElementById('q11');
            if (q11.style.display == 'block' ) {q11.style.display = 'none';document.getElementById(ele.id).value = '+';}
            else{q11.style.display = 'block';document.getElementById(ele.id).value = '-';}
        }

        
    </script>
</div>
@include('footer')