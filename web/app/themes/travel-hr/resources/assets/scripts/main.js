// import external dependencies
import 'jquery';
import 'waypoints/lib/jquery.waypoints';

// Import everything from autoload
import './autoload/**/*'

// import local dependencies
import Router from './util/Router';
import common from './routes/common';
import home from './routes/home';
import aboutUs from './routes/about';
import single from './routes/single';
import archive from './routes/archive';

/** Populate Router instance with DOM routes */
const routes = new Router({
  // All pages
  common,
  // Home page
  home,
  // About Us page, note the change from about-us to aboutUs.
  aboutUs,
  single,
  archive,
});

// Load Events
jQuery(document).ready(() => routes.loadEvents());
