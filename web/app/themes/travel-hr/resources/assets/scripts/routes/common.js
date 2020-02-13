/* eslint-disable no-undef */
import 'waypoints/lib/shortcuts/sticky';
import haversine from '../util/haversine';
import _ from 'underscore/underscore-min';


export default {
  init() {
    // JavaScript to be fired on all pages
    var $stickyElement = jQuery('.travel__navigation');
    var sticky;

    if ($stickyElement.length) {
      sticky = new Waypoint.Sticky({
        element: $stickyElement[0],
        wrapper: '<div class="sticky-wrapper waypoint" />',
      });
      jQuery('button.destroy-sticky').on('click', function() {
        sticky.destroy();
      });
    }

    var $mapStickyElement = jQuery('.travel__detail__map__map-wrapper');
    // eslint-disable-next-line no-unused-vars
    var mapSticky;

    if ($mapStickyElement.length) {
      mapSticky = new Waypoint.Sticky({
        stuckClass: 'map-stuck',
        element: $mapStickyElement[0],
        wrapper: '<div class="sticky-wrapper waypoint" />',
        offset: 48,
      });
      jQuery('button.destroy-sticky').on('click', function() {
        sticky.destroy();
      });
    }

    jQuery('.travel__navigation__button--browse').click( function() {
      jQuery('.travel__slideout-menu').toggleClass('open');
      jQuery('#panel').toggleClass('avoid-clicks');
    } );

    jQuery('.travel__slideout-menu-close').click( function() {
      jQuery('.travel__slideout-menu').toggleClass('open');
      jQuery('#panel').toggleClass('avoid-clicks');
    } );

    jQuery('.navbar-toggler').click(function() {
      jQuery('.navbar__slideout-menu').toggleClass('open');
      jQuery('#panel').toggleClass('avoid-clicks');
    });

    function success(position) {
      var latitude  = position.coords.latitude;
      var longitude = position.coords.longitude;
      var coords = {
        latitude: latitude,
        longitude: longitude,
      };
      var sortedCities = _.sortBy(map_info.cities, function( city ) {
        var cityCoords = {
          latitude: city.location.lat,
          longitude: city.location.lng,
        };
        return haversine(coords, cityCoords);
      });
      var closestCity = sortedCities[0];
      window.location = closestCity.link;
    }

    function error() {
      console.warn('Unable to retrieve your location');
    }

    jQuery('.travel__navigation__button--near-me').click(function (e) {
      e.preventDefault();
      navigator.geolocation.getCurrentPosition(success, error);
    });

    jQuery('.dropdown').on('show.bs.dropdown', function () {
      if(jQuery('.travel.travel__navigation.stuck').length > 0) {
        var menu_position = jQuery('.travel.travel__navigation').outerHeight(true);
      } else {
        menu_position = jQuery('.travel.travel__navigation').offset().top + jQuery('.travel.travel__navigation').outerHeight(true);
      }

      jQuery(this).find('.dropdown-menu').css('top', menu_position);
    });
  },
  finalize() {
    // JavaScript to be fired on all pages, after page specific JS is fired
  },
};
