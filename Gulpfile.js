var elixir = require('laravel-elixir');
elixir(function(mix) {
  mix.scripts([
    'jquery-3.2.1.min.js',
    'ui/jquery-ui.min.js'
  ]);
});
elixir(function(mix) {
    mix.styles([
        'app.css',
        'jquery-ui.min.css',
        'makintour.css'
    ]);
});
elixir(function(mix) {
    mix.version(['css/all.css', 'js/all.js']);
});