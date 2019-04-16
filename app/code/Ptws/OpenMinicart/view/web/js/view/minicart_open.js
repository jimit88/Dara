define(["jquery/ui","jquery"], function(Component, $){
										console.log('minicart_open-1'); 
	return function(config, element){
		var minicart = $(element);
		minicart.on('contentLoading', function () {
			minicart.on('contentUpdated', function () {
				minicart.find('[data-role="dropdownDialog"]').dropdownDialog("open");
				console.log('minicart_open-2'); 
			});
		});
	}
});