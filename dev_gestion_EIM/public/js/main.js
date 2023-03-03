var ip, modele;

$.ajax({
    type: "POST",
    url: "/ip_to_json",
    success: function (result) {
        res = result.substring(1, result.length-1);
        ip = res.replaceAll("\"","").split(","); 
        $.ajax({
            type: "POST",
            url: "/model_to_json",
            success: function (resa) {
            resu = resa.substring(1, resa.length-1);
            modele = resu.replaceAll("\"","").split(",");
            var  z = ip.length - 1;
            //fonction qui permet l'AJAX
            // $(document).ready(function Try() {

            for ( i = 0; i < z ; i++) {
                    
                    //Ajax qui permet de faire appel a la fonction sock_ping
                    $("#Ping" + i).on("click",function() {
                            a = this.id.substr(4);
                            $.ajax({
                            type: "POST",
                            url: "/ext_ping",
                            data : {ip: ip[a]},
                            success: function(result) {
                            if ($("#Ping_div" + a).is(":empty")){
                                $("#Ping_div" + a).html(result).hide();
                                $("#Ping_div" + a).toggle(result);
                            }else{
                                $("#Ping_div" + a).toggle(result);
                            }
                            if(result.startsWith('Conn')){
                                // console.log(a);
                                $("#img" + a).attr("src", "Images/rondRouge.png");
                            }else{
                                // console.log("connexion ok");
                                $("#img" + a).attr("src", "Images/rondVert.png");
                            }
                        }});
                    });

                    //Ajax qui permet de faire appel a la fonction  infoshow()
                    $("#show" + i).on("click",function() {
                            b = this.id.substr(4);
                        $.ajax({type: "POST",
                        url: " /ext_infotip",
                        data: {ip: ip[b]},
                        success: function (result) {
                            modal.style.display = "block";
                            $("#teste").html(result);
                            //ACTION AJAX SET PARAMETER OF FUNCTION resetquotas()
                            for (let job = 1; job <= 100; job++) {
                                $("#reset" + job).on("click",function () {
                                    c = this.id.substr(5);
                                        // var number =  $("#number"+job).val();
                                        var number = document.getElementById("number"+job).value;
                                        console.log(number);
                                        $.ajax({
                                            type: "POST",
                                            url: "/ext_reset",
                                            data: {ip: ip[b],
                                                oid: c , 
                                                value: number}, 
                                            success: function (yes) {
                                                console.log(yes);
                                                setTimeout(() => {window.location.reload()},2000);
                                        }});
                                    $("#teste").html(result);
                                    modal.style.display = "none";
                                });
                            }
                        }});
                    });

                    // Action pour fermer lz fenetre de INFOTIP [MODAL BOX]
                    $(".close").on("click",function () {
                        modal.style.display = "none";
                    });

                    // Action pour faire appel a la fonction toner
                    $('#encre' + i).on("click",function () {
                        //start loading
                        d = this.id.substr(5);
                        $.ajax({type: "POST",
                        url: "/ext_toner",
                        data:{ip:ip[d] ,mod: modele[d]},
                            success: function (result) {
                                if ($("#encre_div" + d).is(":empty")) {
                                    $("#encre_div" + d).html(result).hide();
                                    $("#encre_div" + d).toggle(result);
                                }else{
                                    $("#encre_div" + d).toggle(result);
                                }
                                //stop loading

                            }});
                    });
            }   
        // });

                    // Affiche la fenétre (Modal)
            var modal = document.getElementById("myModal");


            // Ferme quand l'utilisateur clique en dehors de la fenetre
            window.onclick = function (event) {
                if (event.target === modal) {
                    modal.style.display = "none";
                }
            };
            oTable = $('#tabEim').DataTable({
                    fixedColumns: true
                });
        }});  
}});

//Active le dataTables bootstrap
// $(function () {

    
// });

// function downloadCSVFile(csv, filename) {
// 	var csv_file, download_link;

// 	csv_file = new Blob([csv], {type: "text/csv"});

// 	download_link = document.createElement("a");

// 	download_link.download = filename;

// 	download_link.href = window.URL.createObjectURL(csv_file);

// 	download_link.style.display = "none";

// 	document.body.appendChild(download_link);

// 	download_link.click();
// }

// function htmlToCSV(html, filename) {
// 	var data = [];
// 	var rows = document.querySelectorAll("#tabEim tr");
			
// 	for (var i = 0; i < rows.length; i++) {
// 		var row = [], cols = rows[i].querySelectorAll("td, th");
//         row.push(cols[0].innerText);
//         row.push(cols[1].innerText);
//         row.push(cols[2].innerText);
//         row.push(cols[3].innerText);
//         row.push(cols[4].innerText);
// 		data.push(row.join(";")); 		
// 	}

//     console.log(data);
// 	downloadCSVFile(data.join("\n"), filename);
// }

// document.getElementById("download-button").addEventListener("click", function () {
// 	var html = document.querySelector("table").outerHTML;
// 	htmlToCSV(html, "eim.csv");
// });