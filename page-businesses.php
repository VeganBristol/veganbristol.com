<? get_header() ?>

    <div id="map"></div>

    <script>
        var map, infoWindow, animatedMarker;
        var markers = [];   

        function focusMarker(marker){
          map.panTo(marker.getPosition());
          if (animatedMarker != null){
            animatedMarker.setAnimation(null);
          }
          animatedMarker = marker;
          marker.setAnimation(google.maps.Animation.BOUNCE);
        }

        function loadContent(marker, post_slug){
          focusMarker(marker);          
          infoWindow.setContent("Loading...");
          infoWindow.open(map, marker);
          $.ajax({
            url: post_slug,
            success: function(data){
              var content = "<div id='infowindow-content'>"+data+"</div>";
              document.getElementById("sideinfobox").innerHTML = content;
              openInfo();
              // infoWindow.setContent(content);
              // infoWindow.open(map, marker);
              infoWindow.close();
              focusMarker(marker);
            }
          });
        }

        function initialize () {
          // Styles a map in night mode.
          map = new google.maps.Map(document.getElementById('map'), {
            center: {lat: 51.457, lng: -2.592},
            zoom: 14,
            styles: [
              {elementType: 'geometry', stylers: [{color: '#242f3e'}]},
              {elementType: 'labels.text.stroke', stylers: [{color: '#242f3e'}]},
              {elementType: 'labels.text.fill', stylers: [{color: '#746855'}]},
              {
                featureType: 'administrative.locality',
                elementType: 'labels.text.fill',
                stylers: [{color: '#d59563'}]
              },
              {
                featureType: 'poi',
                elementType: 'labels.text.fill',
                stylers: [{color: '#d59563'}]
              },
              {
                featureType: 'poi.park',
                elementType: 'geometry',
                stylers: [{color: '#263c3f'}]
              },
              {
                featureType: 'poi.park',
                elementType: 'labels.text.fill',
                stylers: [{color: '#6b9a76'}]
              },
              {
                featureType: 'road',
                elementType: 'geometry',
                stylers: [{color: '#38414e'}]
              },
              {
                featureType: 'road',
                elementType: 'geometry.stroke',
                stylers: [{color: '#212a37'}]
              },
              {
                featureType: 'road',
                elementType: 'labels.text.fill',
                stylers: [{color: '#9ca5b3'}]
              },
              {
                featureType: 'road.highway',
                elementType: 'geometry',
                stylers: [{color: '#746855'}]
              },
              {
                featureType: 'road.highway',
                elementType: 'geometry.stroke',
                stylers: [{color: '#1f2835'}]
              },
              {
                featureType: 'road.highway',
                elementType: 'labels.text.fill',
                stylers: [{color: '#f3d19c'}]
              },
              {
                featureType: 'transit',
                elementType: 'geometry',
                stylers: [{color: '#2f3948'}]
              },
              {
                featureType: 'transit.station',
                elementType: 'labels.text.fill',
                stylers: [{color: '#d59563'}]
              },
              {
                featureType: 'water',
                elementType: 'geometry',
                stylers: [{color: '#17263c'}]
              },
              {
                featureType: 'water',
                elementType: 'labels.text.fill',
                stylers: [{color: '#515c6d'}]
              },
              {
                featureType: 'water',
                elementType: 'labels.text.stroke',
                stylers: [{color: '#17263c'}]
              }
            ]
          });

          var contentString = '';

          infoWindow = new google.maps.InfoWindow({
            content: contentString,
            maxWidth: 600,
          });        

          var links = '';

<?

$myposts = get_posts(array(
				'post_type'=> 'business',
				'posts_per_page'=>'100', 
				'post_status'=>'publish', 
				'order'=>'ASC'));

$counter = 0;

foreach($myposts as $post) :
	global $post;
	setup_postdata($post);
	$values = get_field('location');
	$lat = $values['lat'];
	$lng = $values['lng'];
  $post_slug=$post->post_name;


	if (empty($lat) or empty($lng)) {
?>
	console.error( '<?=the_title()?> has no latlng set.' );
<?	
	// the_content();
	} else {
?>
		markers[<?=$counter?>] = new google.maps.Marker({
		    position: { lat: <?=$lat?>, lng: <?=$lng?> },
		    map: map,
		    title:"Marker"
		});


    markers[<?=$counter?>].addListener('click', function() {
      // infoWindow.setContent("<?
      //   echo "<a href='{$post_slug}'>";
      //   the_title();
      //   echo "</a>";
      //   ?>"
      //   );
      loadContent(markers[<?=$counter?>],"<?=$post_slug?>");
    });

    links += '<a href="#" onclick="loadContent(markers[<?=$counter?>],\'<?=$post_slug?>\');">';
    links += '<?the_title()?>';
    links += '</a>';    
<?
		$counter++;
	}
endforeach;
?>

      document.getElementById("links").innerHTML = links;
    }


    </script>

    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDvfhHopNdtPTjvZx8LfrJLjCiQwrHzfH0&callback=initialize"
    async defer></script>

    <div id="overmap">

      <div class="overmap_item">
        about
      </div>

      <div class="overmap_item">
        news
      </div>

      <div class="overmap_item" onclick="openNav()">
        food &amp; drink
      </div>

      <div class="overmap_item">
        articles
      </div>

    </div>

    <script>
      /* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
      function openNav() {
          closeInfo();
          document.getElementById("mySidenav").style.width = "100%";
          document.getElementById("map").style.marginLeft = "100%";
      }

      /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
      function closeNav() {
          document.getElementById("mySidenav").style.width = "0";
          document.getElementById("map").style.marginLeft = "0";
      }
    </script>

    <div id="mySidenav" class="sidenav">
      <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
      <div id="links">
      </div>
    </div>

    <script>
      /* Set the width of the side navigation to 250px and the left margin of the page content to 250px */
      function openInfo() {
          document.getElementById("mySideinfo").style.width = "600px";
          document.getElementById("map").style.marginLeft = "600px";
      }

      /* Set the width of the side navigation to 0 and the left margin of the page content to 0 */
      function closeInfo() {
          document.getElementById("mySideinfo").style.width = "0";
          document.getElementById("map").style.marginLeft = "0";
      }
    </script>

    <div id="mySideinfo" class="sideinfo">
      <a href="javascript:void(0)" class="closebtn" onclick="closeInfo()">&times;</a>
      <div id="sideinfobox">
      </div>
    </div>


    <!-- Use any element to open the sidenav -->
    

    <!-- Add all page content inside this div if you want the side nav to push page content to the right (not used if you only want the sidenav to sit on top of the page -->
<?
wp_reset_postdata(); 
get_footer(); ?>


