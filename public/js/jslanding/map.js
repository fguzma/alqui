;(function(){

	class UserLocation{
		static get(callback){

			if(navigator.geolocation){
				navigator.geolocation.getCurrentPosition((location)=>{
					callback({
						lat: location.coords.latitude,
						lng: location.coords.longitude
					})
				})
			}else{
				alert("No pudimos detectar tu ubicación")
				return{
				lat:0,
				lng:0
			}
			}
			
		}
	}

	const my_place = {
		 	 		lat: 12.1297520,
		 	 		lng: -86.2096890
		 	 	}
	google.maps.event.addDomListener(window,"load",()=>{
		 const map = new google.maps.Map(document.getElementById('map'),
		 	 {
		 	 	center:my_place,
		 	zoom:15
		 }
		 	)
		
		UserLocation.get((coords)=>{
			alert("Coordenadas captadas")

			//distancia empresa usuario

			let origen = new google.maps.LatLng(coords.lat,coords.lng)  //LatLng
			let destino = new google.maps.LatLng(my_place.lat, my_place.lng) //LatLng
			
			let service = new google.maps.DistanceMatrixService()

			service.getDistanceMatrix({
				origins: [origen],
				destinations: [destino],
				travelMode: google.maps.TravelMode.DRIVING
			},(response, status)=>{
				if(status === google.maps.DistanceMatrixStatus.Ok){
					const duration_element = response.rows[0].elements[0]
					const duracion_viaje = duration_element.duration.text
					document.querySelector("#mensaje")
							.innerHTML = 'Estás a'+duracion_viaje+'de que te pasen el pack en'+'<span class="satisfy medium">'+'Alquileres y eventos'+'</span>`'  
						
						
				}
							 
								
							
				
			
			})
		})
	})
})()