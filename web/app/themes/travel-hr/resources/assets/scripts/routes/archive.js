/* eslint-disable no-undef */
/* eslint-disable no-unused-vars */
import 'waypoints/lib/jquery.waypoints';
import _ from 'underscore/underscore-min';
import L from 'leaflet/dist/leaflet';

export default {
  init: function() {
    jQuery('.dropdown-menu').click(function(e) {
      e.stopPropagation(); //This will prevent the event from bubbling up and close the dropdown when you type/click on text boxes.
    });

    var map, parsed_map_vars, markers;
    var pulseElement = document.createElement('div');
    pulseElement.classList.add('element');
    var thatMarker, thisMarker = {};

    var showIconDetails = function(markerElement, thisMarker) {
      thatMarker = thisMarker;
      jQuery(markerElement).find('.cc-map-marker').addClass('img-icon-anim');
      jQuery(markerElement).find('.cc-map-marker').append(pulseElement);
    };

    var removeIconDetails = function(markerElement, thisMarker) {
      // thisMarker.setZIndex(thatMarker.getZIndex());
      jQuery(markerElement).find('.cc-map-marker').removeClass('img-icon-anim');
      jQuery(markerElement).find('.cc-map-marker').children('.element').remove();
    };

    var loadMarker = function(_id) {
      var id = _id ||  _.keys(markers)[0];
      var marker = markers[id];
      var elements = document.getElementsByClassName('cc-map-marker '+id);

      var markerElement = elements[0];
      showIconDetails(markerElement, marker);
    };

    // eslint-disable-next-line no-undef
    parsed_map_vars = JSON.parse(map_vars);

    var ccIcon = L.divIcon({
        html: '<div class="cc-map-marker"><img class="img-fluid" src="/app/themes/travel-hr/dist/images/map_icon.png" srcset="/app/themes/travel-hr/dist/images/map_icon.png 1x, /app/themes/travel-hr/dist/images/map_icon@2x.png 2x" /></div>',
        iconSize: [34, 50],
        iconAnchor: [18, 49],
        popupAnchor: [0, -26],
    });

    jQuery('#cc-map').ready(function() {
      document.querySelector('.travel__detail__map__map-wrapper').innerHTML = '<div id="cc-map" class="travel__detail__map__map"></div>';
      map = L.map('cc-map',{scrollWheelZoom:false}).setView([parsed_map_vars.city.location.lat, parsed_map_vars.city.location.lng], 15);


      var mbURL = 'https://api.mapbox.com/styles/v1/pandabrand/cj5wzm2s57tap2rocbuf8j6no/tiles/512/{z}/{x}/{y}?access_token=',

      mbAttr = 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, Imagery © <a href="http://mapbox.com">Mapbox</a>';
      L.tileLayer(mbURL + parsed_map_vars.map_info.api_key, {attribution: mbAttr}).addTo(map);

      markers = L.featureGroup();
      for(var x = 0; x < parsed_map_vars.locations.length; x++) {
        var feature = parsed_map_vars.locations[x];
        var marker_place = L.marker([feature.coords.lat, feature.coords.lng],{icon:ccIcon, riseOnHover:true, riseOffset: 3000});
        marker_place.bindPopup('<div class=" cc-marker__popup strong">'+feature.title+'</div>');
        markers.addLayer(marker_place);
        feature.marker_id = markers.getLayerId(marker_place);
        jQuery('#'+feature.location_id).attr('data-cc-marker', feature.marker_id);
        jQuery('#'+feature.location_id).addClass(feature.marker_id);
        marker_place.on('click', scrollToDetail);
      }
      markers.addTo(map);
      map.fitBounds( markers.getBounds() );
    });

  var scrollToDetail = function() {
    Waypoint.disableAll();
    var _id = this._leaflet_id;
    var scrollItem = jQuery('[data-cc-marker="'+_id+'"]');
    var container = jQuery('.travel__detail__map__list');
    jQuery('*').removeClass('img-icon-anim');
    loadMarker(_id);
    container.animate({
      scrollTop: scrollItem.offset().top - container.offset().top + container.scrollTop(),
    }, 2000, function() {
      Waypoint.enableAll();
    });
  };
  jQuery.each(['.travel__detail__map__item'], function(i, classname) {
    var $elements = jQuery(classname);
    var $v_context, $v_offset;
    if(jQuery(window).width() < 769) {
      $v_context = jQuery(window)[0];
      $v_offset = 280;
    } else {
      $v_context = jQuery('.travel__detail__map__list')[0];
      $v_offset = 20;
    }
    $elements.each(function() {
      new Waypoint({
        element: this,
        handler: function(direction) {
          var previousWaypoint = this.previous();
          var nextWaypoint = this.next();
          $elements.removeClass('np-previous np-current np-next');

          if (previousWaypoint && direction === 'down') {
            var _prevId = jQuery(previousWaypoint.element).attr('data-cc-marker');
            var _prevMarker = markers.getLayer(_prevId);
           //  var _prevMarker = markers[Number.parseInt(_prevId)];
           //  removeIconDetails(_prevMarkerEl, _prevMarker)
            jQuery(previousWaypoint.element).addClass('np-previous');
          }

          jQuery(this.element).addClass('np-current');
          var _id = jQuery(this.element).attr('data-cc-marker');
          var _marker = markers.getLayer(_id);
          var _markerEl = jQuery(_marker._icon);
          showIconDetails(_markerEl, _marker);
          map.flyTo(_marker.getLatLng(), 15);


          if (nextWaypoint && direction === 'up') {
            jQuery(nextWaypoint.element).addClass('np-next');
            var _nextId = jQuery(nextWaypoint.element).attr('data-cc-marker');
           //  var _nextMarkerEl = jQuery('.cc-map-marker.'+_nextId);
           //  var _nextMarker = markers[Number.parseInt(_nextId)];
           //  removeIconDetails(_nextMarkerEl, _nextMarker)
          }

        },
        offset: $v_offset,
        group: classname,
        context: $v_context,
      });
    });
  });
 },
}
