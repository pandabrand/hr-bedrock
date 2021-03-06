/* eslint-disable no-undef */
/* eslint-disable no-unused-vars */
import 'waypoints/lib/jquery.waypoints';
import _ from 'underscore/underscore';
import L from 'leaflet/dist/leaflet';
import map_icon from '../../images/map_icon-hr.png';
import map_icon_2x from '../../images/map_icon-hr@2x.png';
import hrh_icon from '../../images/hrh-map_icon.png';
import hrh_icon_2x from '../../images/hrh-map_icon@2x.png';
import hrh_hotels from '../util/hrhData';

export default {
  init: function() {

    jQuery('.hr-loadmore').click(() => {
      var data = {
        'action': 'loadmore',
        'query': hr_loadmore_params.posts,
        'page': hr_loadmore_params.current_page,
      };

      jQuery.ajax({
        url: hr_loadmore_params.ajaxurl,
        data: data,
        method: 'POST',
        beforeSend: () => jQuery('.hr-loadmore').text('Loading...'),
      })
      .done( data => {
        if( data ) {
          jQuery('.hr-loadmore').text('Load More').closest('.col-sm-12').before(data);
          hr_loadmore_params.current_page++;
          if(hr_loadmore_params.current_page == hr_loadmore_params.max_page) {
            jQuery('.hr-loadmore').remove();
          }
        } else {
          jQuery('.hr-loadmore').remove();
        }
      })
      .fail( err => {
        jQuery('.hr-loadmore').remove();
        console.error(err);
      });
    });


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
      html: '<div class="cc-map-marker"><img class="img-fluid" src="' + map_icon + '" srcset="'+ map_icon +' 1x, ' + map_icon_2x + ' 2x" /></div>',
      iconSize: [34, 50],
        iconAnchor: [18, 49],
        popupAnchor: [0, -26],
    });

    var hrhIcon = L.divIcon({
      html: '<div class="hrh-map-marker"><img class="img-fluid" src="' + hrh_icon + '" srcset="'+ hrh_icon +' 1x, ' + hrh_icon_2x + ' 2x" /></div>',
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

      let hotel_markers = L.featureGroup();
      for(var x = 0; x < hrh_hotels.hotels.length; x++) {
        var hotel = hrh_hotels.hotels[x];
        var hotel_place = L.marker([hotel.lat, hotel.lng],{icon:hrhIcon, riseOnHover:true, riseOffset: 3000});
        hotel_place.bindPopup('<div class="cc-marker__popup"><div class="font-weight-bold">'+hotel.name+'</div><div>'+hotel.address+'<br>'+hotel.address_two+'</div><div><a href="'+hotel.website+'" target="_blank"><span class="fa fa-window-maximize"></span> website</a></div></div>');
        hotel_markers.addLayer(hotel_place);
        hotel.marker_id = hotel_markers.getLayerId(hotel_place);
        jQuery('#'+hotel.location_id).attr('data-cc-marker', hotel.marker_id);
        jQuery('#'+hotel.location_id).addClass(hotel.marker_id);
      }
      hotel_markers.addTo(map);

      markers = L.featureGroup();
      for(x = 0; x < parsed_map_vars.locations.length; x++) {
        var feature = parsed_map_vars.locations[x];
        var marker_place = L.marker([feature.coords.lat, feature.coords.lng],{icon:ccIcon, riseOnHover:true, riseOffset: 3000});
        marker_place.bindPopup('<div class="cc-marker__popup"><div class="font-weight-bold">'+feature.title+'</div><div>'+feature.address +'</div><div><a href="'+feature.directions+'" rel="external" target="_blank" class="text-capitalize"><i class="fa fa-map"></i> directions</a></div></div>');
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
