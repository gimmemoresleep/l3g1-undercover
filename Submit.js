    
    
    let temps =document.getElementById('temps').innerHTML;

    if(temps !== "null"){
        //récupération des données saisies par l'utilisateur et transmis en php
        var date =document.getElementById('date').innerHTML;
        var heure =document.getElementById('heure').innerHTML;
        var transport =document.getElementById('transport').innerHTML;
        var longitude =document.getElementById('longitude').innerHTML;
        var latitude =document.getElementById('latitude').innerHTML;


        let temps1 = temps/3;
        let temps2 = 2*temps/3;

        var url = "http://localhost:8080/otp/routers/graphs/isochrone?fromPlace="+latitude+","+longitude+"&mode="+transport+"&date="+date+"&time="+heure+"am&cutoffSec="+temps1+"&cutoffSec="+temps2+"&cutoffSec="+temps
        
        CreateIsochrone(url,temps1,temps2,temps,latitude, longitude);
    }

  
  
  /**
   *Fonction permettant la création de l'isochrone à partir des données Json fournis par OTP 
   *@Param url les données Json fourni par OTP
   */
  
  function CreateIsochrone(url,temps1,temps2,temps,longitude,latitude){
      $.getJSON( url , function( data ) {
            
            mymap.flyTo([longitude , latitude], 12);//recentre la carte

            temps = temps/60;
            temps1 = temps1/60;
            temps2 = temps2/60;
          
          var data1 = data.features[0].geometry.coordinates[0][0];
          var tableau1 = Tab2DReverse(data1);
          CreatePolygone(tableau1,"red", ""+temps+"min");

          var data2 = data.features[1].geometry.coordinates[0][0];
          var tableau2 = Tab2DReverse(data2);
          CreatePolygone(tableau2,"blue",""+temps2+" min");

          //évite les erreurs lorsque le temps est trop court
          if(data.features[2].geometry.coordinates[0][0] !== null){
          var data3 = data.features[2].geometry.coordinates[0][0];
          var tableau3 = Tab2DReverse(data3);
          CreatePolygone(tableau3,"green",""+temps1+" min");
          }
       
      });
    }
  
  
  
  /**
   *Fonction permettant l'ajout d'un polygone de couleur
   *
   *@Param tab le tableau de coordonnées
   *@Param couleur la couleur du polygone 
   *@Param popup le temps correspondant au polygone survolé affiché dans un popup
   */
  
  function CreatePolygone(tab,couleur,popup){
    var pol = L.polygon([tab],{color:couleur}).addTo(mymap).bindPopup(popup)
      .on('mouseover', function (e) {
              this.openPopup();})
        .on('mouseout', function (e) {
              this.closePopup();
            });
    

  }
  
  
  /**
   *Fonction permettant d'inverser les coordonées de tout les tableaux contenu dans un tableau
   *
   *@param un tableau de tableaux de coordonées 
   *return ce même tableau en inversant les longitudes avec les latitudes
   */
  
      function Tab2DReverse(tableau) {
  
          for (var i = 0; i < tableau.length; i++) {
          var x=0;
          x=tableau[i][0];
          tableau[i][0]=tableau[i][1];
          tableau[i][1]=x;
           }
           return tableau;
      }

